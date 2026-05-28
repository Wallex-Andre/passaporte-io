<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');


/*use Illuminate\Support\Facades\Route;

 Route::get('/', function () {
    return view('welcome');
});
*/