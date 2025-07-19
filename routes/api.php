<?php

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PaitientController;
use App\Http\Controllers\Api\AppointmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', LoginController::class);

Route::resource('paitient', PaitientController::class)
    ->middleware([
        'auth:sanctum',
        'role:'.UserRole::ADMIN->value.'|'.UserRole::AGENT->value
    ]);

Route::post('doctor', [DoctorController::class, 'store'])
    ->middleware([
        'auth:sanctum',
        'role:'.UserRole::ADMIN->value.'|'.UserRole::MANAGER->value
    ]);

Route::resource('appointment', AppointmentController::class)
        ->except(['create', 'edit', 'show'])
        ->middleware([
            'auth:sanctum',
            'role:'.UserRole::ADMIN->value.'|'.UserRole::AGENT->value
        ]);
