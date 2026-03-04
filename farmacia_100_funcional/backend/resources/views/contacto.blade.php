@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    <!-- Estilos de Leaflet (Mapa) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <h2 class="text-2xl font-bold text-gray-800 mb-6">Contáctanos</h2>

    <!-- Mensaje de Éxito -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">¡Enviado!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Formulario de Contacto -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h3 class="text-xl font-bold mb-4">Envíanos un Mensaje</h3>

            <form action="{{ route('contacto.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Nombre</label>
                    <input type="text" id="name" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-gray-700 font-medium mb-2">Mensaje</label>
                    <textarea id="message" name="message" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Enviar Mensaje
                </button>
            </form>
        </div>

        <!-- Información de Contacto y Mapa -->
        <div class="bg-white rounded-lg shadow-md p-8 flex flex-col">
            <h3 class="text-xl font-bold mb-4">Nuestra Ubicación</h3>
            <p class="text-gray-600 mb-2"><strong>Dirección:</strong> Av. Siempre Viva 123, Springfield</p>
            <p class="text-gray-600 mb-2"><strong>Teléfono:</strong> (555) 123-4567</p>
            <p class="text-gray-600 mb-4"><strong>Horario:</strong> Lunes a Sábado de 8:00 a 20:00</p>

            <!-- Contenedor del Mapa Real -->
            <div id="map" class="w-full h-64 rounded-lg shadow-inner border border-gray-200 flex-grow min-h-[300px]"></div>
        </div>
    </div>

    <!-- Script de Leaflet (Mapa) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Coordenadas de ejemplo (Centro de una ciudad genérica, puedes cambiarlas)
            // Latitud, Longitud
            var lat = -16.500;
            var lng = -68.150;

            // Inicializar el mapa
            var map = L.map('map').setView([lat, lng], 15);

            // Cargar los "tiles" (el dibujo del mapa) de OpenStreetMap
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Añadir el marcador rojo
            var marker = L.marker([lat, lng]).addTo(map);

            // Añadir un popup al marcador
            marker.bindPopup("<b>Farmacia La Salud</b><br>¡Aquí estamos!").openPopup();
        });
    </script>
@endsection
