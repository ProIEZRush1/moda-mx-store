@extends('layouts.store')

@section('title', $activeCategory?->name ?? 'Tienda')

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">
                    {{ $activeCategory?->name ?? 'Toda la tienda' }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request('q'))
                        Resultados para "<strong>{{ request('q') }}</strong>" — {{ $products->total() }} productos
                    @else
                        {{ $products->total() }} productos disponibles
                    @endif
                </p>
            </div>
            <form action="{{ route('catalog') }}" method="GET" class="sm:w-72">
                @if($activeCategory)
                    <input type="hidden" name="category" value="{{ $activeCategory->slug }}">
                @endif
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar en la tienda..."
                        class="w-full rounded-full border border-gray-200 bg-gray-50 py-2.5 pl-4 pr-10 text-sm focus:border-[#7C3AED] focus:outline-none">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7C3AED]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-[220px_1fr]">
            {{-- Filters --}}
            <aside class="lg:sticky lg:top-24 lg:self-start">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500">Categorías</h2>
                <div class="mt-3 flex flex-wrap gap-2 lg:flex-col lg:gap-1">
                    <a href="{{ route('catalog', array_filter(['q' => request('q')])) }}"
                       class="rounded-full px-3 py-1.5 text-sm font-medium {{ ! $activeCategory ? 'bg-[#7C3AED] text-white' : 'bg-gray-100 text-gray-700 hover:bg-violet-50' }}">
                        Todas
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('catalog', array_filter(['category' => $cat->slug, 'q' => request('q')])) }}"
                           class="rounded-full px-3 py-1.5 text-sm font-medium {{ $activeCategory?->id === $cat->id ? 'bg-[#7C3AED] text-white' : 'bg-gray-100 text-gray-700 hover:bg-violet-50' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </aside>

            {{-- Grid --}}
            <div>
                @if($products->isEmpty())
                    <div class="rounded-2xl border border-dashed border-gray-200 py-20 text-center">
                        <p class="text-gray-500">No se encontraron productos.</p>
                        <a href="{{ route('catalog') }}" class="mt-3 inline-block text-sm font-semibold text-[#7C3AED] hover:underline">Ver toda la tienda</a>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-5 sm:grid-cols-3">
                        @foreach($products as $product)
                            @include('storefront.partials.product-card', ['product' => $product])
                        @endforeach
                    </div>
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
