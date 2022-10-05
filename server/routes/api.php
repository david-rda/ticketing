<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PriorityController;

Route::post("/login", [AuthController::class, "Login"]);
Route::post("/logout", [LogoutController::class, "Logout"]);

Route::post("/insert", [UserController::class, "Insert_Users"]); // მომხმარებლების ატვირთვის მარშუტი

Route::group(["prefix" => "priority", "middleware" => "auth:api"], function() {
    Route::get("/list", [PriorityController::class, "Priority_List"]); // პრიორიტეტების სიის წამოღების მარშუტი

    Route::delete("/delete/{id}", [PriorityController::class, "Priority_Delete"])->where(["id" => "[0-9]+"]); // პრიორიტეტის წაშლის მარშუტი

    Route::post("/add", [PriorityController::class, "Priority_Add"]); // პრიორიტეტის დამატების მარშუტი
});

Route::group(["prefix" => "status", "middleware" => "auth:api"], function() {
    Route::get("/list", [StatusController::class, "Status_List"]); // სტატუსების სიის წამოღების მარშუტი

    Route::delete("/delete/{id}", [StatusController::class, "Status_Delete"])->where(["id" => "[0-9]+"]); // სტატუსის წაშლის მარშუტი

    Route::post("/add", [StatusController::class, "Status_Add"]); // სტატუსის დამატების მარშუტი
});

Route::group(["prefix" => "task", "middleware" => "auth:api"], function() {
    Route::get("/add", [TaskController::class, "Add_Task"]); // სტატუსების სიის წამოღების მარშუტი

    Route::delete("/delete/{id}", [TaskController::class, "Task_Delete"])->where(["id" => "[0-9]+"]); // თასქის წაშლის მარშუტი

    Route::post("/by_status/{id}", [TaskController::class, "Task_By_Status"])->where(["id" => "[0-9]+"]); // თასქების წამოღების მარშუტი სტატუსების მიხედვით
});

?>