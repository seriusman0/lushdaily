@extends('admin.layouts.app')

@section('title', 'Produk')
@section('page-title', 'Manajemen Produk')
@section('breadcrumb')
    <li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
    @livewire('admin.product-table')
@endsection
