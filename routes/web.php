<?php
use System\Router\Web\Route;
Route::get('{id}/create/{phone}/{code}',[App\Http\Controllers\HomeController::class,'index'])->name('home.index');