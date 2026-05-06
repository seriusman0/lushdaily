<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    public int $perPage = 20;

    protected string $paginationTheme = 'bootstrap';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Product::findOrFail($id)->delete();
        session()->flash('success', 'Produk berhasil dihapus.');
    }

    public function render()
    {
        $products = Product::withCount('images')
            ->when(
                $this->search,
                fn ($q) => $q->where('name', 'like', "%{$this->search}%")
            )
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate($this->perPage);

        return view('livewire.admin.product-table', compact('products'));
    }
}
