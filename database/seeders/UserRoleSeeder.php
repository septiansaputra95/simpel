<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // <--- penting ini
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        $keuangan = User::updateOrCreate(
            ['email' => 'keuangan@example.com'],
            [
                'name' => 'Keuangan',
                'username' => 'keuangan',
                'password' => Hash::make('password'),
            ]
        );
        $keuangan->assignRole('keuangan');

        $gudang = User::updateOrCreate(
            ['email' => 'gudang@example.com'],
            [
                'name' => 'Gudang',
                'username' => 'gudang',
                'password' => Hash::make('password'),
            ]
        );
        $gudang->assignRole('user gudang');
    }
}
