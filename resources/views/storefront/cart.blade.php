@extends('layouts.store')

@section('title', 'Carrito')

@section('content')
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold tracking-tight">Tu carrito</h1>

        @if(empty($items))
            <div class="mt-10 rounded-2xl border border-dashed border-gray-200 py-20 text-center">
                <p class="text-gray-500">Tu carrito está vacío.</p>
                <a href="{{ route('catalog') }}" class="mt-4 inline-block rounded-full bg-[#7C3AED] px-6 py-3 text-sm font-semibold text-white hover:opacity-90">Ir a la tienda</a>
            </div>
        @else
            <div class="mt-8 grid gap-10 lg:grid-cols-[1fr_360px]">
                {{-- Items --}}
                <div class="divide-y divide-gray-100 rounded-2xl border border-gray-100">
                    @foreach($items as $item)
                        <div class="flex gap-4 p-4 sm:p-6">
                            <a href="{{ route('product', $item['slug']) }}" class="shrink-0">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-24 w-20 rounded-xl object-cover">
                            </a>
                            <div class="flex flex-1 flex-col">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <a href="{{ route('product', $item['slug']) }}" class="font-medium text-gray-900 hover:text-[#7C3AED]">{{ $item['name'] }}</a>
                                        @if($item['size'])
                                            <p class="mt-0.5 text-sm text-gray-500">Talla: {{ $item['size'] }}</p>
                                        @endif
                                        <p class="mt-0.5 text-sm text-gray-500">${{ number_format($item['price'], 2) }} c/u</p>
                                    </div>
                                    <p class="text-base font-bold text-gray-900 whitespace-nowrap">${{ number_format($item['line_total'], 2) }}</p>
                                </div>

                                <div class="mt-auto flex items-center justify-between pt-3">
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $item['key'] }}">
                                        <div class="inline-flex items-center rounded-lg border border-gray-200">
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-3 py-1.5 text-gray-600 hover:text-[#7C3AED]">−</button>
                                            <span class="w-10 text-center text-sm">{{ $item['quantity'] }}</span>
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-3 py-1.5 text-gray-600 hover:text-[#7C3AED]">+</button>
                                        </div>
                                    </form>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{ $item['key'] }}">
                                        <button type="submit" class="text-sm font-medium text-gray-400 hover:text-red-500">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Summary --}}
                <aside class="lg:sticky lg:top-24 lg:self-start">
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-6">
                        <h2 class="text-lg font-bold">Resumen</h2>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Subtotal</dt>
                                <dd class="font-medium">${{ number_format($total, 2) }} MXN</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Envío</dt>
                                <dd class="font-medium text-green-600">Gratis</dd>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-3 text-base">
                                <dt class="font-bold">Total</dt>
                                <dd class="font-extrabold">${{ number_format($total, 2) }} MXN</dd>
                            </div>
                        </dl>

                        <form action="{{ route('checkout') }}" method="POST" class="mt-6">
                            @csrf
                            <button type="submit" class="w-full rounded-full bg-gradient-to-r from-[#7C3AED] to-[#DB2777] px-8 py-4 text-base font-semibold text-white shadow-lg transition hover:opacity-90">
                                Pagar
                            </button>
                        </form>
                        <a href="{{ route('catalog') }}" class="mt-3 block text-center text-sm font-medium text-[#7C3AED] hover:underline">Seguir comprando</a>
                    </div>
                </aside>
            </div>
        @endif
    </div>
@endsection
