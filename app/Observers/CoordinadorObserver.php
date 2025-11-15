<?php

namespace App\Observers;

use App\Models\Coordinador;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class CoordinadorObserver
{
    /**
     * Cuando se crea un coordinador → crear usuario.
     */
    public function created(Coordinador $coordinador): void
    {
        $docente = $coordinador->docente;
        $persona = $docente->persona;

        // Evitar duplicados
        if (User::where('persona_id', $persona->id)->exists()) {
            return;
        }

        $user = User::create([
            'name'     => $persona->nombre . ' ' . $persona->apellido,
            'email'    => $persona->email,
            'password' => Hash::make($persona->cedula_persona),
            'persona_id' => $persona->id,
        ]);

        $user->assignRole('COORDINADOR');
    }

    /**
     * ESTE ES EL IMPORTANTE — siempre corre aunque uses transacciones.
     */
    public function deleting(Coordinador $coordinador): void
    {
                $docente = $coordinador->docente;
        if (! $docente) return;

        $persona = $docente->persona;
        if (! $persona) return;

        $usuario = User::where('persona_id', $persona->id)->first();
        if ($usuario) {
            $usuario->delete(); // o forceDelete() si lo deseas físico
        }
    }
}
