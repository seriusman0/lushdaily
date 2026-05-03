@extends('admin.layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Form Tambah User</h3>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    @include('admin.users._form')
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-default ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
