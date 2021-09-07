<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TopHeaderController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $category = Category::find(1);//for slider active
    $categories = Category::query()->Active()->index();
    return view('welcome',compact('category', 'categories'));
});

Auth::routes();

Route::get('/blog', function () {
    return view('home');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('contact/store', [App\Http\Controllers\User\ContactController::class, 'store']);

Route::group([ "as"=>'user.' , "prefix"=>'user' , "namespace"=>'User' , "middleware"=>['auth','user']],function(){
    Route::get('/dashboard', [App\Http\Controllers\User\UserDashboardController::class, 'index'])->name('dashboard');
});



Route::group([ "as"=>'admin.' , "prefix"=>'admin' , "middleware"=>['auth','admin']],function(){
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    //category
    Route::resource('category', CategoryController::class);
    Route::get('/category/search/{text}', [App\Http\Controllers\Admin\CategoryController::class, 'search']);
    Route::get('/category/status/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'status']);

    //product
    Route::resource('product', ProductController::class);
    Route::get('/product/status/{id}', [App\Http\Controllers\Admin\ProductController::class, 'status']);
    Route::post('/product/search', [App\Http\Controllers\Admin\ProductController::class, 'search']);
    //top headers
    Route::resource('topheader', TopHeaderController::class);
    //about
    Route::resource('about', AboutUsController::class);
    //slider
    Route::resource('slider', SliderController::class);
    //contact
    Route::resource('contact', ContactController::class);
    Route::get('/contact/status/{id}', [App\Http\Controllers\Admin\ContactController::class, 'status']);

});
