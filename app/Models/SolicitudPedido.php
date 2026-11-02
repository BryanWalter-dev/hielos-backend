<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudPedido extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_pedido';

    // Estados admitidos en el prototipo (ejemplo académico, por validar con la empresa)
    public const ESTADOS = ['pendiente', 'en_revision', 'completada', 'cancelada'];

    // Campos que se pueden asignar de una vez al crear o actualizar
    protected $fillable = ['cliente', 'cantidad', 'fecha_requerida', 'estado'];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'fecha_requerida' => 'date:Y-m-d',
        ];
    }
}