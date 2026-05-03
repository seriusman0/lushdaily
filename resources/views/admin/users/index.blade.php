@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'Manajemen Users')
@section('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users mr-2"></i>Daftar Users</h3>
        <div class="card-tools">
            <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah User
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $user->role === 'admin' ? 'success' : 'secondary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="btn btn-xs btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($user->id !== Auth::id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
