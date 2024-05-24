<?php
use System\Router\Web\Route;
Route::get('create',[App\Http\Controllers\HomeController::class,'index'])->name('home.index');