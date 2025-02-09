<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Define roles using findOrCreate instead of create
        $admin = Role::findOrCreate('admin');
        $technician = Role::findOrCreate('technician');
        $coordinator = Role::findOrCreate('coordinator');

        // Define permissions
        $permissions = [
            'manage users',
            'create crops',
            'update crops',
            'delete crops',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Assign all permissions to admin
        $admin->givePermissionTo(Permission::all());

        // Assign specific permissions to technician
        $technician->givePermissionTo(['create crops', 'update crops', 'view reports']);

        // Assign specific permissions to coordinator
        $coordinator->givePermissionTo(['view reports']);

        // Create users with roles
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@dev.com',
            'password' => Hash::make('password'),
        ])->assignRole('admin');

        User::create([
            'name' => 'Tech User',
            'email' => 'technician@dev.com',
            'password' => Hash::make('password'),
        ])->assignRole('technician');

        User::create([
            'name' => 'Coord User',
            'email' => 'coordinator@dev.com',
            'password' => Hash::make('password'),
        ])->assignRole('coordinator');
    }
}
