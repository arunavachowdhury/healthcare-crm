<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        $adminRole = Role::create(['name' => UserRole::ADMIN]);
        $agentRole = Role::create(['name' => UserRole::AGENT]);
        $doctorRole = Role::create(['name' => UserRole::DOCTOR]);
        $paitientRole = Role::create(['name' => UserRole::PAITIENT]);
        $managerRole = Role::create(['name' => UserRole::MANAGER]);

        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@yopmail.com',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        $adminUser->assignRole(UserRole::ADMIN);

        $agentUser = User::create([
            'name' => 'Agent User',
            'email' => 'agent@yopmail.com',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        $agentUser->assignRole(UserRole::AGENT);

        $doctorUser = User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@yopmail.com',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        $doctorUser->assignRole(UserRole::DOCTOR);

        $paitientUser = User::create([
            'name' => 'Paitient User',
            'email' => 'paitient@yopmail.com',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        $paitientUser->assignRole(UserRole::PAITIENT);

        $managerUser = User::create([
            'name' => 'Manager User',
            'email' => 'manager@yopmail.com',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        $managerUser->assignRole(UserRole::MANAGER);
    }
}
