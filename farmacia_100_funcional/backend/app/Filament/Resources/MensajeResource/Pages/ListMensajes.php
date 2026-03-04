<?php

namespace App\Filament\Resources\MensajeResource\Pages;

use App\Filament\Resources\MensajeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMensajes extends ListRecords
{
    protected static string $resource = MensajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(), // Comentado porque desactivamos la creación
        ];
    }
}
