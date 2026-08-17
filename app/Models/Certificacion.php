<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Certificacion extends Model
{
    protected $table = 'certificaciones';
    
    protected $fillable = [
        'user_id', 
        'curso_id', 
        'fecha_emision', 
        'fecha_vencimiento'
    ];

    // Relación con el curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Lógica para calcular el estado dinámicamente
    public function getEstadoAttribute()
    {
        if (!$this->fecha_vencimiento) {
            return 'vigente';
        }

        $hoy = now();
        $vencimiento = Carbon::parse($this->fecha_vencimiento);
        $diasRestantes = $hoy->diffInDays($vencimiento, false);

        if ($diasRestantes < 0) {
            return 'vencida';
        } elseif ($diasRestantes <= 30) {
            return 'proxima_a_vencer';
        }

        return 'vigente';
    }
}