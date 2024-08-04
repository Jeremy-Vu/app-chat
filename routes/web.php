<?php

use App\Events\MessageSent;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
});



Route::get('login/{id}', function ($id) {
    Auth::loginUsingId($id);

    return back();
});

Route::get('logout', function () {
    Auth::logout();

    return back();
});


Route::get('chat', [ChatController::class, 'index'])->name('chat.index');

Route::post('message', [ChatController::class, 'message'])->name('message');
Route::get('messages', [ChatController::class, 'allMessage'])->name('all-message');

Route::get('users', function (){
    return User::all();
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
