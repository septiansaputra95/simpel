@extends('layouts.layout')

@section('title', 'Main Content')

@section('content')
    <h1 class="text-2xl font-bold mb-4">KEUANGAN</h1>
    <div class="container-fluid">
        <div class="card">
            <div class="card-head">
                <h5>Honor Dokter</h5>
            </div>
            <div class="row align-items-end">
                <div class="col-auto">
                    <label class="col-form-label">Tanggal Awal</label>
                </div>
                <div class="col-auto">
                    <input type="date" class="form-control" id="tanggal-awal">
                </div>
                <div class="col-md-7">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="btn-cari">Cari</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-outline-success" id="btn-tambah">+ Tambah Data</button>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered" id="tabel-data">
				    <div class="d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-outline-secondary ms-3" id="btn-kirim">Kirim</button>
                    </div>
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Dokter</th>
                            <th scope="col">Nama Dokter</th>
                            <th scope="col">Tanggal Awal</th>
                            <th scope="col">Tanggal Akhir</th>
                            <th scope="col">Status</th>
                            <th scope="col">Check Box</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
@endsection
@include('keuangan.honordokter.modal-data')
@push('scripts')
@vite('resources/js/keuangan/honordokter.js')
@endpush
