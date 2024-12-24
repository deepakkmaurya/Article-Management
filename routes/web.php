<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //Permission
    Route::resource('permissions',PermissionController::class);
    Route::delete('/permissions',[PermissionController::class,'delete'])->name('permission.delete');
    
    //Role
    Route::resource('role',RoleController::class);
    // Route::delete('/role',[RoleController::class,'delete'])->name('permission.delete');
    
    //User
    Route::resource('users',UserController::class);

    //Article
    Route::resource('articles',ArticleController::class);
});

require __DIR__.'/auth.php';
