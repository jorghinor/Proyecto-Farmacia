@extends('layouts.app')

@section('title', $medicamento->nombre . ' - Farmacia La Salud')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-10">
        <div class="md:flex">
            <!-- Imagen -->
            <div class="md:flex-shrink-0 bg-gray-100 w-full md:w-1/2 flex items-center justify-center min-h-[300px] overflow-hidden">
                @if($medicamento->imagen)
                    <img src="{{ asset('storage/' . $medicamento->imagen) }}" alt="{{ $medicamento->nombre }}" class="h-full w-full object-cover">
                @else
                    <span class="text-9xl">💊</span>
                @endif
            </div>

            <!-- Información -->
            <div class="p-8 w-full md:w-1/2 flex flex-col justify-center">
                <div class="uppercase tracking-wide text-sm text-blue-600 font-semibold mb-1">
                    {{ $medicamento->proveedor->nombre ?? 'Proveedor Desconocido' }}
                </div>

                <h1 class="block mt-1 text-3xl leading-tight font-bold text-gray-900">
                    {{ $medicamento->nombre }}
                </h1>

                <p class="mt-4 text-gray-500">
                    Medicamento de alta calidad disponible en nuestra farmacia.
                    Consulta con tu médico antes de consumir este producto.
                </p>

                <div class="mt-6 border-t border-gray-100 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-gray-600">Precio:</span>
                        <span class="text-3xl font-bold text-green-600">${{ number_format($medicamento->precio, 2) }}</span>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <span class="text-gray-600">Disponibilidad:</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $medicamento->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $medicamento->stock > 0 ? 'En Stock (' . $medicamento->stock . ')' : 'Agotado' }}
                        </span>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('catalogo.index') }}" class="flex-1 bg-gray-100 text-gray-800 text-center py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                            ← Volver
                        </a>

                        <form action="{{ route('cart.add', $medicamento->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-md">
                                Añadir al Carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
