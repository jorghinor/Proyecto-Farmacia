<?php

namespace App\Filament\Resources\MensajeResource\Pages;

use App\Filament\Resources\MensajeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMensaje extends EditRecord
{
    protected static string $resource = MensajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
