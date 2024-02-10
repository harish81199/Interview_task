<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::redirect('/dashboard', '/sales');


// coffee sales routes
// Added By Harish Bommena
Route::middleware('auth')->group(function () {
    Route::get('/sales','App\Http\Controllers\CoffeeSalesController@index')->name('coffee.sales'); // coffee sales page
    Route::get('/coffee-sales','App\Http\Controllers\CoffeeSalesController@salesList')->name('coffee.salesList'); // fetching records from DB
    Route::post('/coffee-sales','App\Http\Controllers\CoffeeSalesController@SalesPost')->name('coffee.salesPost'); // saving records to the DB
});
Route::get('/shipping-partners', function () {
    return view('shipping_partners');
})->middleware(['auth'])->name('shipping.partners');

require __DIR__.'/auth.php';
