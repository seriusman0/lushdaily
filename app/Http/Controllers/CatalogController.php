<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $products = Product::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (Product $product) {
                return [
                    'id'               => $product->id,
                    'caption'          => $product->caption,
                    'image'            => $product->image_url,
                    'whatsapp_message' => $this->buildWhatsappMessage($product->caption),
                ];
            });

        return view('catalog', compact('products'));
    }

    private function buildWhatsappMessage(string $caption): string
    {
        $text = strip_tags($caption);

        $message  = "Halo Lush Daily! 👋\n\n";
        $message .= "Saya ingin memesan produk berikut:\n\n";
        $message .= $text . "\n\n";
        $message .= "Mohon info ketersediaan dan cara pemesanannya. Terima kasih! 🙏";

        return urlencode($message);
    }
}
