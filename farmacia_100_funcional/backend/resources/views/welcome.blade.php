@extends('layouts.app')

@section('title', 'Bienvenido - Farmacia La Salud')

@section('content')
    <div class="text-center py-12">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
            Bienvenido a Farmacia <span class="text-blue-600">"La Salud"</span>
        </h1>
        <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
            Comprometidos con tu bienestar y el de tu familia. Encuentra los mejores medicamentos,
            atención personalizada y la confianza que necesitas.
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('catalogo.index') }}"
               class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-transform transform hover:scale-105 shadow-lg">
                Ver Catálogo
            </a>
            <a href="{{ route('contacto.index') }}"
               class="bg-white text-blue-600 border border-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors shadow-sm">
                Contactar
            </a>
        </div>
    </div>

    <!-- Sección de Características -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
        <div class="bg-white p-6 rounded-xl shadow-md text-center">
            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 text-2xl">
                💊
            </div>
            <h3 class="font-bold text-xl mb-2">Variedad de Productos</h3>
            <p class="text-gray-500">Contamos con un amplio stock de medicamentos de los mejores laboratorios.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md text-center">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600 text-2xl">
                💲
            </div>
            <h3 class="font-bold text-xl mb-2">Mejores Precios</h3>
            <p class="text-gray-500">Precios competitivos y descuentos especiales pensando en tu economía.</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-purple-600 text-2xl">
                ⏰
            </div>
            <h3 class="font-bold text-xl mb-2">Atención Rápida</h3>
            <p class="text-gray-500">Nuestro sistema optimizado nos permite atenderte sin largas esperas.</p>
        </div>
    </div>
@endsection
