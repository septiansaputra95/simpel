@extends('layouts.newlayout')

@section('newcontent')
<h1 class="text-2xl font-bold mb-4">SIMPEL RS HERMINA PEKALONGAN</h1>

<!-- Tabs -->
<div class="border-b border-gray-200">
    <nav class="-mb-px flex space-x-4" id="tabs">
        <button class="tab-btn border-b-2 border-blue-500 text-blue-600 px-3 py-2 text-sm font-medium" data-tab="tab1">User</button>
        {{-- <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium" data-tab="tab2">Reports</button> --}}
        {{-- <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium" data-tab="tab3">Settings</button> --}}
    </nav>
</div>

<!-- Tab 1 -->
<div id="tab1" class="tab-content">
    <!-- Cards -->
    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-bold">Data Users</h2>
            <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition">Tambah</button>
        </div>
        <table class="min-w-full text-sm text-left" id="tabel-data">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-2 font-semibold">Username</th>
                    <th class="px-4 py-2 font-semibold">Nama</th>
                    {{-- <th class="px-4 py-2 font-semibold">Role</th> --}}
                    <th class="px-4 py-2 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
@vite('resources/js/user/user.js')
@endpush