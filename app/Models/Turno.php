<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'turnos';

    protected $fillable = [
        'user_id',
        'titulo',
        'inicio',
        'fin',
        'tipo',
        'notas'
    ];

    // Relación: Un turno pertenece a un usuario (colaboradora)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}