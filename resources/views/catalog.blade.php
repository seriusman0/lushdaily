<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Lush Daily — Toko buah segar & frozen food online. Freshness Delivered to Your Doorstep." />
    <title>Lush Daily | Fresh Fruits &amp; Frozen Food Online</title>

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            green:  '#2d7a2f',
                            lime:   '#6abf4b',
                            yellow: '#f5c842',
                            cream:  '#fefdf7',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        html { scroll-behavior: smooth; }

        .card-hover {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        }

        .caption-text {
            white-space: pre-line;
        }

        /* Bold text between asterisks */
        .caption-text strong { font-weight: 700; }

        .wa-btn {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .wa-btn:hover {
            opacity: 0.92;
            transform: scale(1.02);
        }
        .wa-btn:active {
            transform: scale(0.98);
        }

        /* Skeleton loader */
        .img-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.4s infinite;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>

<body class="bg-brand-cream font-sans antialiased">

{{-- ===================== NAVBAR ===================== --}}
<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
        <a href="{{ route('catalog') }}" class="flex items-center gap-3 shrink-0">
            <img src="{{ asset('images/logo/lushdailylogo.png') }}"
                 alt="Lush Daily Logo"
                 class="h-10 w-10 object-contain rounded-full" />
            <span class="text-brand-green font-bold text-xl leading-tight tracking-tight">
                Lush Daily
            </span>
        </a>

        <a href="https://wa.me/6285693148863"
           target="_blank"
           rel="noopener noreferrer"
           class="wa-btn inline-flex items-center gap-2 text-white text-sm font-semibold px-4 py-2 rounded-full shadow">
            @include('partials.wa-icon')
            Hubungi Kami
        </a>
    </div>
</header>

{{-- ===================== HERO ===================== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-brand-green via-green-700 to-brand-lime py-16 px-4 text-center text-white">
    <div class="max-w-3xl mx-auto">
        <img src="{{ asset('images/logo/lushdailylogo.png') }}"
             alt="Lush Daily"
             class="mx-auto mb-5 h-24 w-24 rounded-full border-4 border-white/30 shadow-xl object-contain bg-white/10 p-1" />

        <h1 class="text-3xl sm:text-4xl font-bold leading-tight mb-3">
            Buah Segar &amp; Frozen Food<br />
            <span class="text-brand-yellow">Langsung ke Pintu Rumahmu 🍊</span>
        </h1>
        <p class="text-white/80 text-base sm:text-lg mb-6">
            Kualitas premium, harga terjangkau. Pesan via WhatsApp — cepat, mudah, terpercaya.
        </p>
        <a href="#catalog"
           class="inline-block bg-brand-yellow text-brand-green font-bold px-8 py-3 rounded-full shadow-lg hover:brightness-105 transition">
            Lihat Semua Produk ↓
        </a>
    </div>

    {{-- Decorative blobs --}}
    <div class="pointer-events-none absolute -top-10 -left-10 w-48 h-48 rounded-full bg-white/5"></div>
    <div class="pointer-events-none absolute -bottom-14 -right-10 w-64 h-64 rounded-full bg-white/5"></div>
</section>

{{-- ===================== CATALOG ===================== --}}
<main id="catalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <h2 class="text-2xl font-bold text-brand-green mb-2">Katalog Produk</h2>
    <p class="text-gray-500 text-sm mb-8">{{ $products->count() }} produk tersedia · Klik "Pesan via WhatsApp" untuk order</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-5">
        @foreach ($products as $product)
        <article class="card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col">

            {{-- Product Image --}}
            <div class="relative w-full aspect-square bg-gray-100 img-skeleton overflow-hidden">
                <img src="{{ $product['image'] }}"
                     alt="Produk Lush Daily #{{ $product['id'] }}"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-full object-cover absolute inset-0 opacity-0 transition-opacity duration-300"
                     onload="this.classList.remove('opacity-0'); this.parentElement.classList.remove('img-skeleton')" />
            </div>

            {{-- Caption --}}
            <div class="p-3 flex-1 flex flex-col gap-3">
                <p class="caption-text text-gray-700 text-xs leading-relaxed flex-1">{{ $product['caption'] }}</p>

                {{-- WhatsApp Button --}}
                <a href="https://wa.me/6285693148863?text={{ $product['whatsapp_message'] }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="wa-btn flex items-center justify-center gap-1.5 text-white text-xs font-semibold py-2 px-3 rounded-xl shadow">
                    @include('partials.wa-icon', ['size' => 14])
                    Pesan via WA
                </a>
            </div>

        </article>
        @endforeach
    </div>
</main>

{{-- ===================== FOOTER ===================== --}}
<footer class="bg-brand-green text-white mt-16 py-10 px-4 text-center">
    <img src="{{ asset('images/logo/lushdailylogo.png') }}"
         alt="Lush Daily"
         class="mx-auto mb-3 h-12 w-12 rounded-full border-2 border-white/30 object-contain bg-white/10 p-0.5" />
    <p class="font-bold text-lg">Lush Daily</p>
    <p class="text-white/70 text-sm mt-1">Freshness Delivered to Your Doorstep</p>
    <a href="https://wa.me/6285693148863"
       target="_blank"
       rel="noopener noreferrer"
       class="inline-flex items-center gap-2 mt-4 bg-white/10 hover:bg-white/20 transition px-5 py-2 rounded-full text-sm font-medium">
        @include('partials.wa-icon')
        +62 856-9314-8863
    </a>
    <p class="text-white/40 text-xs mt-6">&copy; {{ date('Y') }} Lush Daily. All rights reserved.</p>
</footer>

</body>
</html>
