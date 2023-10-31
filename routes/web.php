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
//AÑADIR AL CARRITO
Route::post('/product/add/cart', 'Site\ProductController@addToCart')->name('product.add.cart');

require 'admin.php';
Auth::routes();