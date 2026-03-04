<?php

namespace App\Filament\Widgets;

use App\Models\Venta;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class VentasChart extends ChartWidget
{
    protected static ?string $heading = 'Ventas de la Última Semana';

    protected static ?int $sort = 1; // Orden en el dashboard

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        // Iteramos sobre los últimos 7 días
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('D, M j'); // Formato: "Mon, Dec 23"

            // Sumamos el total de ventas para ese día específico
            $data[] = Venta::whereDate('created_at', $date)->sum('total');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ventas',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
