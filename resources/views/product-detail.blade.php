@php
$waText    = strip_tags($product->caption);
$waText    = html_entity_decode($waText, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$waText    = str_replace("\xc2\xa0", ' ', $waText);
$waText    = preg_replace("/\n{3,}/", "\n\n", trim($waText));
$waRaw = "Halo Lush Daily! 👋\n\nSaya ingin memesan:\n\n"
       . $waText
       . "\n\n🔗 " . request()->fullUrl()
       . "\n\nMohon info ketersediaan dan cara pemesanannya. Terima kasih! 🙏";

$waMessage = rawurlencode($waRaw); // hanya untuk href
// $waRaw tetap tersedia sebagai teks manusiawi jika ingin ditampilkan
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ $product->title }} — Lush Daily" />
    <title>{{ $product->title }} | Lush Daily</title>

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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    {{-- Swiper.js --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        html { scroll-behavior: smooth; }

        .wa-btn {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .wa-btn:hover  { opacity: 0.92; transform: scale(1.02); }
        .wa-btn:active { transform: scale(0.98); }

        /* ── Swiper main ── */
        .swiper-main {
            width: 100%;
            border-radius: 1rem;
            overflow: hidden;
            background: #f3f4f6;
        }
        .swiper-main .swiper-slide img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            display: block;
        }
        .swiper-main .swiper-button-next,
        .swiper-main .swiper-button-prev {
            color: #fff;
            background: rgba(0,0,0,0.35);
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }
        .swiper-main .swiper-button-next::after,
        .swiper-main .swiper-button-prev::after {
            font-size: 14px;
            font-weight: 700;
        }
        .swiper-main .swiper-pagination-bullet-active {
            background: #2d7a2f;
        }

        /* ── Swiper thumbnails ── */
        .swiper-thumbs {
            margin-top: 0.75rem;
        }
        .swiper-thumbs .swiper-slide {
            width: 72px !important;
            height: 72px !important;
            border-radius: 0.5rem;
            overflow: hidden;
            opacity: 0.55;
            cursor: pointer;
            border: 2px solid transparent;
            transition: opacity 0.2s, border-color 0.2s;
        }
        .swiper-thumbs .swiper-slide-thumb-active {
            opacity: 1;
            border-color: #2d7a2f;
        }
        .swiper-thumbs .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Description from Quill */
        .product-description { line-height: 1.75; }
        .product-description strong, .product-description b { font-weight: 700; }
        .product-description em { font-style: italic; }
        .product-description ul, .product-description ol { padding-left: 1.4em; margin: 0.5em 0; }
        .product-description li { margin-bottom: 0.25em; }
        .product-description p  { margin-bottom: 0.5em; }

        /* Single-image fallback: no nav buttons */
        .swiper-main.single-image .swiper-button-next,
        .swiper-main.single-image .swiper-button-prev,
        .swiper-main.single-image .swiper-pagination { display: none; }
    </style>
</head>

<body class="bg-brand-cream font-sans antialiased">

{{-- NAVBAR --}}
<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
        <a href="{{ route('catalog') }}" class="flex items-center gap-3 shrink-0">
            <img src="{{ asset('images/logo/lushdailylogo.png') }}"
                 alt="Lush Daily Logo"
                 class="h-10 w-10 object-contain" />
            <span class="text-brand-green font-bold text-xl leading-tight tracking-tight">Lush Daily</span>
        </a>
        <a href="{{ route('catalog') }}"
           class="text-brand-green text-sm font-medium hover:underline flex items-center gap-1">
            ← Kembali ke Katalog
        </a>
    </div>
</header>

{{-- PRODUCT DETAIL --}}
<main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-gray-400 mb-6 flex items-center gap-1.5">
        <a href="{{ route('catalog') }}" class="hover:text-brand-green">Katalog</a>
        <span>/</span>
        <span class="text-gray-600">{{ $product->title }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">

        {{-- LEFT: Image Gallery --}}
        <div>
            @php $allImages = $product->all_image_urls; @endphp
            @php $isSingle  = count($allImages) === 1; @endphp

            {{-- Main Swiper --}}
            <div class="swiper swiper-main {{ $isSingle ? 'single-image' : '' }}" id="swiperMain">
                <div class="swiper-wrapper">
                    @foreach($allImages as $imgUrl)
                    <div class="swiper-slide">
                        <img src="{{ $imgUrl }}"
                             alt="{{ $product->title }}"
                             loading="lazy"
                             decoding="async" />
                    </div>
                    @endforeach
                </div>
                @if(! $isSingle)
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination"></div>
                @endif
            </div>

            {{-- Thumbnails --}}
            @if(! $isSingle)
            <div class="swiper swiper-thumbs" id="swiperThumbs">
                <div class="swiper-wrapper">
                    @foreach($allImages as $imgUrl)
                    <div class="swiper-slide">
                        <img src="{{ $imgUrl }}" alt="" loading="lazy" />
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- RIGHT: Info --}}
        <div class="flex flex-col gap-5">

            {{-- Name --}}
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 leading-tight">
                {{ $product->title }}
            </h1>

            {{-- Description --}}
            <div class="product-description text-gray-600 text-sm">
                {!! $product->caption !!}
            </div>

            {{-- Divider --}}
            <hr class="border-gray-200">

            {{-- CTA --}}
            <div class="flex flex-col gap-3">
                <a href="https://wa.me/6285693148863?text={!! $waMessage !!}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="wa-btn inline-flex items-center justify-center gap-2 text-white font-semibold px-6 py-3 rounded-2xl shadow-lg text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.119.554 4.109 1.524 5.834L.057 23.426a.5.5 0 0 0 .614.614l5.604-1.468A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.933 0-3.741-.524-5.29-1.436l-.38-.225-3.323.871.886-3.236-.247-.393A9.955 9.955 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                    </svg>
                    Pesan via WhatsApp
                </a>
                <a href="{{ route('catalog') }}"
                   class="text-center text-brand-green text-sm font-medium hover:underline">
                    ← Lihat produk lainnya
                </a>
            </div>

        </div>
    </div>

</main>

{{-- FOOTER --}}
<footer class="bg-brand-green text-white mt-16 py-8 px-4 text-center">
    <p class="font-bold text-lg">Lush Daily</p>
    <p class="text-white/70 text-sm mt-1">Freshness Delivered to Your Doorstep</p>
    <p class="text-white/40 text-xs mt-4">&copy; {{ date('Y') }} Lush Daily. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(! $isSingle)
    var thumbs = new Swiper('#swiperThumbs', {
        spaceBetween: 8,
        slidesPerView: 'auto',
        freeMode: true,
        watchSlidesProgress: true,
    });

    new Swiper('#swiperMain', {
        spaceBetween: 0,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        thumbs: { swiper: thumbs },
    });
    @endif
});
</script>

</body>
</html>
