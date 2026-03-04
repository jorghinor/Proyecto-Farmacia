@extends('layouts.app')

@section('title', 'Nuestros Proveedores')

@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Nuestros Proveedores</h2>
    <p class="text-gray-600 mb-8">Trabajamos con los laboratorios y distribuidores más confiables para garantizar la calidad y eficacia de nuestros productos.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @forelse ($proveedores as $proveedor)
            <!-- TARJETA CON ESTILO UNIFICADO (BORDE AZUL + SOMBRA NARANJA) -->
            <div onclick="openModal('{{ $proveedor->nombre }}', '{{ $proveedor->email }}', '{{ $proveedor->telefono }}', '{{ $proveedor->foto ? asset('storage/' . $proveedor->foto) : '' }}')"
                 class="bg-white rounded-xl p-6 text-center flex flex-col items-center
                        border-2 border-blue-600
                        shadow-[0_5px_15px_rgba(255,140,0,0.5)]
                        hover:shadow-[0_12px_30px_rgba(255,100,0,0.8)]
                        hover:-translate-y-2 hover:scale-105
                        transition-all duration-300 ease-in-out cursor-pointer">

                <!-- FOTO DEL PROVEEDOR -->
                <div class="h-24 w-24 bg-gray-100 rounded-full mb-4 flex items-center justify-center overflow-hidden border-2 border-blue-100">
                    @if($proveedor->foto)
                        <img src="{{ asset('storage/' . $proveedor->foto) }}" alt="{{ $proveedor->nombre }}" class="h-full w-full object-cover">
                    @else
                        <span class="text-4xl">🚚</span>
                    @endif
                </div>

                <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $proveedor->nombre }}</h3>

                @if($proveedor->email)
                    <p class="text-gray-500 text-sm mb-1">
                        <span class="font-semibold">Email:</span> {{ $proveedor->email }}
                    </p>
                @endif

                @if($proveedor->telefono)
                    <p class="text-gray-500 text-sm">
                        <span class="font-semibold">Tel:</span> {{ $proveedor->telefono }}
                    </p>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No hay información de proveedores disponible en este momento.</p>
            </div>
        @endforelse
    </div>

    <!-- MODAL -->
    <div id="providerModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Fondo oscuro -->
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>

            <!-- Contenido del Modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full
                        border-2 border-blue-600
                        shadow-[0_5px_15px_rgba(255,140,0,0.5)]">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 flex flex-col items-center">
                    <!-- FOTO EN EL MODAL -->
                    <div class="h-32 w-32 bg-gray-100 rounded-full mb-4 flex items-center justify-center overflow-hidden border-2 border-blue-100">
                        <img id="modalImage" src="" alt="Proveedor" class="h-full w-full object-cover hidden">
                        <span id="modalIcon" class="text-5xl hidden">🚚</span>
                    </div>

                    <h3 class="text-2xl leading-6 font-bold text-gray-900 mb-2" id="modalTitle">Nombre del Proveedor</h3>

                    <div class="mt-2 text-center">
                        <p class="text-gray-500 mb-1" id="modalEmailContainer">
                            <span class="font-semibold">Email:</span> <span id="modalEmail"></span>
                        </p>
                        <p class="text-gray-500" id="modalPhoneContainer">
                            <span class="font-semibold">Tel:</span> <span id="modalPhone"></span>
                        </p>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(nombre, email, telefono, imagenUrl) {
            document.getElementById('modalTitle').innerText = nombre;

            // Email
            if (email) {
                document.getElementById('modalEmail').innerText = email;
                document.getElementById('modalEmailContainer').classList.remove('hidden');
            } else {
                document.getElementById('modalEmailContainer').classList.add('hidden');
            }

            // Telefono
            if (telefono) {
                document.getElementById('modalPhone').innerText = telefono;
                document.getElementById('modalPhoneContainer').classList.remove('hidden');
            } else {
                document.getElementById('modalPhoneContainer').classList.add('hidden');
            }

            // Imagen
            const imgElement = document.getElementById('modalImage');
            const iconElement = document.getElementById('modalIcon');

            if (imagenUrl) {
                imgElement.src = imagenUrl;
                imgElement.classList.remove('hidden');
                iconElement.classList.add('hidden');
            } else {
                imgElement.classList.add('hidden');
                iconElement.classList.remove('hidden');
            }

            document.getElementById('providerModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('providerModal').classList.add('hidden');
        }
    </script>
@endsection
