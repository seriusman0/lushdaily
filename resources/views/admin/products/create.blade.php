@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produk</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Produk</h3>
            </div>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @include('admin.products._form')
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-default ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
