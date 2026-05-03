@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Edit: {{ $user->name }}</h3>
            </div>
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf @method('PUT')
                <div class="card-body">
                    @include('admin.users._form', ['isEdit' => true])
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-default ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
