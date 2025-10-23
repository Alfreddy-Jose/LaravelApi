<?php

namespace App\Imports;

use App\Models\Espacio;
use App\Models\Sede;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class LaboratoriosImport implements ToModel, WithHeadingRow, WithValidation
{
    private $errors = [];
    private $importedCount = 0;
    private $sedesCache = [];
    private $nombresUsados = [];
    private $currentRow = 0;

    public function model(array $row)
    {
        $this->currentRow++;
        
        Log::info("Procesando fila {$this->currentRow}:", $row);

        // Validar que la fila tenga datos
        if (empty(array_filter($row))) {
            return null;
        }

        try {
            // Buscar el ID de la sede por nombre
            $sedeNombre = $row['sede'] ?? $row['sede_nombre'] ?? $row['nombre_sede'] ?? null;

            if (!$sedeNombre) {
                $errorMsg = "Fila {$this->currentRow}: El nombre de la sede es requerido";
                $this->errors[] = $errorMsg;
                return null;
            }

            $sedeId = $this->getSedeId($sedeNombre);

            if (!$sedeId) {
                $errorMsg = "Fila {$this->currentRow}: Sede '{$sedeNombre}' no encontrada";
                $this->errors[] = $errorMsg;
                return null;
            }

            // Obtener etapa
            $etapa = $row['etapa'] ?? $row['letra'] ?? null;
            if (!$etapa) {
                $errorMsg = "Fila {$this->currentRow}: La etapa es requerida";
                $this->errors[] = $errorMsg;
                return null;
            }

            // Obtener nombre del laboratorio - CORREGIDO
            $nombreLaboratorio = $row['laboratorio'] ?? $row['nombre'] ?? $row['nombre_aula'] ?? $row['laboratorio_nombre'] ?? null;
            
            if (!$nombreLaboratorio) {
                $errorMsg = "Fila {$this->currentRow}: El nombre del laboratorio es requerido";
                $this->errors[] = $errorMsg;
                return null;
            }

            $nombreLaboratorio = strtoupper(trim($nombreLaboratorio));

            // Validar que el nombre no se repita en esta importación
            if (in_array($nombreLaboratorio, $this->nombresUsados)) {
                $errorMsg = "Fila {$this->currentRow}: El nombre '{$nombreLaboratorio}' ya está repetido en este archivo";
                $this->errors[] = $errorMsg;
                return null;
            }

            // Validar que el nombre no exista en la base de datos
            if ($this->nombreAulaExiste($nombreLaboratorio)) {
                $errorMsg = "Fila {$this->currentRow}: El aula '{$nombreLaboratorio}' ya existe en el sistema";
                $this->errors[] = $errorMsg;
                return null;
            }

            // Agregar a la lista de nombres usados
            $this->nombresUsados[] = $nombreLaboratorio;

            // Preparar datos para el modelo
            $datosEspacio = [
                'etapa' => strtoupper(trim($etapa)),
                'nombre_aula' => $nombreLaboratorio,
                'sede_id' => $sedeId,
                'tipo_espacio' => 'LABORATORIO',
            ];

            // Agregar campos opcionales solo si existen
            if (isset($row['equipos']) && !empty($row['equipos'])) {
                $datosEspacio['equipos'] = $row['equipos'];
            }

            if (isset($row['abreviado']) && !empty($row['abreviado'])) {
                $datosEspacio['abreviado_lab'] = strtoupper(trim($row['abreviado']));
            }

            $this->importedCount++;

            return new Espacio($datosEspacio);

        } catch (\Exception $e) {
            $errorMsg = "Fila {$this->currentRow}: Error - " . $e->getMessage();
            $this->errors[] = $errorMsg;
            
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
            ->where('tipo_espacio', 'LABORATORIO')
            ->exists();
    }

    /**
     * ✅ CORREGIDO: Reglas de validación más flexibles
     */
    public function rules(): array
    {
        return [
            '*.sede' => 'sometimes|string|max:255',
            '*.sede_nombre' => 'sometimes|string|max:255',
            '*.nombre_sede' => 'sometimes|string|max:255',
            '*.etapa' => 'sometimes|string|max:1',
            '*.letra' => 'sometimes|string|max:1',
            '*.laboratorio' => 'sometimes|string|max:255',
            '*.nombre' => 'sometimes|string|max:255',
            '*.nombre_aula' => 'sometimes|string|max:255',
            '*.laboratorio_nombre' => 'sometimes|string|max:255',
            '*.abreviado' => 'nullable|string|max:255',
            '*.equipos' => 'nullable|numeric|max:255',
        ];
    }

    /**
     * ✅ Añadir mensajes personalizados para las validaciones
     */
    public function customValidationMessages()
    {
        return [
            '*.laboratorio.sometimes' => 'El campo laboratorio es requerido cuando está presente',
            '*.sede.sometimes' => 'El campo sede es requerido cuando está presente',
            '*.equipos.numeric' => 'El campo equipos debe ser un número',
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

    /**
     * ✅ Obtener el número real de fila (contando desde los headers)
     */
    public function getRowNumber()
    {
        return $this->currentRow + 1; // +1 porque WithHeadingRow ignora la primera fila
    }
}