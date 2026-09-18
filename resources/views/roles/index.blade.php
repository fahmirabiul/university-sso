@extends('layouts.app')

@section('title', 'Manajemen Peran Akses')

@section('content')
<h4 class="fw-bold mb-4">Peran Akses (Roles)</h4>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Peran di Sistem SSO</h5>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Peran</th>
                    <th>Dibuat Pada</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td><strong>{{ $role->name }}</strong></td>
                    <td>{{ $role->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4">Belum ada peran terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
