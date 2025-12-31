<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MSatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_satuan' => 'BAL', 'nama_satuan' => 'BAL'],
            ['kode_satuan' => 'BH',  'nama_satuan' => 'BUAH'],
            ['kode_satuan' => 'BK',  'nama_satuan' => 'BUKU'],
            ['kode_satuan' => 'BKS', 'nama_satuan' => 'BUNGKUS'],
            ['kode_satuan' => 'BOX', 'nama_satuan' => 'BOX'],
            ['kode_satuan' => 'BTG', 'nama_satuan' => 'BATANG'],
            ['kode_satuan' => 'BTL', 'nama_satuan' => 'BOTOL'],
            ['kode_satuan' => 'DRM', 'nama_satuan' => 'DRUM'],
            ['kode_satuan' => 'DUS', 'nama_satuan' => 'DUS'],
            ['kode_satuan' => 'GL',  'nama_satuan' => 'GULUNG'],
            ['kode_satuan' => 'GLN', 'nama_satuan' => 'GALON'],
            ['kode_satuan' => 'GRO', 'nama_satuan' => 'GROS'],
            ['kode_satuan' => 'IKA', 'nama_satuan' => 'IKAT'],
            ['kode_satuan' => 'KG',  'nama_satuan' => 'KILOGRAM'],
            ['kode_satuan' => 'KL',  'nama_satuan' => 'KALENG'],
            ['kode_satuan' => 'KTT', 'nama_satuan' => 'KOTAK'],
            ['kode_satuan' => 'LB',  'nama_satuan' => 'LEMBAR'],
            ['kode_satuan' => 'LS',  'nama_satuan' => 'LUSIN'],
            ['kode_satuan' => 'LTR', 'nama_satuan' => 'LITER'],
            ['kode_satuan' => 'MT',  'nama_satuan' => 'METER'],
            ['kode_satuan' => 'PAK', 'nama_satuan' => 'PAK'],
            ['kode_satuan' => 'PCS', 'nama_satuan' => 'PIECES'],
            ['kode_satuan' => 'PHI', 'nama_satuan' => 'PHIL'],
            ['kode_satuan' => 'PSG', 'nama_satuan' => 'PASANG'],
            ['kode_satuan' => 'RIM', 'nama_satuan' => 'RIM'],
            ['kode_satuan' => 'ROL', 'nama_satuan' => 'ROL'],
            ['kode_satuan' => 'SCH', 'nama_satuan' => 'SACHET'],
            ['kode_satuan' => 'SET', 'nama_satuan' => 'SET'],
            ['kode_satuan' => 'YAR', 'nama_satuan' => 'YARD'],
            ['kode_satuan' => 'ZAK', 'nama_satuan' => 'ZAK'],
            ['kode_satuan' => 'UNT', 'nama_satuan' => 'UNIT'],
        ];

        foreach ($data as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        DB::table('m_units')->insertOrIgnore($data);
    }
}
