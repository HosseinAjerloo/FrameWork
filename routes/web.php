<?php
use System\Router\Web\Route;
Route::get('',[App\Http\Controllers\HomeController::class,'index'])->name('home.index');