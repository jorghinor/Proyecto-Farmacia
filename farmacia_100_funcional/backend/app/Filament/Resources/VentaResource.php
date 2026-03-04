<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VentaResource\Pages;
use App\Models\Venta;
use App\Models\Medicamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Number;

class VentaResource extends Resource
{
    protected static ?string $model = Venta::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),

                Repeater::make('detalles')
                    ->relationship()
                    ->schema([
                        Select::make('medicamento_id')
                            ->label('Medicamento')
                            ->options(Medicamento::query()->pluck('nombre', 'id'))
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                $medicamento = Medicamento::find($state);
                                if ($medicamento) {
                                    $set('precio_unitario', $medicamento->precio);
                                }
                            }),
                        TextInput::make('cantidad')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->live(),
                        TextInput::make('precio_unitario')
                            ->label('Precio Unitario')
                            ->numeric()
                            ->prefix('$')
                            ->readOnly(),
                    ])
                    ->columns(3)
                    ->addActionLabel('Añadir Medicamento')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateTotal($get, $set);
                    }),

                TextInput::make('total')
                    ->numeric()
                    ->prefix('$')
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Venta')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Venta $record) => route('factura.pdf', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Se ha eliminado la acción de borrar masivamente para proteger el historial
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
            'index' => Pages\ListVentas::route('/'),
            'create' => Pages\CreateVenta::route('/create'),
            'view' => Pages\ViewVenta::route('/{record}'),
            'edit' => Pages\EditVenta::route('/{record}/edit'),
        ];
    }

    public static function updateTotal(Get $get, Set $set): void
    {
        $total = 0;
        $detalles = $get('detalles');

        if (is_array($detalles)) {
            foreach ($detalles as $item) {
                $total += ($item['cantidad'] ?? 0) * ($item['precio_unitario'] ?? 0);
            }
        }

        $set('total', $total);
    }
}
