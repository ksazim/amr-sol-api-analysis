<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create product',
            'edit product',
            'delete product',
            'view product',
            'list product',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        // Create 2 users with a fixed password "987654321"
        $users = User::factory()->count(2)->create([
            'password' => Hash::make('987654321'), // Set the password for all users
        ]);

        // Assign roles
        $users[0]->assignRole('admin');
        $users[1]->assignRole('user');

        // Assign permissions
        $adminRole->givePermissionTo(Permission::all());
        $userRole->givePermissionTo(['view product']);
    }
}
