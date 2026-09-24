@extends('layouts.app')

@section('title', 'Manajemen Klien')

@section('content')
<h4 class="fw-bold mb-4">Aplikasi Klien OAuth</h4>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Aplikasi</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
            Tambah Klien
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Aplikasi</th>
                    <th>Redirect URI</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($clients as $client)
                <tr>
                    <td><code>{{ $client->id }}</code></td>
                    <td><strong>{{ $client->name }}</strong></td>
                    <td><code>{{ $client->redirect }}</code></td>
                    <td>
                        @if($client->revoked)
                            <span class="badge bg-label-danger">Dicabut</span>
                        @else
                            <span class="badge bg-label-success">Aktif</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Cabut akses aplikasi ini?')">Cabut</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Belum ada aplikasi klien yang terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
</div>

<!-- Modal Create Client -->
<div class="modal fade" id="createClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Daftarkan Aplikasi OAuth Baru</h5>
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
                        <div class="col mb-3">
                            <label for="name" class="form-label">Nama Aplikasi</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Cth: E-Learning System" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="redirect" class="form-label">Redirect URI (Callback URL)</label>
                            <input type="url" id="redirect" name="redirect" class="form-control" placeholder="Cth: https://elearning.univ.ac.id/auth/callback" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Klien</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('createClientModal'));
            myModal.show();
        });
    </script>
    @endpush
@endif
@endsection
