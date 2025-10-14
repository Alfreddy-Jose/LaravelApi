<?php

namespace App\Imports;

use App\Models\Espacio;
use App\Models\Sede;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AulasImport implements ToModel, WithHeadingRow, WithValidation
{
    private $errors = [];
    private $importedCount = 0;
    private $sedesCache = [];
    private $nombresUsados = []; // Cache para nombres ya usados en esta importación

    public function model(array $row)
    {
        // Validar que la fila tenga datos
        if (empty(array_filter($row))) {
            return null;
        }

        try {
            // Buscar el ID de la sede por nombre
            $sedeNombre = $row['sede'] ?? $row['sede_nombre'] ?? $row['nombre_sede'] ?? null;

            if (!$sedeNombre) {
                $this->errors[] = "Fila " . ($this->importedCount + 1) . ": El nombre de la sede es requerido";
                return null;
            }

            $sedeId = $this->getSedeId($sedeNombre);

            if (!$sedeId) {
                $this->errors[] = "Fila " . ($this->importedCount + 1) . ": Sede '" . $sedeNombre . "' no encontrada";
                return null;
            }

            // Obtener etapa
            $etapa = $row['etapa'] ?? $row['letra'] ?? null;
            if (!$etapa) {
                $this->errors[] = "Fila " . ($this->importedCount + 1) . ": La etapa es requerida";
                return null;
            }

            // Obtener número de aula
            $numeroAula = $row['numero_aula'] ?? $row['numero'] ?? $row['nro_aula'] ?? $row['nro'] ?? null;
            if (!$numeroAula) {
                $this->errors[] = "Fila " . ($this->importedCount + 1) . ": El número de aula es requerido";
                return null;
            }

            // Generar nombre_aula automáticamente
            $nombreAula = $row['nombre_aula'] ?? $row['aula'] ?? $row['nombre'] ?? $etapa . '-' . $numeroAula;

            // Validar que el nombre no se repita en esta importación
            if (in_array($nombreAula, $this->nombresUsados)) {
                $this->errors[] = "Fila " . ($this->importedCount + 1) . ": El nombre '" . $nombreAula . "' ya está repetido en este archivo";
                return null;
            }

            // Validar que el nombre no exista en la base de datos
            if ($this->nombreAulaExiste($nombreAula)) {
                $this->errors[] = "Fila " . ($this->importedCount + 1) . ": El aula '" . $nombreAula . "' ya existe en el sistema";
                return null;
            }

            // Agregar a la lista de nombres usados
            $this->nombresUsados[] = $nombreAula;

            $this->importedCount++;

            return new Espacio([
                'etapa' => strtoupper($etapa),
                'nro_aula' => strtoupper($numeroAula),
                'nombre_aula' => strtoupper($nombreAula),
                'sede_id' => $sedeId,
                'tipo_espacio' => 'AULA',
            ]);
        } catch (\Exception $e) {
            $this->errors[] = "Fila " . ($this->importedCount + 1) . ": Error en los datos - " . $this->getUserFriendlyMessage($e);
            return null;
        }
    }

    private function getSedeId($sedeNombre)
    {
        if (empty($sedeNombre)) {
            return null;
        }

        $sedeNombre = trim($sedeNombre);

        if (isset($this->sedesCache[$sedeNombre])) {
            return $this->sedesCache[$sedeNombre];
        }

        $sede = Sede::where('nombre_sede', 'ilike', $sedeNombre)->first();

        if (!$sede) {
            $sede = Sede::where('nombre_sede', 'ilike', '%' . $sedeNombre . '%')->first();
        }

        if ($sede) {
            $this->sedesCache[$sedeNombre] = $sede->id;
            return $sede->id;
        }

        return null;
    }

    private function nombreAulaExiste($nombreAula)
    {
        return Espacio::where('nombre_aula', $nombreAula)
            ->where('tipo_espacio', 'AULA')
            ->exists();
    }

    private function getUserFriendlyMessage($exception)
    {
        $message = $exception->getMessage();

        // Ocultar detalles técnicos de base de datos
        if (strpos($message, 'SQLSTATE') !== false) {
            if (strpos($message, 'null violation') !== false || strpos($message, 'not null') !== false) {
                return 'Faltan datos requeridos';
            }
            if (strpos($message, 'unique violation') !== false || strpos($message, 'duplicate key') !== false) {
                return 'El aula ya existe en el sistema';
            }
            return 'Error en el formato de datos';
        }

        return 'Datos incorrectos';
    }

    public function rules(): array
    {
        return [
            '*.etapa' => 'sometimes|string|max:1',
            '*.numero_aula' => 'sometimes|numeric',
            '*.numero' => 'sometimes|numeric',
            '*.nro_aula' => 'sometimes|numeric',
            '*.nro' => 'sometimes|numeric',
            '*.sede' => 'sometimes|string|max:255',
            '*.aula' => 'sometimes|string|max:255',
            '*.nombre_aula' => 'sometimes|string|max:255|unique:espacios,nombre_aula',
        ];
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }
}
