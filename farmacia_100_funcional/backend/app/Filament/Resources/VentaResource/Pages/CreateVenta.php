<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Medicamento;

class CreateVenta extends CreateRecord
{
    protected static string $resource = VentaResource::class;

    protected function afterCreate(): void
    {
        // Después de crear la venta, recorremos los detalles para actualizar el stock
        $venta = $this->getRecord();

        foreach ($venta->detalles as $detalle) {
            $medicamento = Medicamento::find($detalle->medicamento_id);
            if ($medicamento) {
                $medicamento->stock -= $detalle->cantidad;
                $medicamento->save();
            }
        }
    }
}
