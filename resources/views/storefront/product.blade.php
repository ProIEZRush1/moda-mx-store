@extends('layouts.store')

@section('title', $product->name)

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-[#7C3AED]">Inicio</a>
            <span class="mx-2">/</span>
            <a href="{{ route('catalog') }}" class="hover:text-[#7C3AED]">Tienda</a>
            @if($product->category)
                <span class="mx-2">/</span>
                <a href="{{ route('catalog', ['category' => $product->category->slug]) }}" class="hover:text-[#7C3AED]">{{ $product->category->name }}</a>
            @endif
        </nav>

        <div class="mt-6 grid gap-10 lg:grid-cols-2">
            <div class="overflow-hidden rounded-3xl bg-gray-100">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
            </div>

            <div x-data="{ size: {{ $product->sizes && count($product->sizes) ? "'".$product->sizes[0]."'" : 'null' }}, qty: 1 }">
                @if($product->category)
                    <p class="text-sm uppercase tracking-wide text-[#7C3AED] font-semibold">{{ $product->category->name }}</p>
                @endif
                <h1 class="mt-2 text-3xl font-bold tracking-tight">{{ $product->name }}</h1>
                <p class="mt-4 text-3xl font-extrabold text-gray-900">${{ number_format($product->price, 2) }} <span class="text-base font-normal text-gray-400">MXN</span></p>

                @if($product->stock > 0)
                    <p class="mt-2 text-sm text-green-600 font-medium">En stock ({{ $product->stock }} disponibles)</p>
                @else
                    <p class="mt-2 text-sm text-red-600 font-medium">Agotado</p>
                @endif

                <div class="mt-6 prose prose-sm max-w-none text-gray-600">
                    <p>{{ $product->description }}</p>
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    @if($product->sizes && count($product->sizes))
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Talla</label>
                            <input type="hidden" name="size" :value="size">
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($product->sizes as $s)
                                    <button type="button" @click="size = '{{ $s }}'"
                                        :class="size === '{{ $s }}' ? 'border-[#7C3AED] bg-[#7C3AED] text-white' : 'border-gray-200 text-gray-700 hover:border-[#7C3AED]'"
                                        class="min-w-[3rem] rounded-lg border px-3 py-2 text-sm font-medium transition">{{ $s }}</button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Cantidad</label>
                        <div class="mt-2 inline-flex items-center rounded-lg border border-gray-200">
                            <button type="button" @click="qty = Math.max(1, qty - 1)" class="px-3 py-2 text-lg text-gray-600 hover:text-[#7C3AED]">−</button>
                            <input type="number" name="quantity" min="1" max="99" x-model="qty" class="w-14 border-x border-gray-200 py-2 text-center text-sm focus:outline-none">
                            <button type="button" @click="qty = Math.min(99, qty + 1)" class="px-3 py-2 text-lg text-gray-600 hover:text-[#7C3AED]">+</button>
                        </div>
                    </div>

                    <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}
                        class="w-full rounded-full bg-gradient-to-r from-[#7C3AED] to-[#DB2777] px-8 py-4 text-base font-semibold text-white shadow-lg transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50">
                        {{ $product->stock > 0 ? 'Agregar al carrito' : 'Agotado' }}
                    </button>
                </form>
            </div>
        </div>

        @if($related->isNotEmpty())
            <div class="mt-20">
                <h2 class="text-2xl font-bold tracking-tight">También te puede gustar</h2>
                <div class="mt-6 grid grid-cols-2 gap-5 sm:grid-cols-4">
                    @foreach($related as $rel)
                        @include('storefront.partials.product-card', ['product' => $rel])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
