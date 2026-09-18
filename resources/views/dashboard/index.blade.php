@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-bold">Selamat Datang di Panel Admin SSO</h4>
        <p class="text-muted">Pusat kendali autentikasi terpusat Universitas.</p>
    </div>

    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar avatar-sm me-3">
                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user"></i></span>
                    </div>
                    <h5 class="card-title mb-0">Total Pengguna</h5>
                </div>
                <h3 class="fw-bolder mb-0">{{ number_format($stats['total_users']) }}</h3>
                <small class="text-muted">Mahasiswa & Dosen terdaftar</small>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar avatar-sm me-3">
                        <span class="avatar-initial rounded bg-label-success"><i class="bx bx-server"></i></span>
                    </div>
                    <h5 class="card-title mb-0">Aplikasi Klien</h5>
                </div>
                <h3 class="fw-bolder mb-0">{{ number_format($stats['total_clients']) }}</h3>
                <small class="text-muted">Aplikasi yang dikelola oleh Anda</small>
            </div>
        </div>
    </div>
</div>
@endsection
