<?php

use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('admin/dashboard', function() {
    dd('Admin');
})->middleware(['auth', 'role:'.UserRole::ADMIN->value])->name('admin.dashboard');

Route::get('agent/dashboard', function() {
    dd('Agent');
})->middleware(['auth', 'role:'.UserRole::AGENT->value])->name('agent.dashboard');

Route::get('doctor/dashboard', function() {
    dd('Doctor');
})->middleware(['auth', 'role:'.UserRole::DOCTOR->value])->name('doctor.dashboard');

Route::get('paitient/dashboard', function() {
    dd('Paitient');
})->middleware(['auth', 'role:'.UserRole::PAITIENT->value])->name('paitient.dashboard');

Route::get('manager/dashboard', function() {
    dd('Manager');
})->middleware(['auth', 'role:'.UserRole::MANAGER->value])->name('manager.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
