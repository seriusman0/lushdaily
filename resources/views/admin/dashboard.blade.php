@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_products'] }}</h3>
                <p>Total Produk</p>
            </div>
            <div class="icon"><i class="fas fa-box-open"></i></div>
            <a href="{{ route('admin.products.index') }}" class="small-box-footer">
                Kelola <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['active_products'] }}</h3>
                <p>Produk Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <a href="{{ route('admin.products.index') }}" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['total_users'] }}</h3>
                <p>Total Users</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                Kelola <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['admin_users'] }}</h3>
                <p>Admin Users</p>
            </div>
            <div class="icon"><i class="fas fa-user-shield"></i></div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Selamat Datang</h3>
            </div>
            <div class="card-body">
                <p>Halo, <strong>{{ Auth::user()->name }}</strong>! Selamat datang di panel admin Lush Daily.</p>
                <p class="text-muted mb-0">Gunakan menu di sidebar untuk mengelola produk dan pengguna.</p>
            </div>
        </div>
    </div>
</div>
@endsection
