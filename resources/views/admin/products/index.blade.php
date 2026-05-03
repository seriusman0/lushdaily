@extends('admin.layouts.app')

@section('title', 'Produk')
@section('page-title', 'Manajemen Produk')
@section('breadcrumb')
    <li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-box-open mr-2"></i>Daftar Produk</h3>
        <div class="card-tools">
            <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Produk
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="thead-light">
                <tr>
                    <th style="width:60px">#</th>
                    <th style="width:70px">Gambar</th>
                    <th>Nama Produk</th>
                    <th style="width:80px" class="text-center">Foto</th>
                    <th style="width:90px" class="text-center">Status</th>
                    <th style="width:80px" class="text-center">Urutan</th>
                    <th style="width:110px" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <img src="{{ $product->image_url }}" alt=""
                             style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                    </td>
                    <td>
                        <div class="font-weight-bold">{{ $product->title }}</div>
                        <small class="text-muted">{{ mb_strimwidth(strip_tags($product->caption), 0, 80, '…') }}</small>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-info">{{ $product->images_count }} foto</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $product->is_active ? 'success' : 'secondary' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="text-center">{{ $product->sort_order }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="btn btn-xs btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="card-footer">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
