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

        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .product-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 0.75rem;
            gap: 0.75rem;
            min-height: 0;
        }
        .caption-text {
            flex: 1;
            white-space: pre-line;
            word-break: normal;
            overflow-wrap: break-word;
            hyphens: auto;
            overflow-y: auto;
            max-height: 160px;
            scrollbar-width: thin;
            scrollbar-color: #d1d5db transparent;
        }
        .caption-text::-webkit-scrollbar { width: 3px; }
        .caption-text::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }
        .caption-text strong, .caption-text b { font-weight: 700; }
        .caption-text em { font-style: italic; }
        .caption-text ul, .caption-text ol { padding-left: 1.2em; margin: 0.25em 0; }
        .caption-text li { margin-bottom: 0.1em; }
        .caption-text p { margin: 0 0 0.25em; }
        .wa-fixed { margin-top: auto; flex-shrink: 0; }

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

        /* Navbar logo bob */
        @keyframes logoBob {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-5px); }
        }
        .logo-bob { animation: logoBob 2.5s ease-in-out infinite; }

        /* ── Hero floating logo background ── */
        .floating-item {
            position: absolute;
            z-index: 1;
            opacity: 0.13;
            border-radius: 0;
            object-fit: contain;
            pointer-events: none;
            user-select: none;
        }
        .item-1 {
            width: 250px;
            top: -20%;
            left: -10%;
            animation: floatComplex1 25s ease-in-out infinite alternate;
        }
        .item-2 {
            width: 180px;
            bottom: -10%;
            right: 5%;
            animation: floatComplex2 20s ease-in-out infinite alternate;
        }
        .item-3 {
            width: 120px;
            top: 30%;
            left: 40%;
            animation: floatComplex3 15s ease-in-out infinite alternate;
        }
        @keyframes floatComplex1 {
            0%   { transform: translate(0, 0) rotate(0deg); }
            50%  { transform: translate(40vw, 20vh) rotate(45deg); }
            100% { transform: translate(10vw, 60vh) rotate(90deg); }
        }
        @keyframes floatComplex2 {
            0%   { transform: translate(0, 0) rotate(0deg); }
            50%  { transform: translate(-30vw, -30vh) rotate(-30deg); }
            100% { transform: translate(-50vw, -10vh) rotate(-60deg); }
        }
        @keyframes floatComplex3 {
            0%   { transform: translate(0, 0) scale(1); }
            50%  { transform: translate(20vw, -15vh) scale(1.2); }
            100% { transform: translate(-10vw, 15vh) scale(0.9); }
        }
        /* Hero content selalu di atas */
        .hero-content {
            position: relative;
            z-index: 10;
        }
        /* Logo utama di hero content */
        .hero-logo {
            width: 192px;
            height: 192px;
            object-fit: contain;
            margin: 0 auto 1.25rem;
            display: block;
            filter: drop-shadow(0 6px 16px rgba(0,0,0,0.25));
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
                 class="h-10 w-10 object-contain logo-bob" />
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

    {{-- Lapisan 1: Logo melayang sebagai background (z-index rendah) --}}
    <img src="{{ asset('images/logo/lushdailylogo.png') }}" alt="" class="floating-item item-1" aria-hidden="true">
    <img src="{{ asset('images/logo/lushdailylogo.png') }}" alt="" class="floating-item item-2" aria-hidden="true">
    <img src="{{ asset('images/logo/lushdailylogo.png') }}" alt="" class="floating-item item-3" aria-hidden="true">

    {{-- Lapisan 2: Konten utama (z-index tinggi) --}}
    <div class="hero-content max-w-3xl mx-auto">
        <img src="{{ asset('images/logo/lushdailylogo.png') }}"
             alt="Lush Daily"
             class="hero-logo" />

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

</section>

{{-- ===================== CATALOG ===================== --}}
<main id="catalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Open PO Banner --}}
    <div class="mb-6 rounded-2xl bg-gradient-to-r from-brand-green to-brand-lime text-white px-5 py-4 flex flex-col sm:flex-row sm:items-center gap-2 shadow-md">
        <div class="text-2xl">🛒</div>
        <div>
            <p class="font-bold text-base sm:text-lg leading-tight">Open PO Buah Segar &amp; Frozen Food</p>
            <p class="text-white/80 text-sm font-medium">Ready 1 minggu</p>
        </div>
    </div>

    {{-- Note pengiriman --}}
    <div class="mb-6 rounded-xl bg-brand-yellow/20 border border-brand-yellow text-brand-green px-4 py-3 text-sm font-medium flex gap-2 items-start">
        <span class="text-base">📌</span>
        <span><strong>Note:</strong> Hanya melayani pengiriman daerah DKI Jakarta &amp; Harga belum termasuk ongkir</span>
    </div>

    <h2 class="text-2xl font-bold text-brand-green mb-2">Katalog Produk</h2>
    <p class="text-gray-500 text-sm mb-8">{{ $products->count() }} produk tersedia · Klik "Pesan via WhatsApp" untuk order</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-5 items-stretch">
        @foreach ($products as $product)
        <article id="product-{{ $product['id'] }}" class="card-hover product-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">

            {{-- Product Image --}}
            <div class="relative w-full aspect-square bg-gray-100 img-skeleton overflow-hidden" style="flex-shrink:0">
                <img src="{{ $product['image'] }}"
                     alt="Produk Lush Daily #{{ $product['id'] }}"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-full object-cover absolute inset-0 opacity-0 transition-opacity duration-300"
                     onload="this.classList.remove('opacity-0'); this.parentElement.classList.remove('img-skeleton')" />
            </div>

            {{-- Caption + Button --}}
            <div class="card-body">
                <div class="caption-text text-gray-700 text-xs leading-relaxed">{!! $product['caption'] !!}</div>

                {{-- WhatsApp Button --}}
                <a href="https://wa.me/6285693148863?text={{ $product['whatsapp_message'] }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="wa-btn wa-fixed flex items-center justify-center gap-1.5 text-white text-xs font-semibold py-2 px-3 rounded-xl shadow">
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
         class="mx-auto mb-3 h-12 w-12 object-contain drop-shadow-md logo-bob" />
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
