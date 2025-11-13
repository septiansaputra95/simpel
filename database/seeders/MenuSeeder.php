<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MMenu; // tambahkan ini

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $master = MMenu::create([
            'parent_id' => null,
            'name'      => 'Master',
            'route'     => null,
            'icon'      => 'settings',
            'order_no'  => 1,
        ]);

        MMenu::create([
            'parent_id' => $master->id,
            'name'      => 'Master Dokter',
            'route'     => 'master.dokter.index',
            'icon'      => 'medical_services',
            'order_no'  => 1,
        ]);

        MMenu::create([
            'parent_id' => $master->id,
            'name'      => 'Master Barang',
            'route'     => 'master.barang.index',
            'icon'      => 'inventory',
            'order_no'  => 2,
        ]);

        MMenu::create([
            'parent_id' => $master->id,
            'name'      => 'Master Satuan',
            'route'     => 'master.satuan.index',
            'icon'      => 'straighten',
            'order_no'  => 3,
        ]);
    }
}
