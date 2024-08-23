@extends('layouts.layout')

@section('title', 'Main Content')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Main Content Area</h1>
    <div class="container-fluid">
        <div class="card">
            <div class="card-head">
                <h5>Main Konten</h5>
            </div>
            <div class="card-body">
                <h5 class="card-title">Card Title</h5>
                <p class="card-text">This is a Bootstrap card. You can place Bootstrap components here.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
@endsection
