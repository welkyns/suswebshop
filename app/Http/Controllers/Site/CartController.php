<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;

class CartController extends Controller
{
    use Cart;
    
    public function getCart()
    {
        return view('site.pages.cart');
    }
    //ELIMINAR PRODUCTO DEL CARRITO
    public function removeItem($id)
    {
        
        Cart::remove($id);

        if (Cart::isEmpty()) {
            return redirect('/');
        }

        return redirect()->back()->with('message', 'Item removed from cart successfully.');
    }
    //VACIAR CARRITO
    public function clearCart()
    {
        Cart::clear();
        
        return redirect('/');
    }
}
