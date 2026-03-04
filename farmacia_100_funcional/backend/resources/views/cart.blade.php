@extends('layouts.app')

@section('title', 'Mi Carrito de Compras')

@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Mi Carrito</h2>

    @if(count($cart) > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left p-4">Producto</th>
                        <th class="text-left p-4">Precio</th>
                        <th class="text-left p-4">Cantidad</th>
                        <th class="text-left p-4">Subtotal</th>
                        <th class="text-left p-4"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $details)
                        <tr class="border-b">
                            <td class="p-4 flex items-center">
                                <div class="h-16 w-16 bg-gray-100 rounded-md mr-4 flex items-center justify-center overflow-hidden">
                                    @if($details['imagen'])
                                        <img src="{{ asset('storage/' . $details['imagen']) }}" alt="{{ $details['nombre'] }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-2xl">💊</span>
                                    @endif
                                </div>
                                <span>{{ $details['nombre'] }}</span>
                            </td>
                            <td class="p-4">${{ number_format($details['precio'], 2) }}</td>
                            <td class="p-4">
                                <form action="{{ route('cart.update', $id) }}" method="POST">
                                    @csrf
                                    <input type="number" name="cantidad" value="{{ $details['cantidad'] }}" class="w-20 border border-gray-300 rounded-lg px-2 py-1">
                                    <button type="submit" class="text-xs text-blue-500 hover:underline">Actualizar</button>
                                </form>
                            </td>
                            <td class="p-4">${{ number_format($details['precio'] * $details['cantidad'], 2) }}</td>
                            <td class="p-4">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-6">
                <p class="text-2xl font-bold">Total: ${{ number_format($total, 2) }}</p>
                <form action="{{ route('cart.checkout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        Finalizar Compra
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">Tu carrito está vacío.</p>
            <a href="{{ route('catalogo.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700">
                Ir al Catálogo
            </a>
        </div>
    @endif
@endsection
