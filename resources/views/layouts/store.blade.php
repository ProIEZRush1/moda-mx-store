<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Moda MX') — Boutique de Moda Mexicana</title>
    <meta name="description" content="Moda MX: ropa y accesorios con estilo mexicano. Mujer, hombre, niños, calzado y más.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-gray-900 antialiased flex flex-col font-sans">

    <header x-data="{ open: false }" class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-[#7C3AED] to-[#DB2777] text-white font-bold">M</span>
                    <span class="text-xl font-bold tracking-tight">Moda<span class="text-[#DB2777]">MX</span></span>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" class="hover:text-[#7C3AED] transition">Inicio</a>
                    <a href="{{ route('catalog') }}" class="hover:text-[#7C3AED] transition">Tienda</a>
                    @foreach(($navCategories ?? collect())->take(5) as $cat)
                        <a href="{{ route('catalog', ['category' => $cat->slug]) }}" class="hover:text-[#7C3AED] transition">{{ $cat->name }}</a>
                    @endforeach
                </nav>

                <div class="flex items-center gap-3">
                    <form action="{{ route('catalog') }}" method="GET" class="hidden sm:block">
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar..."
                                class="w-40 lg:w-56 rounded-full border border-gray-200 bg-gray-50 py-2 pl-4 pr-10 text-sm focus:border-[#7C3AED] focus:ring-1 focus:ring-[#7C3AED] focus:outline-none">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7C3AED]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>
                    </form>

                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center rounded-full p-2 text-gray-700 hover:bg-violet-50 hover:text-[#7C3AED] transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-[#DB2777] text-[10px] font-bold text-white">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <button @click="open = !open" class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>

            <div x-show="open" x-cloak class="md:hidden pb-4 space-y-1">
                <form action="{{ route('catalog') }}" method="GET" class="pb-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar productos..."
                        class="w-full rounded-full border border-gray-200 bg-gray-50 py-2 px-4 text-sm focus:border-[#7C3AED] focus:outline-none">
                </form>
                <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-violet-50">Inicio</a>
                <a href="{{ route('catalog') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-violet-50">Tienda</a>
                @foreach(($navCategories ?? collect()) as $cat)
                    <a href="{{ route('catalog', ['category' => $cat->slug]) }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-violet-50">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
            <div class="rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
            <div class="rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-16 bg-gray-900 text-gray-300">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid gap-8 md:grid-cols-3">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-[#7C3AED] to-[#DB2777] text-white font-bold">M</span>
                        <span class="text-xl font-bold text-white">Moda<span class="text-[#DB2777]">MX</span></span>
                    </div>
                    <p class="mt-4 text-sm text-gray-400">Boutique de moda mexicana. Prendas y accesorios con estilo para toda la familia.</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Categorías</h3>
                    <ul class="mt-4 space-y-2 text-sm">
                        @foreach(($navCategories ?? collect()) as $cat)
                            <li><a href="{{ route('catalog', ['category' => $cat->slug]) }}" class="hover:text-[#DB2777]">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider">¿Quieres tu sitio?</h3>
                    <p class="mt-4 text-sm text-gray-400">
                        <a href="https://wa.me/5215594356241" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-[#25D366] px-4 py-2 font-semibold text-white hover:opacity-90">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.8 14.01c-.24.68-1.42 1.3-1.95 1.35-.5.05-1.13.07-1.82-.11-.42-.13-.96-.31-1.65-.61-2.9-1.25-4.79-4.17-4.94-4.37-.14-.2-1.18-1.57-1.18-3 0-1.42.75-2.12 1.01-2.41.27-.29.58-.36.78-.36.19 0 .39 0 .56.01.18.01.42-.07.66.5.24.59.82 2.03.89 2.18.07.14.12.31.02.5-.09.2-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.28-.12.56.16.27.71 1.18 1.53 1.9 1.05.94 1.94 1.23 2.21 1.37.27.14.43.12.59-.07.16-.2.68-.79.86-1.06.18-.27.36-.22.61-.13.25.09 1.6.75 1.87.89.27.14.45.2.52.32.07.12.07.66-.17 1.34z"/></svg>
                            Escríbenos por WhatsApp
                        </a>
                    </p>
                </div>
            </div>
            <div class="mt-10 border-t border-gray-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Moda MX. Todos los derechos reservados.</p>
                <p>Desarrollado por <a href="https://wa.me/5215594356241" target="_blank" rel="noopener" class="font-semibold text-[#DB2777] hover:underline">Overcloud</a></p>
            </div>
        </div>
    </footer>

</body>
</html>
