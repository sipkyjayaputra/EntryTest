<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AccountsController;

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
    return redirect('/login');
});

Auth::routes([
    'register' => false
]);



Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Route Book
    Route::get('/book', [BookController::class, 'index'])->name('book.index');
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
    Route::post('/book/create', [BookController::class, 'store'])->name('book.store');
    Route::get('/book/show/{id}', [BookController::class, 'show'])->name('book.show');
    Route::get('/book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');
    Route::put('/book/edit/{id}', [BookController::class, 'update'])->name('book.update');
    Route::delete('/book/delete/{id}', [BookController::class, 'destroy'])->name('book.delete');
    Route::get('/book/data', [BookController::class, 'data'])->name('book.data');
    Route::get('/book/list-author', [BookController::class, 'listAuthor'])->name('list.author');

    //Route Author
    Route::get('/author', [AuthorController::class, 'index'])->name('author.index');
    Route::get('/author/create', [AuthorController::class, 'create'])->name('author.create');
    Route::post('/author/create', [AuthorController::class, 'store'])->name('author.store');
    Route::get('/author/show/{id}', [AuthorController::class, 'show'])->name('author.show');
    Route::get('/author/edit/{id}', [AuthorController::class, 'edit'])->name('author.edit');
    Route::put('/author/edit/{id}', [AuthorController::class, 'update'])->name('author.update');
    Route::delete('/author/delete/{id}', [AuthorController::class, 'destroy'])->name('author.delete');
    Route::get('/author/data', [AuthorController::class, 'data'])->name('author.data');
});

Route::post('reset_password_without_token', [AccountsController::class, 'validatePasswordRequest'])->name('password.reset.no.token');
Route::post('reset_password_with_token', [AccountsController::class, 'resetPassword'])->name('password.reset.token');
