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
                    <span class="font-bold" id="unit-limit">Rp 10.000.000</span>
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
                    <p><span class="font-semibold">No Permintaan:</span> {{ $no_permintaan }}</p>
                    <p><span class="font-semibold">Tanggal:</span> {{ $tanggal }}</p>
                    <p><span class="font-semibold">Pemohon:</span> {{ $pemohon }}</p>
                    <p class="flex items-center gap-2">
                        <span class="font-semibold">Unit:</span>
                        <select name="unit_id" id="unit_id"
                            class="border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white cursor-pointer"
                            style="min-width: 150px;">
                            <option value="">-- Pilih Unit --</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->unitnama }}</option>
                            @endforeach
                        </select>
                    </p>
                </div>

                <div>
                    <p>
                        <span class="font-semibold">Status:</span>
                        <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs">
                            Proses
                        </span>
                    </p>
                    <!-- <p>
                        <span class="font-semibold">Keterangan:</span>
                        <input type="text" name="keterangan" id="keterangan"
                            class="border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none w-full mt-1"
                            placeholder="Masukkan keterangan">
                    </p> -->
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-semibold mb-1">
                    Keterangan
                </label>
                <textarea class="w-full border rounded p-2 text-sm" rows="3" placeholder="Masukkan keterangan..."
                    name="keterangan" id="keterangan"></textarea>
            </div>

            <div class="flex justify-between items-center mt-6 border-t pt-4">
                <div>
                    <p class="text-sm text-gray-500">Total Permintaan</p>
                    <p class="text-xl font-bold" id="totalpermintaan">Rp 0</p>
                </div>

                <div class="flex gap-3">
                    <button class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">
                        Simpan Draft
                    </button>
                    <button class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
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
                <tbody id="tabel-barang">

                </tbody>
            </table>

            <div class="flex flex-1 max-w-md relative">
                <input type="text"
                    class="w-full border border-gray-300 rounded-l-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white"
                    placeholder="Nama Barang" name="namabarang" id="nama-barang" autocomplete="off">

                <div id="suggestion-box"
                    class="absolute top-full left-0 z-10 w-full bg-white border border-gray-300 rounded-b-lg shadow-lg hidden">
                </div>

                <button type="button" id="btn-tambah"
                    class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition-colors text-sm font-semibold border-l-0">
                    + Tambah Barang
                </button>
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