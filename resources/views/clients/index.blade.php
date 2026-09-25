@extends('layouts.app')

@section('title', 'Manajemen Klien')

@section('content')
<h4 class="fw-bold mb-4">Aplikasi Klien OAuth</h4>

@if(session('new_client_secret'))
<div class="alert alert-warning alert-dismissible" role="alert">
    <h5 class="alert-heading mb-2"><i class="bx bx-error-circle me-1"></i> Penting: Salin Kredensial Ini Sekarang!</h5>
    <p class="mb-2">Aplikasi berhasil didaftarkan. Demi keamanan, <strong>Client Secret</strong> di bawah ini hanya akan ditampilkan satu kali ini saja dan tidak dapat ditarik kembali setelah Anda meninggalkan atau memuat ulang (refresh) halaman ini.</p>
    <div class="mb-2">
        <strong>Client ID:</strong> <code class="fs-6">{{ session('new_client_id') }}</code>
    </div>
    <div>
        <strong>Client Secret:</strong> <code class="fs-6">{{ session('new_client_secret') }}</code>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Aplikasi</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
            Tambah Klien
        </button>
    </div>
    <div class="table-responsive text-nowrap p-3">
        <table class="table table-hover" id="clientsTable">
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
                    <td><code>{{ implode(', ', $client->redirect_uris) }}</code></td>
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

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#clientsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                }
            });
        });
    </script>
@endpush
@endsection
