<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $products = collect(config('products'))->map(function (array $product) {
            return [
                'id'      => $product['id'],
                'caption' => $product['caption'],
                'image'   => asset('images/product/' . $product['image']),
                'whatsapp_message' => $this->buildWhatsappMessage($product),
            ];
        });

        return view('catalog', compact('products'));
    }

    private function buildWhatsappMessage(array $product): string
    {
        $caption = strip_tags($product['caption']);

        $message = "Halo Lush Daily! 👋\n\n";
        $message .= "Saya ingin memesan produk berikut:\n\n";
        $message .= $caption . "\n\n";
        $message .= "Mohon info ketersediaan dan cara pemesanannya. Terima kasih! 🙏";

        return urlencode($message);
    }
}
