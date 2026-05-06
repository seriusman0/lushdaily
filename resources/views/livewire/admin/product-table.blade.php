<div>
    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-box-open mr-2"></i>Daftar Produk</h3>
            <div class="card-tools d-flex align-items-center">
                <div class="input-group input-group-sm mr-2" style="width:220px">
                    <input type="text" wire:model.live.debounce.300ms="search"
                           class="form-control" placeholder="Cari produk…">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Produk
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div wire:loading.class="opacity-50" style="transition:opacity .15s">
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
                                <a href="{{ route('admin.products.edit', $product) }}?from_page={{ $products->currentPage() }}"
                                   class="btn btn-xs btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        wire:click="delete({{ $product->id }})"
                                        wire:confirm="Hapus produk '{{ addslashes($product->title) }}'?"
                                        class="btn btn-xs btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                @if($search)
                                    Tidak ada produk dengan kata kunci "<strong>{{ $search }}</strong>".
                                @else
                                    Belum ada produk.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
        <div class="card-footer">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
