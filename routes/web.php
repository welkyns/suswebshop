<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//PAGINA INICIO
Route::view('/', 'site.pages.homepage');
//PAGINA CATEGORIA X
Route::get('/category/{slug}', 'Site\CategoryController@show')->name('category.show');
//PRESENTACION DEL PRODUCTO->CATEGORIA X
Route::get('/product/{slug}', 'Site\ProductController@show')->name('product.show');


Route::group(['middleware' => ['auth']], function () {
//SOLO USUARIOS AUTENTICADOS
    //AÑADIR AL CARRITO
    Route::post('/product/add/cart', 'Site\ProductController@addToCart')->name('product.add.cart');
    //CONTROL CARRITO
    Route::get('/cart', 'Site\CartController@getCart')->name('checkout.cart');
    Route::get('/cart/item/{id}/remove', 'Site\CartController@removeItem')->name('checkout.cart.remove');
    Route::get('/cart/clear', 'Site\CartController@clearCart')->name('checkout.cart.clear');
    //CHECKOUT Y PEDIDOS
    Route::get('/checkout', 'Site\CheckoutController@getCheckout')->name('checkout.index');
    Route::post('/checkout/order', 'Site\CheckoutController@placeOrder')->name('checkout.place.order');
    //PAGOS
    Route::get('checkout/payment/complete', 'Site\CheckoutController@complete')->name('checkout.payment.complete');
    //PEDIDOS DEL CLIENTE
    Route::get('account/orders', 'Site\AccountController@getOrders')->name('account.orders');
});

require 'admin.php';
Auth::routes();