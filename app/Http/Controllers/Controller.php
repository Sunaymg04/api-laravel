<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function documentFacultyId(): ?int
    {
        $value = request()->header('X-Facultad')
            ?? request('facultad_id')
            ?? request('id_facultad');

        return is_numeric($value) ? (int) $value : null;
    }

    protected function logDocumentGenerated(string $documento, $periodo = null): void
    {
        $usuario = request()->header('X-User', 'desconocido');
        $detallePeriodo = $periodo ? " {$periodo}" : '';

        LogController::registrar(
            $usuario,
            'generar_documento',
            "{$usuario} generó {$documento}{$detallePeriodo}",
            $this->documentFacultyId()
        );
    }
}
