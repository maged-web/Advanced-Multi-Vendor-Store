<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use Illuminate\Support\Facades\Route;


Route::group([
'middleware'=>['auth:admin'/* ,'auth.type:admin,super-admin' */],
'as'=>'dashboard.',
'prefix'=>'admin/dashboard'
],function()
{
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    Route::delete('/categories/{category}',[CategoriesController::class,'destroy'])->name('categories.destroy');
    Route::put('/categories/{category}/restore',[CategoriesController::class,'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete',[CategoriesController::class,'forceDelete'])->name('categories.force-delete');
    Route::get('/categories/trashed',[CategoriesController::class,'trash'])->name('categories.trash');
    Route::get('/categories/trashed',[CategoriesController::class,'trash'])->name('categories.trash');
    Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'update'])->name('profile.update');

    Route::resource('/categories',CategoriesController::class);
    Route::resource('/products',ProductsController::class);


});
