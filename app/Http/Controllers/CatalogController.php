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
                    'whatsapp_message' => $this->buildWhatsappMessage($product),
                ];
            });

        return view('catalog', compact('products'));
    }

    private function buildWhatsappMessage(Product $product): string
    {
        // Step 1 — Strip HTML tags
        $text = strip_tags($product->caption);

        // Step 2 — Decode HTML entities (&nbsp; → space, &amp; → &, etc.)
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Replace non-breaking space (U+00A0) with regular space
        $text = str_replace("\xc2\xa0", ' ', $text);

        // Clean up blank lines produced by stripped block tags
        $text = preg_replace("/\n{3,}/", "\n\n", trim($text));

        // Product link for admin cross-check
        $productUrl = url('/') . '#product-' . $product->id;

        $message  = "Halo Lush Daily! 👋\n\n";
        $message .= "Saya ingin memesan produk berikut:\n\n";
        $message .= $text . "\n\n";
        $message .= "🔗 Link Produk: " . $productUrl . "\n\n";
        $message .= "Mohon info ketersediaan dan cara pemesanannya. Terima kasih! 🙏";

        // Step 3 — URL encode (spasi → %20, newline → %0A, emoji aman)
        return rawurlencode($message);
    }
}
