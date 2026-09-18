@extends('layouts.app')

@section('title', 'Manajemen Klien')

@section('content')
<h4 class="fw-bold mb-4">Aplikasi Klien OAuth</h4>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Aplikasi</h5>
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
@endsection
