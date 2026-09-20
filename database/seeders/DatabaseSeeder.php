<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Position;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $hr = Role::firstOrCreate(['name' => 'HR']);
        $employee = Role::firstOrCreate(['name' => 'Employee']);

        // Create permissions
        $permissions = ['create users', 'edit users', 'delete users', 'view reports'];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Assign permissions to roles
        $admin->givePermissionTo(['create users', 'edit users', 'delete users', 'view reports']);
        $hr->givePermissionTo(['create users', 'view reports']);
        $employee->givePermissionTo(['view reports']);

        // Create positions mapped to roles
        Position::firstOrCreate(['title' => 'System Administrator', 'role_id' => $admin->id]);
        Position::firstOrCreate(['title' => 'HR Manager', 'role_id' => $hr->id]);
        Position::firstOrCreate(['title' => 'Sales Executive', 'role_id' => $employee->id]);

        // Assign Admin role to Saman Fatima if she exists
        $saman = User::where('email', 'samanfatima@gmail.com')->first();
        if ($saman) {
            $saman->assignRole('Admin');
        }
    }
}