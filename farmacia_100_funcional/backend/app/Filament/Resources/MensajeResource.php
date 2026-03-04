<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MensajeResource\Pages;
use App\Models\Mensaje;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MensajeResource extends Resource
{
    protected static ?string $model = Mensaje::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Mensajes de Contacto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->readOnly(),
                Forms\Components\TextInput::make('email')
                    ->label('Correo')
                    ->readOnly(),
                Forms\Components\Textarea::make('message')
                    ->label('Mensaje')
                    ->readOnly()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('leido')
                    ->label('Marcar como Leído'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                Tables\Columns\IconColumn::make('leido')
                    ->label('Leído')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recibido')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(), // Para poder cambiar el estado de "leído"
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMensajes::route('/'),
            'create' => Pages\CreateMensaje::route('/create'), // Aunque no lo usaremos mucho
            'edit' => Pages\EditMensaje::route('/{record}/edit'),
        ];
    }

    // Opcional: Desactivar el botón de crear si no quieres crear mensajes desde el admin
    public static function canCreate(): bool
    {
        return false;
    }
}
