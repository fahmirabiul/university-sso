@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<h4 class="fw-bold mb-4">Pengguna Sistem</h4>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Mahasiswa & Dosen</h5>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Peran (Role)</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($users as $user)
                <tr>
                    <td>
                        <strong>{{ $user->profile->full_name ?? 'Belum diatur' }}</strong>
                        @if($user->profile && $user->profile->identity_number)
                            <div class="text-muted small">{{ $user->profile->identity_number }}</div>
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-label-success">Aktif</span>
                        @else
                            <span class="badge bg-label-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        @forelse($user->roles as $role)
                            <span class="badge bg-label-primary me-1">{{ $role->name }}</span>
                        @empty
                            <span class="text-muted small">Tidak ada</span>
                        @endforelse
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Belum ada pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
