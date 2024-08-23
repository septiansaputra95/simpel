@extends('layouts.layout')

@section('title', 'Main Content')

@section('content')
    <h1 class="text-2xl font-bold mb-4">BPJS</h1>
    <div class="container-fluid">
        <div class="card">
            <div class="card-head">
                <h5>Antrian Online</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tabel-data">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Waktu Task 1s</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Kode Poli</th>
                            <th scope="col">Kode DOkter</th>
                            <th scope="col">Nomor Kartu</th>
                            <th scope="col">No. HP</th>
                            <th scope="col">No. RM</th>
                            <th scope="col">Jenis Kunjungan</th>
                            <th scope="col">No. Referensi</th>
                            <th scope="col">Sumber</th>
                            <th scope="col">No. Antrean</th>
                            <th scope="col">Estimasi</th>
                            <th scope="col">Create Time</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@vite(['resources/js/bpjs/antrianonline.js'])
@endpush
