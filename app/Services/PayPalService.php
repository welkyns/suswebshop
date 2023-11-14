<?php 

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use Mockery\Exception;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\Details;
use PayPal\Api\ItemList;
use PayPal\Rest\ApiContext;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;

class PayPalService
{
    protected $payPal;

    public function __construct()
    {
        if (config('settings.paypal_client_id') == '' || config('settings.paypal_secret_id') == '') {
            return redirect()->back()->with('error', 'No PayPal settings found.');
        }
            //generar id y clave- 
        $this->payPal = new ApiContext(
            new OAuthTokenCredential(
                config('settings.paypal_client_id'),
                config('settings.paypal_secret_id')
            )
        );
    }
    //PROCESAR PAGO
    public function processPayment($order)
    {
        // si se cobrara por envio se añadiria el importe de envio
        $shipping = sprintf('%0.2f', 0);
        //  cualquier importe de impuestos se añadira depende de tal regla fiscal
        $tax = sprintf('%0.2f', 0);
        //nueva instancia pagante
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
         // agregar articulos a la lista de pedido
        $items = array();
        foreach ($order->items as $item)
        {
            $orderItems[$item->id] = new Item();
            $orderItems[$item->id]->setName($item->product->name)
                ->setCurrency(config('settings.currency_code'))
                ->setQuantity($item->quantity)
                ->setPrice(sprintf('%0.2f', $item->price));

            array_push($items, $orderItems[$item->id]);
        }
        $itemList = new ItemList();
        $itemList->setItems($items);
        //configuración de detalles de envío
        $details = new Details();
        $details->setShipping($shipping)
            ->setTax($tax)
            ->setSubtotal(sprintf('%0.2f', $order->grand_total));
        // crear monto a cobrar
        $amount = new Amount();
        $amount->setCurrency(config('settings.currency_code'))
            ->setTotal(sprintf('%0.2f', $order->grand_total))
            ->setDetails($details);
        //creando trabsanccion
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription($order->user->full_name)
            ->setInvoiceNumber($order->order_number);
        //config de urls de redireccionamiento
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('checkout.payment.complete'))
                ->setCancelUrl(route('checkout.index'));
        //creando instancia de pago
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

            try {

                $payment->create($this->payPal);
            
            } catch (PayPalConnectionException $exception) {
                //echo $exception->getCode();
                //echo $exception->getData();
                Log::error($exception->getCode()); // Registra el código de error
                Log::error($exception->getData()); // Registra el mensaje de error detallado

                exit(1);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                exit(1);
            }
            
            $approvalUrl = $payment->getApprovalLink();
            
            //header("Location: {$approvalUrl}");
            return redirect()->away($approvalUrl);
            exit;
    }
    //FINALIZAR PAGO
    public function completePayment($paymentId, $payerId)
    {
        $payment = Payment::get($paymentId, $this->payPal);
        $execute = new PaymentExecution();
        $execute->setPayerId($payerId);

        try {
            $result = $payment->execute($execute, $this->payPal);
        } catch (PayPalConnectionException $exception) {
            $data = json_decode($exception->getData());
            $_SESSION['message'] = 'Error, '. $data->message;
            /*log error 1
                error_log('PayPal Connection Error: ' . $data->message, 0);
            log error 2
                $to = 'admin@example.com';
                $subject = 'PayPal Connection Error';
                $message = 'Error details: ' . $data->message;
                mail($to, $subject, $message);
            log error 3
            echo 'Lo sentimos, ha ocurrido un error al procesar su pago. Por favor, inténtelo de nuevo más tarde.';
            */
            exit;
        }

        if ($result->state === 'approved') {
            $transactions = $result->getTransactions();
            $transaction = $transactions[0];
            $invoiceId = $transaction->invoice_number;

            $relatedResources = $transactions[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            $saleId = $sale->getId();

            $transactionData = ['salesId' => $saleId, 'invoiceId' => $invoiceId];

            return $transactionData;
        } else {
            echo "<h3>".$result->state."</h3>";
            var_dump($result);
            exit(1);
        }
    }
}