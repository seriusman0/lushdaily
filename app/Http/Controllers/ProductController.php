<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        abort_if(! $product->is_active, 404);

        $product->load('images');

        return view('product-detail', compact('product'));
    }
}
