<?php

namespace App\Traits;

use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    /**
     * Se ejecuta automáticamente cuando el modelo que usa este Trait inicia.
     */
    public static function bootAuditable()
    {
        // Evento cuando se crea un registro
        static::created(function ($model) {
            self::registrarAccion($model, 'INSERTAR', null, $model->getAttributes());
        });

        // Evento cuando se actualiza un registro
        static::updated(function ($model) {

            $cambios = $model->getChanges(); // Solo campos modificados

            self::registrarAccion($model, 'MODIFICAR', $model->getOriginal(), $cambios);
        });

        // Evento cuando se elimina un registro
        static::deleted(function ($model) {
            self::registrarAccion($model, 'ELIMINAR', $model->getOriginal(), null);
        });
    }

    /**
     * Función que guarda el registro en la bitácora.
     */
    protected static function registrarAccion($model, $accion, $anteriores = null, $nuevos = null)
    {
        // Obtiene el usuario autenticado con Sanctum
        $user = Auth::user() ?? request()->user();

        $model->makeHidden([
            'password',
            'remember_token',
            'created_at',
            'updated_at'
        ]);

        Bitacora::create([
            'user_id' => $user?->id, // null-safe operator
            'accion' => $accion,
            'tabla' => $model->getTable(),
            'registro_id' => $model->getKey(),
            'datos_anteriores' => $anteriores ? json_encode($anteriores) : null,
            'datos_nuevos' => $nuevos ? json_encode($nuevos) : null,
        ]);
    }
}
