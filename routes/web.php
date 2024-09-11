<?php

use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\ProfileController;
use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/users', function(){
    return User::with('albums')->paginate(100);
});

Route::resource('albums', AlbumsController::class);
Route::get('/albums/{album}/images', [AlbumsController::class, 'getImages'])->name('albums.images');
// Route::delete('/albums/{album}/delete', [AlbumsController::class, 'delete']);

Route::get('/photo', function(){
    return Photo::paginate(5);
});

Route::resource('photos', PhotosController::class);

// Route::get('usersnoalbums', function(){
//     $usersnoalbum = DB::table('users as u')
//     ->leftJoin('albums as a', 'u.id', 'a.user_id')
//     ->select('u.id','email','name')
//     ->whereNull('album_name')
//     ->get();
//     return $usersnoalbum;
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
