@extends('layouts.app')

@section('title', 'Catálogo de Medicamentos')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Nuestro Catálogo</h2>

        <form action="{{ route('catalogo.index') }}" method="GET" class="flex gap-2">
            <input
                type="text"
                name="search"
                placeholder="Buscar medicamento..."
                value="{{ request('search') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Buscar
            </button>
            @if(request('search'))
                <a href="{{ route('catalogo.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse ($medicamentos as $medicamento)
            <!-- TARJETA CON SOMBRA NARANJA INTENSA -->
            <div class="bg-white rounded-xl p-6 flex flex-col
                        border-2 border-blue-600
                        shadow-[0_5px_15px_rgba(255,140,0,0.5)]
                        hover:shadow-[0_12px_30px_rgba(255,100,0,0.8)]
                        hover:-translate-y-2 hover:scale-105
                        transition-all duration-300 ease-in-out">

                <div class="h-48 w-full bg-gray-50 rounded-md mb-4 flex items-center justify-center overflow-hidden border border-gray-100">
                    @if($medicamento->imagen)
                        <img src="{{ asset('storage/' . $medicamento->imagen) }}" alt="{{ $medicamento->nombre }}" class="h-full w-full object-cover">
                    @else
                        <span class="text-4xl">💊</span>
                    @endif
                </div>

                <a href="{{ route('catalogo.show', $medicamento->id) }}" class="hover:text-blue-600 transition-colors block">
                    <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $medicamento->nombre }}</h3>
                </a>

                <p class="text-gray-500 text-sm mb-4">Proveedor: {{ $medicamento->proveedor->nombre ?? 'No especificado' }}</p>

                <div class="mt-auto flex justify-between items-end">
                    <div>
                        <p class="text-2xl font-bold text-green-600">${{ number_format($medicamento->precio, 2) }}</p>
                        <p class="text-sm font-medium {{ $medicamento->stock > 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $medicamento->stock > 0 ? 'Stock: ' . $medicamento->stock : 'Agotado' }}
                        </p>
                    </div>

                    <form action="{{ route('cart.add', $medicamento->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-100 text-blue-600 p-3 rounded-full hover:bg-blue-600 hover:text-white transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No se encontraron medicamentos que coincidan con tu búsqueda.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $medicamentos->links() }}
    </div>
@endsection
