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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/article', [App\Http\Controllers\ArticleController::class, 'index'])->name('article');
Route::get('/article/new', [App\Http\Controllers\ArticleController::class, 'create'])->name('article.new');
Route::post('/article/new', [App\Http\Controllers\ArticleController::class, 'store'])->name('article.new');
Route::get('/article/update/{id}', [App\Http\Controllers\ArticleController::class, 'edit'])->name('article.edit');
Route::post('/article/update/{id}', [App\Http\Controllers\ArticleController::class, 'update'])->name('article.edit');
Route::get('/article/show/{slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('article.show');
Route::get('/article/del/{id}', [App\Http\Controllers\ArticleController::class, 'destroy'])->name('article.del');
