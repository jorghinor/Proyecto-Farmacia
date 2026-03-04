<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use App\Models\Mensaje;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Muestra el formulario
    public function index()
    {
        return view('contacto');
    }

    // Procesa el envío del mensaje
    public function store(Request $request)
    {
        // 1. Validar los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // 2. Guardar en la base de datos
        Mensaje::create($validated);

        // 3. Redirigir con mensaje de éxito
        return redirect()->route('contacto.index')->with('success', '¡Gracias por contactarnos! Hemos recibido tu mensaje.');
    }
}
