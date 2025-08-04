<?php

use App\Models\Blog;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TransactionController;
Route::get('/', function () {
    $blogs = Blog::latest()->get();
    // $blogs = auth()->user()->blogs()->latest()->get();
//    $blogs= Blog::where('user_id', auth()->id())->get();
    return view('home',['blogs' => $blogs]);
});

Route::post('/register', [UserController::class, 'register']);

Route::post('/logout', [UserController::class, 'logout']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/create-blog', [PostController::class, 'create_blog']);

Route::get('/edit-blog/{blog}',[PostController::class, 'showEditScreen']);

Route::post('/edit-blog/{blog}', [PostController::class, 'edit_blog']);

Route::delete('/delete-blog/{blog}', [PostController::class, 'delete_blog']);

Route::get('/finance', function () {
    return view('finance');
})->middleware('auth');

// Group these routes together and put the 'auth' bouncer on them
Route::middleware(['auth'])->group(function () {
    // When someone visits /transactions, show all transactions (only for logged-in user)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // When someone visits /transactions/create, show the form to add a new transaction
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');

    // When someone sends the form to /transactions, save the new transaction (linked to them)
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

});
