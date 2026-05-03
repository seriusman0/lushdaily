@extends('admin.layouts.app')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produk</a></li>
    <li class="breadcrumb-item active">Edit #{{ $product->id }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Edit: {{ $product->title }}</h3>
            </div>
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="card-body">
                    @include('admin.products._form')
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-default ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
