@extends('layouts.layout')

@section('title', 'Main Content')

@section('content')
    <h1 class="text-2xl font-bold mb-4">BPJS</h1>
    <div class="container-fluid">
        <div class="card">
            <div class="card-head">
                <h5>Antrian Online</h5>
            </div>
            <div class="row align-items-end">
                <div class="col-auto">
                    <label class="col-form-label">TASK LIST</label>
                </div>
                <div class="col-auto">
                    <input type="text" class="form-control" id="kodebooking" placeholder="Kode Booking">
                    @csrf
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary" id="btn-cari">Cari</button>
                    <button type="submit" class="btn btn-success" id="btn-simpan">Simpan</button>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered" id="tabel-data">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Waktu RS</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Task Name</th>
                            <th scope="col">Task Id</th>
                            <th scope="col">Kode Booking</th>
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
@vite(['resources/js/bpjs/tasklist.js'])
@endpush
