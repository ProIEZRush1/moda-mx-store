@props(['product'])

<a href="{{ route('product', $product->slug) }}" class="group block">
    <div class="relative aspect-[4/5] overflow-hidden rounded-2xl bg-gray-100">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
            class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @if($product->is_featured)
            <span class="absolute left-3 top-3 rounded-full bg-[#DB2777] px-2.5 py-1 text-[11px] font-semibold text-white">Destacado</span>
        @endif
        @if($product->stock <= 0)
            <span class="absolute right-3 top-3 rounded-full bg-gray-900/80 px-2.5 py-1 text-[11px] font-semibold text-white">Agotado</span>
        @endif
    </div>
    <div class="mt-3">
        @if($product->category)
            <p class="text-xs uppercase tracking-wide text-gray-400">{{ $product->category->name }}</p>
        @endif
        <h3 class="mt-1 text-sm font-medium text-gray-900 group-hover:text-[#7C3AED] line-clamp-1">{{ $product->name }}</h3>
        <p class="mt-1 text-base font-bold text-gray-900">${{ number_format($product->price, 2) }} <span class="text-xs font-normal text-gray-400">MXN</span></p>
    </div>
</a>
