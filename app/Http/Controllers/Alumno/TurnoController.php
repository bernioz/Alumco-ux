<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Turno;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TurnoController extends Controller
{
    public function index()
    {
        // Buscamos los turnos de la colaboradora autenticada
        $turnos = Turno::where('user_id', Auth::id())->get()->map(function ($turno) {
            
            // Asignamos colores según el tipo para que sea visualmente muy claro
            $color = '#3b82f6'; // Azul por defecto (trabajo)
            if ($turno->tipo === 'libre') {
                $color = '#10b981'; // Verde (libre)
            } elseif ($turno->tipo === 'no_disponible') {
                $color = '#ef4444'; // Rojo (no disponible)
            }

            return [
                'id' => $turno->id,
                'title' => $turno->titulo,
                'start' => $turno->inicio, // FullCalendar lee formato YYYY-MM-DD HH:mm:ss
                'end' => $turno->fin,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'tipo' => $turno->tipo,
                    'notas' => $turno->notas
                ]
            ];
        });

        return Inertia::render('Alumno/Turnos/Index', [
            'eventos' => $turnos
        ]);
    }
}