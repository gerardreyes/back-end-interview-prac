<?php

use Illuminate\Support\Facades\Route;
// Import ProductController here so you do not have to put the whole path when using it.
use App\Http\Controllers\ProductController;

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

/*
 * Part 1:
 * Use Named routes like ->name('products.index') to make it easier to generate URLs and redirect.

 * Use Route::resource() like Route::delete to define routes in a more concise and RESTful manner.
*/

Route::redirect('/', '/products'); // Use Route::redirect() method to handle the root URL redirection.

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
