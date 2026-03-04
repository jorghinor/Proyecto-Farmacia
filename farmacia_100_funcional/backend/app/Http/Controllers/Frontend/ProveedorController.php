<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores', compact('proveedores'));
    }
}
