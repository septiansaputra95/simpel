@extends('layouts.newlayout')

@section('newcontent')
<div class="mb-6 flex items-start justify-between gap-4">
    <div>
        <h1 class="text-xl font-bold text-ink">Scheduler</h1>
        <p class="mt-1 text-sm text-muted">Atur waktu eksekusi action dan payload dalam zona waktu WIB.</p>
    </div>
    <span class="rounded-full bg-blue-bg px-3 py-1.5 text-xs font-semibold text-blue">WIB (UTC+7)</span>
</div>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-5">
    <section class="rounded-2xl border border-bd bg-white p-6 xl:col-span-2">
        <h2 id="form-title" class="mb-5 text-base font-bold">Buat Jadwal</h2>
        <form id="scheduler-form" class="space-y-4">
            @csrf
            <div>
                <label for="action_type" class="mb-1.5 block text-sm font-semibold">Jenis Action</label>
                <select id="action_type" name="action_type" required
                    class="w-full rounded-lg border border-bd px-3 py-2.5 text-sm focus:border-blue focus:outline-none">
                    <option value="">-- Pilih Action --</option>
                    <option value="HOLD">HOLD</option>
                    <option value="RESET">RESET</option>
                </select>
                <p class="mt-1 text-xs text-muted">Pilih HOLD atau RESET.</p>
            </div>

            <div id="status-control" class="hidden">
                <label for="task-status" class="mb-1.5 block text-sm font-semibold">Status Jadwal</label>
                <select id="task-status" name="status" required disabled
                    class="w-full rounded-lg border border-bd px-3 py-2.5 text-sm focus:border-blue focus:outline-none">
                    <option value="PENDING" disabled>PENDING</option>
                    <option value="CANCEL">CANCEL</option>
                </select>
                <p class="mt-1 text-xs text-muted">Edit hanya mengubah status PENDING menjadi CANCEL. Untuk memperbaiki data, batalkan jadwal lalu buat jadwal baru.</p>
            </div>

            <div>
                <div class="mb-1.5 flex items-center justify-between gap-2">
                    <label for="payload" class="block text-sm font-semibold">Payload JSON</label>
                    <div class="flex gap-2">
                        <button type="button" id="btn-format-json" class="text-xs font-semibold text-blue hover:underline">Format</button>
                        <button type="button" id="btn-minify-json" class="text-xs font-semibold text-blue hover:underline">Minify</button>
                        <button type="button" id="btn-clear-json" class="text-xs font-semibold text-rose hover:underline">Clear</button>
                    </div>
                </div>
                <textarea id="payload" name="payload" rows="9" required
                    class="w-full rounded-lg border border-bd px-3 py-2.5 font-mono text-xs focus:border-blue focus:outline-none">{}</textarea>
                <p id="payload-status" class="mt-1 text-xs text-muted">Masukkan JSON yang valid.</p>
            </div>

            <div>
                <div class="mb-1.5 flex items-center justify-between gap-2">
                    <label for="scheduled_at" class="block text-sm font-semibold">Tanggal dan Jam (WIB)</label>
                    <div class="flex gap-2">
                        <button type="button" class="time-preset text-xs font-semibold text-blue hover:underline" data-minutes="5">+5 menit</button>
                        <button type="button" class="time-preset text-xs font-semibold text-blue hover:underline" data-minutes="30">+30 menit</button>
                        <button type="button" class="time-preset text-xs font-semibold text-blue hover:underline" data-minutes="60">+1 jam</button>
                    </div>
                </div>
                <input id="scheduled_at" name="scheduled_at" type="datetime-local" required
                    class="w-full rounded-lg border border-bd px-3 py-2.5 text-sm focus:border-blue focus:outline-none">
            </div>

            <div class="rounded-xl bg-slate-50 p-3 text-sm">
                <span class="font-semibold">Ringkasan:</span>
                <span id="schedule-summary" class="text-muted">Lengkapi action, payload, dan waktu jadwal.</span>
            </div>

            <div id="form-message" class="hidden rounded-lg px-3 py-2 text-sm" role="status" aria-live="polite"></div>
            <div class="flex justify-end gap-2 pt-1">
                <button type="button" id="btn-reset" class="rounded-lg border border-bd px-4 py-2 text-sm font-semibold text-muted hover:bg-slate-50">Reset</button>
                <button type="submit" id="btn-simpan" class="rounded-lg bg-accent px-4 py-2 text-sm font-semibold text-white hover:opacity-90">Simpan Jadwal</button>
            </div>
        </form>
    </section>

    <section class="overflow-hidden rounded-2xl border border-bd bg-white xl:col-span-3">
        <div class="flex items-center justify-between border-b border-bd px-6 py-5">
            <div>
                <h2 class="font-bold">Daftar Jadwal</h2>
                <p class="mt-1 text-xs text-muted">Waktu ditampilkan dalam WIB.</p>
            </div>
            <button type="button" id="btn-refresh" class="rounded-lg border border-bd px-3 py-2 text-sm font-semibold text-muted hover:bg-slate-50">
                <i class="bi bi-arrow-clockwise mr-1"></i>Muat Ulang
            </button>
        </div>
        <div class="overflow-x-auto p-4">
            <table id="tabel-scheduler" class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-400">Action</th>
                        <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-400">Payload</th>
                        <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-400">Jadwal (WIB)</th>
                        <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-400">Status</th>
                        <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-400">Dibuat oleh</th>
                        <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-400">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    window.schedulerUrls = {
        datatables: @json(route('scheduler.datatables')),
        store: @json(route('scheduler.store')),
        update: @json(route('scheduler.update', ['id' => '__ID__'])),
    };
</script>
@vite('resources/js/scheduler/scheduler.js')
@endpush
