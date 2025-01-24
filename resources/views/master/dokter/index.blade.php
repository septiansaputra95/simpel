@extends('layouts.layout')

@section('title', 'Main Content')

@section('content')
    <h1 class="text-2xl font-bold mb-4">MASTER</h1>
    <div class="container-fluid">
        <div class="card">
            <div class="card-head">
                <h5>Master Dokter</h5>
            </div>
            <div class="row align-items-end">
                <div class="col-md-10">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-outline-success" id="btn-tambah">+ Tambah Data</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tabel-data">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Dokter</th>
                            <th scope="col">Nama Dokter</th>
                            <th scope="col">Email Dokter</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
@endsection
@include('master.dokter.modal-data')
@push('scripts')
@vite('resources/js/master/masterdokter.js')
@endpush
