<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller; // <-- LA LÍNEA QUE FALTABA

class FacturaController extends Controller
{
    public function generarPdf(Venta $venta)
    {
        // Cargar la vista 'factura' con los datos de la venta y sus relaciones
        $pdf = Pdf::loadView('factura', ['venta' => $venta->load('user', 'detalles.medicamento')]);

        // Devolver el PDF para que se vea en el navegador
        return $pdf->stream('factura-' . $venta->id . '.pdf');
    }
}
