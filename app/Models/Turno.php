<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Turno extends Model
{
    public $fillable = [
        'nombre',
        'inicio',
        'inicio_periodo',
        'final_periodo',
        'final'
    ];

    public function bloques()
    {
        return $this->hasMany(BloquesTurno::class);
    }

    public function parseHora12To24($hora, $periodo)
    {
        return Carbon::createFromFormat('h:i A', "$hora $periodo")->format('H:i');
    }

    public function generarBloquesTurno($nombre, $inicio, $final, $inicioPeriodo, $finalPeriodo)
    {
        $bloques = [];
        $inicio24H = $this->parseHora12To24($inicio, $inicioPeriodo);
        $final24H = $this->parseHora12To24($final, $finalPeriodo);

        $inicio = Carbon::createFromFormat('H:i', $inicio24H);
        $final = Carbon::createFromFormat('H:i', $final24H);
        $contadorBloques = 0;

        while ($inicio < $final) {
            $finBloque = $inicio->copy()->addMinutes(45);

            if ($finBloque > $final) {
                $finBloque = $final;
            }

            $periodoBloque = $inicio->format('H') < 12 ? 'AM' : 'PM';

            $bloques[] = [
                'rango' => $inicio->format('h:i A') . ' - ' . $finBloque->format('h:i A'),
                'periodo' => $periodoBloque,
                'tipo_turno' => $nombre,
            ];


            $contadorBloques++;

            if ($nombre === 'MAÑANA') {
                // Si el siguiente bloque termina antes del final, suma 5 minutos, si no, no suma
                $proximoInicio = $finBloque->copy();
                $proximoFin = $proximoInicio->copy()->addMinutes(45);

                if ($proximoFin <= $final) {
                    // No es el último bloque, suma descanso si corresponde
                    if ($contadorBloques % 2 === 0 && $finBloque != $final) {
                        $inicio = $finBloque->addMinutes(5);
                    } else {
                        $inicio = $finBloque->addMinutes(
                            ($contadorBloques > 1 && $contadorBloques % 2 !== 0) ? 5 : 0
                        );
                    }
                } else {
                    // Es el último bloque, no suma descanso
                    $inicio = $finBloque;
                }
            } else {
                $inicio = $finBloque;
            }
        }

        // Ajuste final para último bloque
        if ($nombre === 'MAÑANA' && !empty($bloques)) {
            $lastBlock = end($bloques);
            $lastBlockParts = explode(' - ', $lastBlock['rango']);
            $lastBlockEnd = $lastBlockParts[1];

            $horaFinalFormatted = Carbon::createFromFormat('H:i', $final24H)->format('h:i A');

            if ($lastBlockEnd !== $horaFinalFormatted) {
                $bloques[count($bloques) - 1]['rango'] = $lastBlockParts[0] . ' - ' . $horaFinalFormatted;
            }
        }

        return $bloques;
    }
}
