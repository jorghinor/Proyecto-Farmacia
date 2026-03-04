<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Farmacia La Salud')</title>

    <!-- Scripts de Vite para CSS y JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Estilos adicionales si fueran necesarios */
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased flex flex-col min-h-screen">

    <!-- HEADER -->
    <header class="bg-gray-900 text-white shadow-lg relative">
        <!-- Usuario Autenticado (Esquina Superior Derecha) -->
        @auth
            <div class="absolute top-4 right-4 flex items-center gap-2 text-sm">
                <span class="text-gray-300">Hola,</span>
                <span class="font-bold text-white">{{ Auth::user()->name }}</span>
                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        @endauth

        <div class="container mx-auto px-4 py-6 flex flex-col items-center justify-center">

            <!-- LOGO (VIDEO MP4) -->
            <div class="w-full max-w-xs mb-4 flex justify-center">
                <video
                    src="{{ asset('lasalud.mp4') }}"
                    autoplay
                    loop
                    muted
                    playsinline
                    class="object-contain"
                    style="max-height: 150px; width: auto;">
                </video>
            </div>

            <h1 class="text-3xl font-bold tracking-wider uppercase">Farmacia "La Salud"</h1>
            <p class="text-gray-400 text-sm mt-1">Tu bienestar es nuestra prioridad</p>
        </div>
    </header>

    <div class="flex flex-1 container mx-auto px-4 py-8 gap-8">

        <!-- SIDEBAR (Menú Izquierdo) -->
        <aside class="w-64 hidden md:block">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Módulos</h3>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('catalogo.index') }}"
                               class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors font-medium {{ request()->routeIs('catalogo.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                💊 Catálogo
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}"
                               class="flex justify-between items-center px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors font-medium {{ request()->routeIs('cart.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                <span>🛒 Mi Carrito</span>
                                @if($cartCount > 0)
                                    <span class="bg-blue-600 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('proveedores.index') }}"
                               class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors font-medium {{ request()->routeIs('proveedores.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                🚚 Nuestros Proveedores
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contacto.index') }}"
                               class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors font-medium {{ request()->routeIs('contacto.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                📞 Contacto
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Sección de Usuario -->
                <div class="mt-8 pt-4 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Cuenta</h3>
                    <nav>
                        <ul class="space-y-2">
                            @auth
                                <!-- Si el usuario está logueado -->
                                <li>
                                    <a href="/admin" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors font-medium">
                                        ⚙️ Panel Admin
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 rounded-md text-red-600 hover:bg-red-50 transition-colors font-medium">
                                            🚪 Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            @else
                                <!-- Si NO está logueado -->
                                <li>
                                    <!-- ENLACE MODIFICADO AQUÍ -->
                                    <a href="{{ route('login') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors font-medium">
                                        🔑 Iniciar Sesión
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    <!-- FOOTER -->
    <footer class="bg-gray-800 text-gray-300 py-8 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p class="mb-2">&copy; {{ date('Y') }} Farmacia "La Salud". Todos los derechos reservados.</p>
            <p class="text-sm text-gray-500">Desarrollado con Laravel, Filament y Tailwind CSS.</p>
        </div>
    </footer>

</body>
</html>
