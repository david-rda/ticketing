<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PriorityController;
use App\Http\Controllers\Api\TasksController;
use App\Http\Controllers\Api\StatusController;

Route::post("/login", [AuthController::class, "Login"]);
Route::post("/logout", [LogoutController::class, "Logout"]);

Route::group(["prefix" => "user", "middleware" => "auth:api"], function() {
    Route::post("/insert", [UserController::class, "Insert_Users"]); // მომხმარებლების ატვირთვის მარშუტი

    Route::get("/list", [UserController::class, "User_List"]); // მომხმარებლის სიის წამოღების მარშუტი

    Route::put("/password/change", [UserController::class, "Change_Password"]); // პაროლის ცვლილების მარშუტი
});


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
    Route::post("/add", [TasksController::class, "Add_Task"]); // სტატუსების სიის წამოღების მარშუტი

    Route::delete("/delete/{id}", [TasksController::class, "Task_Delete"])->where(["id" => "[0-9]+"]); // თასქის წაშლის მარშუტი

    Route::get("/list", [TasksController::class, "Task_List"]); // თასქების სიის მარსუტი
});

?>