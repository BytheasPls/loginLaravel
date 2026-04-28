<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;


Route::post('/login', [UserController::class, 'postLogin']);
Route::post('/register', [UserController::class, 'postRegister']);
