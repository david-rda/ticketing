<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Api\UserController;

Route::post("/login", [AuthController::class, "Login"]);
Route::post("/logout", [LogoutController::class, "Logout"]);

Route::post("/insert", [UserController::class, "Insert_Users"]); // მომხმარებლების ატვირთვის მარშუტი



?>