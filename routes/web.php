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
//    broadcast(new \App\Events\DemoEvent('hello World'));
    return view('welcome');
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/chat', [App\Http\Controllers\HomeController::class, 'chat'])->name('chat');
Route::get('/message', [App\Http\Controllers\HomeController::class, 'allMessage'])->name('all.message');
Route::post('/message-send', [App\Http\Controllers\HomeController::class, 'postMessage'])->name('post.message');
Route::get('/private-chat', [App\Http\Controllers\HomeController::class, 'privateChat'])->name('private.chat');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('private.contact');
Route::get('/conversation/{id}', [App\Http\Controllers\HomeController::class, 'conversation'])->name('private.conversation');
Route::post('/conversation/send', [App\Http\Controllers\HomeController::class, 'conversationSend'])->name('conversation.send');
