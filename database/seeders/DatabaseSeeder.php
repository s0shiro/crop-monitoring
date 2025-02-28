<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call RoleSeeder first
        $this->call(RoleSeeder::class);

        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@dev.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Create Coordinators with Crop Categories
        $coordinator1 = User::firstOrCreate(
            ['email' => 'coordinator1@dev.com'],
            [
                'name' => 'Rice Coordinator',
                'password' => Hash::make('password'),
                'crop_category' => 'Rice'
            ]
        );
        $coordinator1->assignRole('coordinator');

        $coordinator2 = User::firstOrCreate(
            ['email' => 'coordinator2@dev.com'],
            [
                'name' => 'High-Value Crops Coordinator',
                'password' => Hash::make('password'),
                'crop_category' => 'High Value Crops'
            ]
        );
        $coordinator2->assignRole('coordinator');

        $coordinator3 = User::firstOrCreate(
            ['email' => 'coordinator3@dev.com'],
            [
                'name' => 'Corn Coordinator',
                'password' => Hash::make('password'),
                'crop_category' => 'Corn'
            ]
        );
        $coordinator3->assignRole('coordinator');

        // Create Technicians under Coordinators
        $technician1 = User::firstOrCreate(
            ['email' => 'technician1@dev.com'],
            [
                'name' => 'Technician 1',
                'password' => Hash::make('password'),
                'coordinator_id' => $coordinator1->id
            ]
        );
        $technician1->assignRole('technician');

        $technician2 = User::firstOrCreate(
            ['email' => 'technician2@dev.com'],
            [
                'name' => 'Technician 2',
                'password' => Hash::make('password'),
                'coordinator_id' => $coordinator2->id
            ]
        );
        $technician2->assignRole('technician');

        $technician3 = User::firstOrCreate(
            ['email' => 'technician3@dev.com'],
            [
                'name' => 'Technician 3',
                'password' => Hash::make('password'),
                'coordinator_id' => $coordinator3->id
            ]
        );
        $technician3->assignRole('technician');

        $admin->syncPermissions(Permission::all());
        $coordinator1->syncPermissions(['view reports', 'view farmers']);
        $coordinator2->syncPermissions(['view reports', 'view farmers']);
        $coordinator3->syncPermissions(['view reports', 'view farmers']);
        $technician1->syncPermissions([
            'create crops', 'update crops', 'view reports',
            'create farmers', 'update farmers', 'view farmers'
        ]);
        $technician2->syncPermissions([
            'create crops', 'update crops', 'view reports',
            'create farmers', 'update farmers', 'view farmers'
        ]);
        $technician3->syncPermissions([
            'create crops', 'update crops', 'view reports',
            'create farmers', 'update farmers', 'view farmers'
        ]);

        $categories = ['Rice', 'Corn', 'High Value Crops'];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
