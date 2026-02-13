@extends('customer.layouts.master')

@section('title', 'Home - Fashion Store')

@section('content')
<main class="py-0">
    <!-- Hero Banner Section -->
    <section class="w-full relative group">
        @if($banners->count() > 0)
            <div class="hero-slider">
                @foreach($banners as $banner)
                    @php
                        $bannerImage = $banner->image;
                        $bannerUrl = Str::startsWith($bannerImage, ['http://', 'https://']) 
                            ? $bannerImage 
                            : asset('storage/' . $bannerImage);
                    @endphp
                    <div class="relative w-full h-[500px] outline-none">
                        <img src="{{ $bannerUrl }}"
                            alt="{{ $banner->title ?? 'Fashion Collection' }}" class="w-full h-full object-cover">
                        
                        {{-- Optional: Banner Text/CTA Overlay --}}
                        @if($banner->title || $banner->subtitle)
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                            <div class="text-center text-white px-4">
                                @if($banner->subtitle)
                                    <p class="text-lg md:text-xl mb-2">{{ $banner->subtitle }}</p>
                                @endif
                                @if($banner->title)
                                    <h1 class="text-4xl md:text-6xl font-bold mb-6 drop-shadow-lg">{{ $banner->title }}</h1>
                                @endif
                                @if($banner->cta_link && $banner->cta_text)
                                    <a href="{{ $banner->cta_link }}" class="inline-block bg-white text-black px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors uppercase tracking-wider">
                                        {{ $banner->cta_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <!-- Slider Arrows (Custom Design if needed, but Slick provides default) -->
        @else
            <!-- Fallback Static Banner -->
            <div class="w-full h-96 relative">
                 <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=2070&q=80"
                        alt="Fashion Collection" class="w-full h-full object-cover">
                 <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                    <h1 class="text-4xl text-white font-bold">Welcome to Eulozia</h1>
                 </div>
            </div>
        @endif
    </section>

    <!-- Featured Collection Section -->
    <div class="container mx-auto mt-16">
        @if($sections && $sections->count() > 0)
            @php
                $featuredSection = $sections->firstWhere('title', 'Featured Collection');
            @endphp
            @if($featuredSection)
                <div class="mb-20">
                    <h2 class="text-3xl font-bold text-center mb-12">{{ $featuredSection->title }}</h2>
                    @if($featuredSection->subtitle)
                        <p class="text-center text-gray-500 -mt-10 mb-12">{{ $featuredSection->subtitle }}</p>
                    @endif

                    @if($featuredSection->products && count($featuredSection->products) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 px-6">
                            @foreach ($featuredSection->products as $product)
                                @include('customer.partials.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-10">No products found in this section.</div>
                    @endif
                </div>
            @endif
        @endif
    </div>

    <!-- Shop by Collection Section -->
    @if(isset($featuredCategories) && $featuredCategories->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Shop by Collection</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($featuredCategories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="flex flex-col items-center text-center group">
                    <div class="w-full h-40 md:h-56 flex items-center justify-center rounded-xl overflow-hidden bg-white shadow-sm group-hover:shadow-md transition-all duration-300">
                        @if($category->image)
                            <img src="{{ Str::startsWith($category->image->url, 'http') ? $category->image->url : asset('storage/' . $category->image->url) }}" 
                                 alt="{{ $category->name }}" class="object-cover h-full w-full group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="flex items-center justify-center h-full w-full text-gray-300 bg-gray-100">
                                <i class="fas fa-tshirt text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <p class="mt-4 font-medium text-gray-800 group-hover:text-primary transition-colors">{{ $category->name }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Explore More Collections Section (Dynamic) -->
    @if(isset($exploreMoreCategories) && $exploreMoreCategories->count() > 0)
    <section class="py-16">
        <div class="container mx-auto px-6 mb-10">
            <h2 class="text-3xl font-bold text-center mb-4">Explore More Collections</h2>
            <p class="text-center text-gray-500 mb-12">Discover our extensive range of fashion.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 w-full h-[600px]">
            @foreach($exploreMoreCategories as $category)
            <div class="relative group overflow-hidden h-full">
                @if($category->image)
                    <img src="{{ Str::startsWith($category->image->url, 'http') ? $category->image->url : asset('storage/' . $category->image->url) }}" 
                         alt="{{ $category->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No Image</span>
                    </div>
                @endif
                
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors duration-300 flex items-center justify-center">
                    <div class="text-center">
                        <h3 class="text-4xl font-bold text-white mb-4 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">{{ $category->name }}</h3>
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                           class="inline-block px-6 py-2 border-2 border-white text-white font-medium hover:bg-white hover:text-black transition-all duration-300 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 delay-100">
                            View Collection
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- End of Main Content -->


</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('.hero-slider').slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: false,  // You can set to true if you want arrows
            pauseOnHover: false
        });
    });
</script>
@endpush
