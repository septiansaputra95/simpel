@extends('layouts.newlayout')

@section('newcontent')
<h1 class="font-bold text-lg mb-6">SIMPEL RS HERMINA PEKALONGAN</h1>

<!-- Tabs -->
<div class="flex gap-6 border-b border-bd mb-6" id="tabs">
    <button class="tab-btn pb-3 text-sm font-semibold text-accent border-b-2 border-accent" data-tab="tab1">Menu</button>
    <button class="tab-btn pb-3 text-sm font-semibold text-muted border-b-2 border-transparent" data-tab="tab2">Sub Menu</button>
    <!-- <button class="tab-btn pb-3 text-sm font-semibold text-muted border-b-2 border-transparent" data-tab="tab3">Settings</button> -->
</div>

<!-- Tab 1 -->
<div id="tab1" class="tab-content">
    <!-- Table -->
    <div class="bg-white border border-bd rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-bd">
            <h2 class="font-bold text-[15px]">Menu</h2>
            <button class="bg-accent hover:opacity-90 text-white text-sm font-semibold rounded-lg px-4 py-2 transition" id="btn-tambah">
                <i class="bi bi-plus-lg mr-1"></i>Tambah
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="tabel-data">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Menu Id</th>
                        <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Nama Menu</th>
                        <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Route</th>
                        <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Icon</th>
                        <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Parent Id</th>
                        <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Status</th>
                        <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bd">
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab 2 -->
<div id="tab2" class="tab-content hidden">
    <div class="bg-white border border-bd rounded-2xl p-6">
        <h2 class="font-bold text-[15px] mb-2">Laporan</h2>
        <p class="text-sm text-muted">Ini halaman laporan.</p>
    </div>
</div>

<!-- Tab 3 -->
<!-- <div id="tab3" class="tab-content hidden">
    <div class="bg-white border border-bd rounded-2xl p-6">
        <h2 class="font-bold text-[15px] mb-2">Pengaturan</h2>
        <p class="text-sm text-muted">Ini halaman pengaturan.</p>
    </div>
</div> -->
@include('menu.modal-data')
@push('scripts')
@vite('resources/js/menu/menu.js')
@endpush
@endsection