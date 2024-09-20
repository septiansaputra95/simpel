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
                </div>
                <div class="col-auto">
                    <select name="" id="taskid" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select>
                    @csrf
                </div>
                <div class="col-md-2">
                    {{-- <button type="button" class="btn btn-primary" id="btn-kirim">Cari</button> --}}
                    <button type="submit" class="btn btn-success" id="btn-update">Update Task</button>
                    <button type="submit" class="btn btn-warning" id="btn-update-error">Update Error Task</button>sss
                </div>
            </div>

            <div class="card-body">
     
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@vite(['resources/js/bpjs/updatetask.js'])
@endpush
