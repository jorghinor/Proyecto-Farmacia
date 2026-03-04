<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicamento::with('proveedor');

        // Si hay una búsqueda en la URL (?search=aspirina)
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'ILIKE', "%{$search}%"); // ILIKE es para búsqueda insensible a mayúsculas en Postgres
        }

        // Obtenemos los medicamentos paginados
        $medicamentos = $query->paginate(12);

        return view('catalogo', compact('medicamentos'));
    }

    public function show($id)
    {
        $medicamento = Medicamento::with('proveedor')->findOrFail($id);
        return view('detalle', compact('medicamento'));
    }
}
