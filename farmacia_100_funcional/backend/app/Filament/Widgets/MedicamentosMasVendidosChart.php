<?php

namespace App\Filament\Widgets;

use App\Models\VentaDetalle;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MedicamentosMasVendidosChart extends ChartWidget
{
    protected static ?string $heading = 'Medicamentos Más Vendidos';

    protected static ?int $sort = 2; // Orden en el dashboard, para que aparezca después del de ventas

    protected function getData(): array
    {
        // Consultamos la base de datos para obtener los 5 medicamentos más vendidos
        $detalles = VentaDetalle::query()
            ->select('medicamento_id', DB::raw('SUM(cantidad) as total_vendido'))
            ->groupBy('medicamento_id')
            ->orderBy('total_vendido', 'desc')
            ->limit(5)
            ->with('medicamento') // Precargamos la información del medicamento para no hacer más consultas
            ->get();

        // Preparamos los datos para el gráfico
        $data = $detalles->pluck('total_vendido');
        $labels = $detalles->pluck('medicamento.nombre');

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad Vendida',
                    'data' => $data,
                    // Se pueden añadir colores personalizados si se desea
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
