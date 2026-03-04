<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    use HasFactory;

    // Especificamos el nombre de la tabla porque Laravel buscaría 'proveedors'
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'foto', // <-- AÑADIDO
    ];

    public function medicamentos(): HasMany
    {
        return $this->hasMany(Medicamento::class);
    }
}
