<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;

class ProductImageController extends Controller
{
    public function destroy(ProductImage $productImage)
    {
        $filePath = public_path('images/product/' . $productImage->path);

        if (file_exists($filePath) && str_contains($productImage->path, '_')) {
            unlink($filePath);
        }

        $productImage->delete();

        return response()->json(['success' => true]);
    }
}
