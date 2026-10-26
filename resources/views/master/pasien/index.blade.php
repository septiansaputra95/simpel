@extends('layouts.newlayout')

@section('newcontent')
<h1 class="font-bold text-lg mb-1">SIMPEL RS HERMINA PEKALONGAN</h1>
  <p class="text-sm text-muted mb-6">Kelola data pasien terdaftar di rumah sakit.</p>

  <div class="bg-white border border-bd rounded-2xl overflow-hidden">

    <!-- Header card: judul, search, tombol tambah -->
    <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-5 border-b border-bd">
      <h2 class="font-bold text-[15px]">Master Pasien</h2>
      <div class="flex items-center gap-3">
        <div class="flex items-center border border-bd rounded-lg px-3 py-2 gap-2 w-64">
          <i class="bi bi-search text-slate-400 text-sm"></i>
          <input id="searchInput" type="text" placeholder="Cari nama, MRN, atau no. HP..."
            class="w-full text-sm outline-none placeholder:text-slate-300">
        </div>
        <a href="{{ route('masterpasien.input') }}" class="bg-accent hover:opacity-90 text-white text-sm font-semibold rounded-lg px-4 py-2 whitespace-nowrap">
          <i class="bi bi-plus-lg mr-1" href="masterpasien.input"></i>Tambah Data
        </a>
      </div>
    </div>

    <!-- Filter status -->
    <div class="flex items-center gap-2 px-6 py-3 border-b border-bd">
      <span class="text-xs text-muted font-medium mr-1">Status:</span>
      <button data-f="all" onclick="setFilter('all')" class="filter-btn text-xs font-semibold px-3 py-1.5 rounded-full bg-accent-bg text-accent">Semua</button>
      <button data-f="Aktif" onclick="setFilter('Aktif')" class="filter-btn text-xs font-semibold px-3 py-1.5 rounded-full text-muted hover:bg-slate-50">Aktif</button>
      <button data-f="Tidak Aktif" onclick="setFilter('Tidak Aktif')" class="filter-btn text-xs font-semibold px-3 py-1.5 rounded-full text-muted hover:bg-slate-50">Tidak Aktif</button>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm" id="tabel-data">
        <thead>
          <tr class="bg-slate-50">
            <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">MRN</th>
            <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Nama Pasien</th>
            <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Gender</th>
            <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Tgl. Lahir</th>
            <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Alamat</th>
            <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">BPJS</th>
            <th class="text-left text-[11px] uppercase tracking-wide text-slate-400 font-semibold px-5 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody id="pasienBody" class="divide-y divide-bd"></tbody>
      </table>
    </div>

    <!-- <div class="flex items-center justify-between px-6 py-4 border-t border-bd">
      <button class="border border-bd rounded-md px-3 py-1.5 text-sm font-semibold text-muted"><i class="bi bi-chevron-left mr-1"></i>Previous</button>
      <button class="bg-accent-bg text-accent border border-accent-bg rounded-md px-3 py-1.5 text-sm font-semibold">1</button>
      <button class="border border-bd rounded-md px-3 py-1.5 text-sm font-semibold text-muted">Next<i class="bi bi-chevron-right ml-1"></i></button>
      <span id="countInfo" class="text-xs text-muted"></span>
    </div> -->
  </div>
</main>

<!-- Toast konfirmasi ubah status -->
<div id="toastEl" class="hidden fixed bottom-6 right-6 bg-white border border-bd rounded-xl shadow-lg px-4 py-3 flex items-start gap-3 max-w-xs">
  <i id="toastIcon" class="bi bi-check-circle-fill text-green text-lg mt-0.5"></i>
  <div>
    <div id="toastTitle" class="text-sm font-semibold">Berhasil</div>
    <div id="toastMsg" class="text-xs text-muted">Status pasien diperbarui.</div>
  </div>
</div>

<!-- Tab 3 -->
<!-- <div id="tab3" class="tab-content hidden">
    <div class="bg-white border border-bd rounded-2xl p-6">
        <h2 class="font-bold text-[15px] mb-2">Pengaturan</h2>
        <p class="text-sm text-muted">Ini halaman pengaturan.</p>
    </div>
</div> -->
@push('scripts')
@vite('resources/js/master/masterpasien.js')
@endpush
@endsection