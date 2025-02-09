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
        // Define roles
        $admin = Role::create(['name' => 'admin']);
        $technician = Role::create(['name' => 'technician']);
        $coordinator = Role::create(['name' => 'coordinator']);

        // Define permissions
        $permissions = [
            'manage users',
            'create crops',
            'update crops',
            'delete crops',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to admin
        $admin->givePermissionTo(Permission::all());

        // Assign specific permissions to technician
        $technician->givePermissionTo(['create crops', 'update crops', 'view reports']);

        // Assign specific permissions to coordinator
        $coordinator->givePermissionTo(['view reports']);
    }
}
