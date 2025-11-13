@extends('layouts.newlayout')

@section('newcontent')
<h1 class="text-2xl font-bold mb-4">SIMPEL RS HERMINA PEKALONGAN</h1>

<!-- Tabs -->
<div class="border-b border-gray-200">
    <nav class="-mb-px flex space-x-4" id="tabs">
        <button class="tab-btn border-b-2 border-blue-500 text-blue-600 px-3 py-2 text-sm font-medium" data-tab="tab1">Overview</button>
        <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium" data-tab="tab2">Reports</button>
        <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium" data-tab="tab3">Settings</button>
    </nav>
</div>

<!-- Tab 1 -->
<div id="tab1" class="tab-content">
    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-sm font-semibold text-gray-500">Total Users</h2>
            <p class="text-2xl font-bold">1,245</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-sm font-semibold text-gray-500">Active Sessions</h2>
            <p class="text-2xl font-bold">87</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-sm font-semibold text-gray-500">Reports</h2>
            <p class="text-2xl font-bold">12</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-bold">Data Users</h2>
            <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition">Tambah</button>
        </div>
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-2 font-semibold">Nama</th>
                    <th class="px-4 py-2 font-semibold">Email</th>
                    <th class="px-4 py-2 font-semibold">Role</th>
                    <th class="px-4 py-2 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">Andi</td>
                    <td class="px-4 py-2">andi@example.com</td>
                    <td class="px-4 py-2">Admin</td>
                    <td class="px-4 py-2 text-center space-x-1">
                        <button class="px-2 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">Edit</button>
                        <button class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">Hapus</button>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">Budi</td>
                    <td class="px-4 py-2">budi@example.com</td>
                    <td class="px-4 py-2">User</td>
                    <td class="px-4 py-2 text-center space-x-1">
                        <button class="px-2 py-1 text-xs bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">Edit</button>
                        <button class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">Hapus</button>
                    </td>
                </tr>
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
<div id="tab3" class="tab-content hidden">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-2">Pengaturan</h2>
        <p>Ini halaman pengaturan.</p>
    </div>
</div>
@endsection
