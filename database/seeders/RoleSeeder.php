<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles using firstOrCreate
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $technician = Role::firstOrCreate(['name' => 'technician']);
        $coordinator = Role::firstOrCreate(['name' => 'coordinator']);

        // Define permissions
        $permissions = [
            'manage users',
            'create crops',
            'update crops',
            'delete crops',
            'view reports',
            'create farmers',
            'update farmers',
            'delete farmers',
            'view farmers',
            'create associations',
            'update associations',
            'delete associations',
            'view associations',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to admin
        $admin->syncPermissions(Permission::all());

        // Assign specific permissions to technician
        $technician->syncPermissions([
            'create crops', 'update crops', 'view reports',
            'create farmers', 'update farmers', 'view farmers', 'view associations'
        ]);

        // Assign specific permissions to coordinator
        $coordinator->syncPermissions(['view reports', 'view farmers']);
    }
}
