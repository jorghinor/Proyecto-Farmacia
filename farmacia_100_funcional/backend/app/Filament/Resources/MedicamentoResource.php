<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicamentoResource\Pages;
use App\Models\Medicamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MedicamentoResource extends Resource
{
    protected static ?string $model = Medicamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('proveedor_id')
                    ->relationship('proveedor', 'nombre')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),

                // CAMPO DE IMAGEN MODIFICADO
                Forms\Components\FileUpload::make('imagen')
                    ->image()
                    ->disk('public') // <--- ESTA ES LA LÍNEA MÁGICA QUE FALTABA
                    ->directory('medicamentos')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('precio')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('fecha_vencimiento')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // COLUMNA DE IMAGEN MODIFICADA
                Tables\Columns\ImageColumn::make('imagen')
                    ->disk('public') // <--- TAMBIÉN AQUÍ PARA QUE SE VEA
                    ->circular(),

                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('proveedor.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('precio')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_vencimiento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMedicamentos::route('/'),
            'create' => Pages\CreateMedicamento::route('/create'),
            'edit' => Pages\EditMedicamento::route('/{record}/edit'),
        ];
    }
}
