<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $products = Product::active()
            ->with('images')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (Product $product) {
                return [
                    'id'               => $product->id,
                    'name'             => $product->title,
                    'caption'          => $product->caption,
                    'image'            => $product->primary_image_url,
                    'url'              => route('products.show', $product),
                    'whatsapp_message' => $this->buildWhatsappMessage($product),
                ];
            });

        return view('catalog', compact('products'));
    }

    private function buildWhatsappMessage(Product $product): string
    {
        $text = strip_tags($product->caption);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace("\xc2\xa0", ' ', $text);
        $text = preg_replace("/\n{3,}/", "\n\n", trim($text));

        $productUrl = route('products.show', $product);

        $message  = "Halo Lush Daily! 👋\n\n";
        $message .= "Saya ingin memesan produk berikut:\n\n";
        $message .= $text . "\n\n";
        $message .= "🔗 Link Produk: " . $productUrl . "\n\n";
        $message .= "Mohon info ketersediaan dan cara pemesanannya. Terima kasih! 🙏";

        return rawurlencode($message);
    }
}
