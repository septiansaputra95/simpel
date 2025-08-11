<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permission
        $permissions = [
            'akses permintaan',
            'akses pengeluaran',
            'akses barang',
            'akses unit',
            'akses satuan',
            'akses honor',
            'akses dokter',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $keuangan = Role::firstOrCreate(['name' => 'keuangan']);
        $gudang = Role::firstOrCreate(['name' => 'user gudang']);

        // Assign permission ke role
        $admin->givePermissionTo(Permission::all());

        $keuangan->givePermissionTo([
            'akses honor',
            'akses dokter',
        ]);

        $gudang->givePermissionTo([
            'akses permintaan',
            'akses pengeluaran',
            'akses barang',
        ]);
    }
}
