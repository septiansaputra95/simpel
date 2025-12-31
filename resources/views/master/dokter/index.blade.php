@extends('layouts.newlayout')

@section('newcontent')
<h1 class="text-2xl font-bold mb-4">SIMPEL RS HERMINA PEKALONGAN</h1>

<!-- Tabs -->
<div class="border-b border-gray-200">
    <nav class="-mb-px flex space-x-4" id="tabs">
        <button class="tab-btn border-b-2 border-blue-500 text-blue-600 px-3 py-2 text-sm font-medium" data-tab="tab1">Dokter</button>
        <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium" data-tab="tab2">Sub Menu</button>
        <!-- <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium" data-tab="tab3">Settings</button> -->
    </nav>
</div>

<!-- Tab 1 -->
<div id="tab1" class="tab-content">
    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-bold">Master Dokter</h2>
            <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition" id="btn-tambah">Tambah</button>
        </div>
        <table class="min-w-full text-sm text-left border border-gray-200" id="tabel-data">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">No</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Kode Dokter</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Nama Dokter</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Email</th>
                    <th class="px-4 py-2 font-semibold border border-gray-300 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">  
            </tbody>
        </table>
    </div>
</div>

<!-- Tab 2 -->
<div id="tab2" class="tab-content hidden">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-2">Laporan</h2>
        <p>Ini halaman laporan.</p>
    </div>
</div>

<!-- Tab 3 -->
<!-- <div id="tab3" class="tab-content hidden">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-2">Pengaturan</h2>
        <p>Ini halaman pengaturan.</p>
    </div>
</div> -->
@include('master.dokter.modal-data')
@push('scripts')
@vite('resources/js/master/masterdokter.js')
@endpush
@endsection
<!-- /home/itsupport/aplikasi/simpel/resources/js/menu/menu.js -->