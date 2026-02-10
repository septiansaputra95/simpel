@extends('layouts.newlayout')

@section('newcontent')

<div id="tab1" class="tab-content bg-gray-100 p-6">

    <div class="max-w-6xl mx-auto space-y-6">

        <!-- HEADER -->
        <h1 class="text-2xl font-bold text-gray-800">Form Permintaan Barang</h1>

        <!-- LIMIT INFO -->
        <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="text-blue-600 text-xl">ℹ️</div>
            <div>
                <p class="font-semibold text-blue-800">
                    Perhatian: Permintaan tidak boleh melebihi limit unit.
                </p>
                <p class="text-sm text-blue-700">
                    Limit unit Anda:
                    <span class="font-bold">Rp 10.000.000</span>
                </p>
            </div>
        </div>

        <!-- DETAIL PERMINTAAN -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Detail Permintaan
            </h2>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p><span class="font-semibold">No Permintaan:</span> PRM-001</p>
                    <p><span class="font-semibold">Tanggal:</span> 24-04-2024</p>
                    <p><span class="font-semibold">Pemohon:</span> Andi</p>
                    <p><span class="font-semibold">Unit:</span> ICU</p>
                </div>

                <div>
                    <p>
                        <span class="font-semibold">Status:</span>
                        <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs">
                            Proses
                        </span>
                    </p>
                    <p>
                        <span class="font-semibold">Keterangan:</span>
                        Pengadaan alat medis
                    </p>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-semibold mb-1">
                    Catatan
                </label>
                <textarea
                    class="w-full border rounded p-2 text-sm"
                    rows="3"
                    placeholder="Masukkan catatan..."></textarea>
            </div>

            <div class="flex justify-between items-center mt-6 border-t pt-4">
                <div>
                    <p class="text-sm text-gray-500">Total Permintaan</p>
                    <p class="text-xl font-bold">Rp 900.000</p>
                </div>

                <div class="flex gap-3">
                    <button
                        class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">
                        Simpan Draft
                    </button>
                    <button
                        class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Ajukan
                    </button>
                </div>
            </div>
        </div>

        <!-- DAFTAR BARANG -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Daftar Barang
            </h2>

            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-left">Nama Barang</th>
                        <th class="border p-2 text-left">Harga</th>
                        <th class="border p-2 text-center">Jumlah</th>
                        <th class="border p-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-2">Infus Set</td>
                        <td class="border p-2">Rp 100.000</td>
                        <td class="border p-2 text-center">
                            <input type="number" value="5"
                                class="w-16 border rounded text-center">
                        </td>
                        <td class="border p-2 text-right">Rp 500.000</td>
                    </tr>
                    <tr>
                        <td class="border p-2">Syringe 10ml</td>
                        <td class="border p-2">Rp 200.000</td>
                        <td class="border p-2 text-center">
                            <input type="number" value="2"
                                class="w-16 border rounded text-center">
                        </td>
                        <td class="border p-2 text-right">Rp 400.000</td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-between items-center mt-4">
                <button
                    class="px-3 py-2 border rounded text-sm hover:bg-gray-100">
                    + Tambah Barang
                </button>
                <p class="font-semibold">Total: Rp 900.000</p>
            </div>
        </div>

        <!-- RIWAYAT APPROVAL -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Riwayat Approval
            </h2>

            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 text-center">Level</th>
                        <th class="border p-2">Approver</th>
                        <th class="border p-2">Unit</th>
                        <th class="border p-2 text-center">Status</th>
                        <th class="border p-2">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-2 text-center">1</td>
                        <td class="border p-2">Manager Keperawatan</td>
                        <td class="border p-2">Keperawatan</td>
                        <td class="border p-2 text-center">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                                Menunggu
                            </span>
                        </td>
                        <td class="border p-2"></td>
                    </tr>
                    <tr>
                        <td class="border p-2 text-center">2</td>
                        <td class="border p-2">Wakil Direktur</td>
                        <td class="border p-2">Manajemen</td>
                        <td class="border p-2 text-center">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                                Menunggu
                            </span>
                        </td>
                        <td class="border p-2"></td>
                    </tr>
                    <tr>
                        <td class="border p-2 text-center">3</td>
                        <td class="border p-2">Direktur</td>
                        <td class="border p-2">Direksi</td>
                        <td class="border p-2 text-center">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                                Menunggu
                            </span>
                        </td>
                        <td class="border p-2"></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

@push('scripts')
@vite('resources/js/gudangumum/permintaan.js')
@endpush

@endsection
