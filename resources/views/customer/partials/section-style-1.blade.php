<div class="bg-primary p-4 rounded-lg text-center h-full flex flex-col">
    <a href="{{ route('customer.products.show', $product['slug']) }}" class="block mb-4">
        <img src="{{ $product['main_image'] }}" alt="{{ $product['name'] }}" class="w-full h-60 object-cover rounded">
    </a>
    <h4 class="font-semibold text-secondary mb-2 truncate">{{ $product['name'] }}</h4>
    <p class="text-sm text-gray-400 mt-auto">
        @if($product['compare_price'] && $product['compare_price'] > $product['price'])
            <span class="line-through mr-1 text-xs">₹{{ number_format($product['compare_price']) }}</span>
        @endif
        <span class="text-secondary">₹{{ number_format($product['price']) }}</span>
    </p>
</div>