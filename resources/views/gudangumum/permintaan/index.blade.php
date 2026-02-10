@extends('layouts.newlayout')

@section('newcontent')
<h1 class="text-2xl font-bold mb-4">SIMPEL RS HERMINA PEKALONGAN</h1>

<!-- Tabs -->
<div class="border-b border-gray-200">
    <nav class="-mb-px flex space-x-4" id="tabs">
        <button class="tab-btn border-b-2 border-blue-500 text-blue-600 px-3 py-2 text-sm font-medium" data-tab="tab1">Permintaan</button>
        <!-- <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium" data-tab="tab2">Sub Menu</button> -->
        <!-- <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium" data-tab="tab3">Settings</button> -->
    </nav>
</div>

<!-- Tab 1 -->
<div id="tab1" class="tab-content">
    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <!-- Title -->
            <h2 class="text-lg font-bold">Permintaan</h2>

            <!-- Right Section -->
            <div class="flex items-center gap-3">
                <!-- Search -->
                <input 
                    type="text" 
                    placeholder="Search Nama Barang"
                    class="w-64 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5"
                    id="searchbar"
                >

                <!-- Button -->
                <button 
                    class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    id="btn-tambah">
                    Tambah
                </button>
                <a href="permintaan.input"
                class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"            
                >
                Tambah
                </a>

            </div>
        </div>
        <table class="min-w-full text-sm text-left border border-gray-200" id="tabel-data">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">No</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Kode Permintaan</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Tanggal</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Unit</th>
                    <!-- <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Total Item</th> -->
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Total Harga</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Keterangan</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">User</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">  
            </tbody>
        </table>
    </div>
</div>

<!-- @include('gudangumum.stokgudang.modal-data') -->
@push('scripts')
@vite('resources/js/gudangumum/permintaan.js')
@endpush
@endsection
<!-- /home/itsupport/aplikasi/simpel/resources/js/menu/menu.js -->