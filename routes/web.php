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

Route::get('/', 'App\Http\Controllers\PostController@index')->name('home');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('login/{provider}','App\Http\Controllers\Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback','App\Http\Controllers\Auth\SocialAccountController@handleProviderCallback');
Route::get('register/{provider}','App\Http\Controllers\Auth\UserController@redirectToProvider');
Route::get('register/{provider}/callback','App\Http\Controllers\Auth\UserController@handleProviderCallback');
Route::get('create', 'App\Http\Controllers\PostController@create');
Route::post('store', 'App\Http\Controllers\PostController@store');
Route::get('/posts/{id}', 'App\Http\Controllers\PostController@show')->name('post.show');
Route::delete('/posts/del/{id}', 'App\Http\Controllers\PostController@destroy');
Route::post('/comment/{id}', 'App\Http\Controllers\PostController@storeComment')->name('post.comment')->middleware('auth');
Route::get('/users/{id}', 'App\Http\Controllers\UserController@show')->name('user.show');
Route::get('users/{id}/form', 'App\Http\Controllers\UserController@form');
Route::post('users/{id}/follow', 'App\Http\Controllers\UserController@follow')->name('follow.user')->middleware('auth');
Route::post('users/{id}/unfollow', 'App\Http\Controllers\UserController@Unfollow')->name('unfollow.user')->middleware('auth');
Route::put('users/{id}/update', 'App\Http\Controllers\UserController@update');
Route::get('payment/index/{id}', 'App\Http\Controllers\PostController@getPaymentPage')->name('payment.page')->middleware('auth');
Route::get('payment/tip/{id}', 'App\Http\Controllers\PostController@getTipPayment')->name('payment.tip')->middleware('auth');
Route::post('/payment/done/{id}','App\Http\Controllers\PostController@donePayment')->name('payment.done')->middleware('auth');
Route::post('payment/tip/done/{id}', 'App\Http\Controllers\PostController@doneTipPayment')->name('tip.done')->middleware('auth');
Route::get('/payment/form','App\Http\Controllers\PaymentController@getPaymentForm')->name('payment.form')->middleware('auth');
Route::post('/payment/store', 'App\Http\Controllers\PaymentController@storePaymentInfo')->name('payment.store')->middleware('auth');
Route::post('/payment/destroy','App\Http\Controllers\PaymentController@deletePaymentInfo')->name('payment.destroy')->middleware('auth');
Route::get('/{category_id}', 'App\Http\Controllers\PostController@filter_categories');
Route::get('/category/trend', 'App\Http\Controllers\PostController@popular_posts');
Route::post('category/edit', 'App\Http\Controllers\PostController@editCategory');
Route::post('/like/{id}','App\Http\Controllers\PostController@switchLike')->name('like_post')->middleware('auth');
Route::post('/unlike/{id}','App\Http\Controllers\PostController@switchUnlike')->name('unlike_post');
Route::get('/follows/list/{id}',  'App\Http\Controllers\UserController@getFollowsList')->name('follows_list');