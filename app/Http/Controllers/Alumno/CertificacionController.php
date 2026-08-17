<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Certificacion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CertificacionController extends Controller
{
    public function index()
    {
        // Buscamos las certificaciones de la usuaria actual
        $certificaciones = Certificacion::with('curso')
            ->where('user_id', Auth::id())
            ->orderBy('fecha_vencimiento', 'asc')
            ->get()
            ->map(function ($cert) {
                return [
                    'id' => $cert->id,
                    'curso' => $cert->curso->titulo ?? 'Curso sin título',
                    'fecha_emision' => $cert->fecha_emision ? Carbon::parse($cert->fecha_emision)->format('d/m/Y') : '-',
                    'fecha_vencimiento' => $cert->fecha_vencimiento ? Carbon::parse($cert->fecha_vencimiento)->format('d/m/Y') : 'Sin vencimiento',
                    // Llamamos a la propiedad 'estado' que creamos en el modelo
                    'estado' => $cert->estado, 
                ];
            });

        return Inertia::render('Alumno/Certificaciones/Index', [
            'certificaciones' => $certificaciones
        ]);
    }
}