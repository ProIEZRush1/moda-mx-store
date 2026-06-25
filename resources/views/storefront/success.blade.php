@extends('layouts.store')

@section('title', 'Pago exitoso')

@section('content')
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-20 text-center">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100">
            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h1 class="mt-6 text-3xl font-bold tracking-tight">¡Gracias por tu compra!</h1>
        <p class="mt-3 text-gray-500">Tu pedido se ha registrado correctamente.</p>

        @if($order)
            <div class="mt-8 rounded-2xl border border-gray-100 bg-gray-50 p-6 text-left">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Número de pedido</span>
                    <span class="font-semibold">{{ $order->order_number }}</span>
                </div>
                <div class="mt-2 flex justify-between text-sm">
                    <span class="text-gray-500">Estado</span>
                    <span class="font-semibold capitalize">{{ $order->status === 'paid' ? 'Pagado' : ucfirst($order->status) }}</span>
                </div>
                <div class="mt-2 flex justify-between text-sm">
                    <span class="text-gray-500">Total</span>
                    <span class="font-semibold">${{ number_format($order->total, 2) }} MXN</span>
                </div>
            </div>
        @endif

        <a href="{{ route('catalog') }}" class="mt-8 inline-block rounded-full bg-[#7C3AED] px-7 py-3 text-base font-semibold text-white hover:opacity-90">Seguir comprando</a>
    </div>
@endsection
