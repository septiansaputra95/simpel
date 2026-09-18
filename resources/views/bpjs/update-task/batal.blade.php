@extends('layouts.newlayout')

@section('newcontent')
    <!-- ================= MAIN ================= -->
<div x-data="{ activeTab: 'single' }">

    <!-- Tabs -->
    <div class="flex gap-6 px-6 pt-5 border-b border-bd">

        <button
            type="button"
            @click="activeTab = 'single'"
            :class="activeTab === 'single'
                ? 'text-accent border-accent'
                : 'text-muted border-transparent'"
            class="pb-3 text-sm font-semibold border-b-2 transition">

            <i class="bi bi-1-circle mr-1"></i>
            Batalkan 1 Kode
        </button>

        <button
            type="button"
            @click="activeTab = 'bulk'"
            :class="activeTab === 'bulk'
                ? 'text-accent border-accent'
                : 'text-muted border-transparent'"
            class="pb-3 text-sm font-semibold border-b-2 transition">

            <i class="bi bi-stack mr-1"></i>
            Batalkan Banyak Kode
        </button>
    </div>

    <div class="p-6">

        <!-- MODE 1: SATU KODE -->
        <div x-show="activeTab === 'single'">
            <div class="bg-white border border-bd rounded-2xl p-6">

                <label class="block text-sm font-semibold mb-2">
                    Kode Booking
                </label>

                <div class="flex gap-2">

                    <div class="flex items-center flex-1 border border-bd rounded-lg px-3 gap-2 focus-within:ring-2 focus-within:ring-accent-bg">

                        <i class="bi bi-upc-scan text-slate-400"></i>

                        <input
                            id="singleCode"
                            type="text"
                            placeholder="Contoh: 2609140080"
                            class="w-full py-2.5 text-sm font-mono outline-none placeholder:font-sans">

                    </div>
                    <button
                        type="button"
                        id="btn-batalAntrean"
                        class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg px-5 py-2.5 whitespace-nowrap shrink-0">
                        
                        <i class="bi bi-x-lg mr-1"></i>
                        Batalkan Antrian
                    </button>
                </div>
                <div id="singleFeedback" class="mt-3"></div>
            </div>
            <!-- HASIL RESPONSE -->
            <div id="singleResultWrap" class="hidden mt-6">
                <div class="bg-white border border-bd rounded-2xl p-6">

                    <h2 class="font-bold text-[15px] mb-3">
                        Hasil Pembatalan
                    </h2>

                    <div id="singleResultMessage" class="mb-4"></div>

                    <div class="bg-slate-900 rounded-xl p-4 overflow-auto">
                        <pre id="singleResultJson"
                            class="text-xs text-green-300 font-mono whitespace-pre-wrap"></pre>
                    </div>

                </div>
            </div>
        </div>


        <!-- MODE 2: BANYAK KODE -->
        <div x-show="activeTab === 'bulk'">

            <label class="block text-sm font-semibold mb-2">
                Daftar Kode Booking
            </label>

            <textarea
                id="bulkInput"
                rows="4"
                placeholder="Tempel kode, pisahkan dengan baris baru atau koma"
                class="w-full border border-bd rounded-lg px-3 py-2.5 text-sm font-mono outline-none focus:ring-2 focus:ring-accent-bg placeholder:font-sans mb-3"></textarea>

            <button
                type="button"
                id="btn-bulkBatal"
                class="bg-red-500 text-white text-sm font-semibold rounded-lg px-5 py-2.5">
                <i class="bi bi-trash3 mr-1"></i>
                Batalkan Semua<span></span>
            </button>
            <div id="chipContainer" class="flex flex-wrap gap-2 mb-3"></div>

            <div class="flex items-center justify-between">

                <span id="chipCount" class="text-xs text-muted">
                    0 kode terdeteksi
                </span>


            </div>

            <div id="bulkResultWrap" class="hidden mt-6">
                <div class="bg-white border border-bd rounded-2xl p-6">
                    <h2 class="font-bold text-[15px] mb-3">
                        Hasil Pembatalan Banyak Kode
                    </h2>
                    <div id="bulkResultMessage" class="space-y-3"></div>
                    <div class="bg-slate-900 rounded-xl p-4 overflow-auto mt-4">
                        <pre
                            id="bulkResultJson"
                            class="text-xs text-green-300 font-mono whitespace-pre-wrap"></pre>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


@push('scripts')
@vite('resources/js/bpjs/updatetask.js')
@endpush
@endsection
