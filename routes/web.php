<?php

use App\Models\Meme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\myController;

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
    $memes = Meme::where('statut', 1)->orderBy('updated_at', 'desc')->where('statut', 1)->paginate(10);

    return view('home', ['memes' => $memes]);
})->name('home');

// Route::group(['middleware' => ['auth']], function() {

    Route::get('/devenir-admin', [myController::class, 'becomeAdmin'])->name('becomeAdmin');
    Route::post('/devenir-admin', [myController::class, 'register'])->name('register');
    
    Route::get('/se-connecter', [myController::class, 'loginVue'])->name('loginVue');
    Route::post('/se-connecter', [myController::class, 'login'])->name('login');
    
    Route::get('/admin/home', [myController::class, 'adminHome'])->name('adminHome');

    Route::get('/logout', function(){
        Auth::logout();
        $info = "Vous vous ếtes déconnectés !";
        return redirect()->route('home')->with('info', $info);
    })->name('logout');

    Route::get('/admin/admins-list', [myController::class, 'admins'])->name('admins');
    Route::post('/disableAdmin/{id}', [myController::class, 'disableAdmin'])->name('disableAdmin');
    Route::post('/ableAdmin/{id}', [myController::class, 'ableAdmin'])->name('ableAdmin');
    
    Route::get('/publier-meme', [myController::class, 'postMemeView'])->name('postMemeView');
    Route::post('/publier-meme', [myController::class, 'postMeme'])->name('postMeme');
    
    Route::get('/mes-publications', [myController::class, 'myPost'])->name('myPost');

    Route::get('/modifier-meme/{id}', [myController::class, 'updateMeme'])->name('updateMeme');
    Route::post('/modifier-meme/{id}', [myController::class, 'updateMemePost'])->name('updateMemePost');
    Route::post('/deletePost/{id}', [myController::class, 'deletePost'])->name('deletePost');
    Route::post('/meme/{id}/like', [myController::class, 'toggleLike'])->name('toggleLike');
    
    Route::get('/admin/profile', [myController::class, 'profile'])->name('profile');
    Route::post('/admin/profile', [myController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/admin/profile/password', [myController::class, 'updatePassword'])->name('updatePassword');


    
// });


