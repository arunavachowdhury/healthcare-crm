<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DoctorAppointmentController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PaitientAppointmentController;
use App\Http\Controllers\Api\PaitientAuditController;
use App\Http\Controllers\Api\PaitientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', LoginController::class);

Route::resource('paitient', PaitientController::class)
    ->middleware([
        'auth:sanctum',
        'role:'.UserRole::ADMIN->value.'|'.UserRole::AGENT->value,
    ]);

Route::post('doctor', [DoctorController::class, 'store'])
    ->middleware([
        'auth:sanctum',
        'role:'.UserRole::ADMIN->value.'|'.UserRole::MANAGER->value,
    ]);

Route::resource('appointment', AppointmentController::class)
    ->except(['create', 'edit', 'show']);

Route::get('appointments/paitient/{paitient}', PaitientAppointmentController::class)
    ->middleware([
        'auth:sanctum',
        'role:'.UserRole::ADMIN->value.'|'.UserRole::AGENT->value.'|'.UserRole::PAITIENT->value.'|'.UserRole::DOCTOR->value,
    ]);
Route::get('appointments/doctor/{doctor}', DoctorAppointmentController::class)
    ->middleware([
        'auth:sanctum',
        'role:'.UserRole::ADMIN->value.'|'.UserRole::AGENT->value.'|'.UserRole::DOCTOR->value,
    ]);

Route::get('paitients/{paitient}/audits', PaitientAuditController::class)
    ->middleware([
        'auth:sanctum',
        'role:'.UserRole::ADMIN->value,
    ]);
