<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
