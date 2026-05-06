@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'Manajemen Users')
@section('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
    @livewire('admin.user-table')
@endsection
