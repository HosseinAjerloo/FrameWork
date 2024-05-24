<?php
use System\Router\Web\Route;
Route::get('/{id}/{hossein}',[App\Http\Controllers\HomeController::class,'index'])->name('home.index');