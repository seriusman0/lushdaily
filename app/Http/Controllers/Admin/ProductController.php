<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        unset($data['images']);

        $product = Product::create($data);

        $this->handleImageUploads($request, $product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        return view('admin.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);
        unset($data['images']);

        $product->update($data);

        $this->handleImageUploads($request, $product);

        $page = (int) $request->query('from_page', 1);

        return redirect()->route('admin.products.index', $page > 1 ? ['page' => $page] : [])
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function restore(int $id)
    {
        Product::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Produk berhasil dipulihkan.');
    }

    private function handleImageUploads($request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $nextOrder = $product->images()->max('sort_order') ?? -1;

        foreach ($request->file('images') as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/product'), $filename);

            ProductImage::create([
                'product_id' => $product->id,
                'path'       => $filename,
                'sort_order' => ++$nextOrder,
            ]);
        }
    }
}
