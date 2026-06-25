@extends('layouts.store')

@section('title', 'Inicio')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#7C3AED] via-[#9333EA] to-[#DB2777]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="max-w-2xl text-white">
                <span class="inline-block rounded-full bg-white/15 px-4 py-1.5 text-sm font-medium backdrop-blur">Nueva temporada 2026</span>
                <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight">
                    Moda mexicana con estilo propio
                </h1>
                <p class="mt-5 text-lg text-violet-100">
                    Descubre prendas y accesorios para mujer, hombre y niños. Calidad, diseño y la esencia de México en cada pieza.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('catalog') }}" class="rounded-full bg-white px-7 py-3 text-base font-semibold text-[#7C3AED] shadow-lg hover:bg-violet-50 transition">Ver tienda</a>
                    <a href="{{ route('catalog', ['category' => 'mujer']) }}" class="rounded-full border border-white/40 px-7 py-3 text-base font-semibold text-white hover:bg-white/10 transition">Colección Mujer</a>
                </div>
            </div>
        </div>
        <div class="absolute -right-20 -bottom-20 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
        <div class="absolute right-40 top-10 h-40 w-40 rounded-full bg-pink-300/20 blur-2xl"></div>
    </section>

    {{-- Categories --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14">
        <div class="flex items-end justify-between">
            <h2 class="text-2xl font-bold tracking-tight">Explora por categoría</h2>
            <a href="{{ route('catalog') }}" class="text-sm font-semibold text-[#7C3AED] hover:underline">Ver todo</a>
        </div>
        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
            @foreach($categories as $cat)
                <a href="{{ route('catalog', ['category' => $cat->slug]) }}"
                   class="group relative flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-violet-100 to-pink-100 p-4 text-center transition hover:shadow-lg">
                    <div>
                        <p class="text-lg font-bold text-gray-900 group-hover:text-[#7C3AED]">{{ $cat->name }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $cat->products_count }} productos</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Featured --}}
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex items-end justify-between">
            <h2 class="text-2xl font-bold tracking-tight">Productos destacados</h2>
            <a href="{{ route('catalog') }}" class="text-sm font-semibold text-[#7C3AED] hover:underline">Ver más</a>
        </div>
        @if($featured->isEmpty())
            <p class="mt-6 text-gray-500">Aún no hay productos destacados.</p>
        @else
            <div class="mt-6 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($featured as $product)
                    @include('storefront.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        @endif
    </section>

    {{-- Trust strip --}}
    <section class="bg-violet-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 grid gap-6 sm:grid-cols-3 text-center">
            <div>
                <p class="text-lg font-bold text-[#7C3AED]">Envíos a todo México</p>
                <p class="text-sm text-gray-500">Recibe tus prendas en la puerta de tu casa.</p>
            </div>
            <div>
                <p class="text-lg font-bold text-[#7C3AED]">Pago seguro</p>
                <p class="text-sm text-gray-500">Procesamos pagos con Stripe.</p>
            </div>
            <div>
                <p class="text-lg font-bold text-[#7C3AED]">Calidad garantizada</p>
                <p class="text-sm text-gray-500">Prendas seleccionadas con cuidado.</p>
            </div>
        </div>
    </section>
@endsection
