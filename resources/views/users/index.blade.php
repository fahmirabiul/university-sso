@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<h4 class="fw-bold mb-4">Pengguna Sistem</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Mahasiswa & Dosen</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Tambah Pengguna</button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Peran (Role)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($users as $user)
                <tr>
                    <td>
                        <strong>{{ $user->profile->full_name ?? 'Belum diatur' }}</strong>
                        @if($user->profile && $user->profile->identifier_number)
                            <div class="text-muted small">{{ $user->profile->identifier_number }}</div>
                        @endif
                        @if($user->profile && $user->profile->department)
                            <div class="text-muted small">{{ $user->profile->department }}</div>
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
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                    </td>
                </tr>

                <!-- Modal Edit User -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Pengguna: {{ $user->email }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" name="full_name" class="form-control" value="{{ $user->profile->full_name ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nomor Identitas (NIM/NIP)</label>
                                            <input type="text" name="identifier_number" class="form-control" value="{{ $user->profile->identifier_number ?? '' }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Departemen / Fakultas</label>
                                            <input type="text" name="department" class="form-control" value="{{ $user->profile->department ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Peran Akses (Roles)</label>
                                            <div class="row mt-2">
                                                @php
                                                    $userRoles = $user->roles->pluck('id')->toArray();
                                                @endphp
                                                @foreach($roles as $role)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="edit_role_{{ $user->id }}_{{ $role->id }}" 
                                                            {{ in_array($role->id, $userRoles) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="edit_role_{{ $user->id }}_{{ $role->id }}">
                                                            {{ $role->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border-top pt-3">
                                        <div class="col-md-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active_{{ $user->id }}" name="is_active" {{ $user->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active_{{ $user->id }}">Aktifkan Akun</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Modal Edit User -->

                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Belum ada pengguna.</td>
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

<!-- Modal Create User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Daftarkan Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Identitas (NIM/NIP)</label>
                            <input type="text" name="identifier_number" class="form-control" value="{{ old('identifier_number') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Departemen / Fakultas</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3 form-password-toggle">
                            <label class="form-label">Kata Sandi</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password" placeholder="Minimal 8 karakter" required>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Peran Akses (Roles)</label>
                            <div class="row mt-2">
                                @foreach($roles as $role)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="create_role_{{ $role->id }}" 
                                            {{ (is_array(old('roles')) && in_array($role->id, old('roles'))) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="create_role_{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('createUserModal'));
            myModal.show();
        });
    </script>
    @endpush
@endif
@endsection
