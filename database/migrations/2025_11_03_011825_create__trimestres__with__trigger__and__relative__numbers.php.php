<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTrimestresWithTriggerAndRelativeNumbers extends Migration
{
    public function up()
    {
        // 1. Crear tabla trimestres si no existe (con numero_relativo incluido)
        if (!Schema::hasTable('trimestres')) {
            Schema::create('trimestres', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->integer('numero_relativo');
                $table->foreignId('trayecto_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                $table->unique(['trayecto_id', 'numero_relativo']);
            });
        }

        // 2. Crear la función del trigger
        DB::statement('DROP FUNCTION IF EXISTS public.crear_trimestres_para_trayecto() CASCADE;');

        DB::statement('
            CREATE OR REPLACE FUNCTION public.crear_trimestres_para_trayecto()
                RETURNS trigger
                LANGUAGE plpgsql
            AS $function$
            DECLARE
                trayecto_num INTEGER;
                romanos TEXT[] := ARRAY[\'I\', \'II\', \'III\', \'IV\', \'V\', \'VI\', \'VII\', \'VIII\', \'IX\', \'X\', 
                                       \'XI\', \'XII\', \'XIII\', \'XIV\', \'XV\', \'XVI\', \'XVII\', \'XVIII\', \'XIX\', \'XX\',
                                       \'XXI\', \'XXII\', \'XXIII\', \'XXIV\', \'XXV\', \'XXVI\', \'XXVII\', \'XXVIII\', \'XXIX\', \'XXX\'];
                i INTEGER;
                trimestre_base INTEGER;
            BEGIN
                -- Para UPDATE, eliminar trimestres existentes antes de crear nuevos
                IF TG_OP = \'UPDATE\' THEN
                    DELETE FROM public.trimestres WHERE trayecto_id = NEW.id;
                END IF;
                
                -- Extraer el número del trayecto del nombre
                BEGIN
                    trayecto_num := CAST(REGEXP_REPLACE(NEW.nombre, \'[^0-9]\', \'\', \'g\') AS INTEGER);
                EXCEPTION WHEN OTHERS THEN
                    trayecto_num := 1;
                END;
                
                trimestre_base := (trayecto_num - 1) * 3;
                
                IF array_length(romanos, 1) < trimestre_base + 3 THEN
                    RAISE EXCEPTION \'No hay suficientes números romanos definidos para el trayecto %\', trayecto_num;
                END IF;
                
                -- Crear los 3 trimestres para el trayecto
                FOR i IN 1..3 LOOP
                    INSERT INTO public.trimestres (
                        nombre, 
                        numero_relativo,
                        trayecto_id, 
                        created_at, 
                        updated_at
                    ) VALUES (
                        romanos[trimestre_base + i],
                        i,
                        NEW.id,
                        NOW(),
                        NOW()
                    );
                END LOOP;
                
                RETURN NEW;
            END;
            $function$;
        ');

        // 3. Crear el trigger
        DB::statement('DROP TRIGGER IF EXISTS trigger_crear_trimestres ON trayectos;');
        DB::statement('
            CREATE TRIGGER trigger_crear_trimestres
                AFTER INSERT OR UPDATE ON trayectos
                FOR EACH ROW
                EXECUTE FUNCTION crear_trimestres_para_trayecto();
        ');

        // 4. Si ya existen trayectos, crear sus trimestres
        $this->crearTrimestresParaTrayectosExistentes();
    }

    private function crearTrimestresParaTrayectosExistentes()
    {
        $trayectos = DB::table('trayectos')->get();
        
        foreach ($trayectos as $trayecto) {
            // Verificar si el trayecto ya tiene trimestres
            $trimestresCount = DB::table('trimestres')
                ->where('trayecto_id', $trayecto->id)
                ->count();
                
            if ($trimestresCount === 0) {
                // Extraer número del trayecto
                preg_match('/\d+/', $trayecto->nombre, $matches);
                $trayectoNum = $matches[0] ?? 1;
                
                $trimestreBase = ($trayectoNum - 1) * 3;
                $romanos = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                
                for ($i = 1; $i <= 3; $i++) {
                    if (isset($romanos[$trimestreBase + $i - 1])) {
                        DB::table('trimestres')->insert([
                            'nombre' => $romanos[$trimestreBase + $i - 1],
                            'numero_relativo' => $i,
                            'trayecto_id' => $trayecto->id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
    }

    public function down()
    {
        // Eliminar trigger y función
        DB::statement('DROP TRIGGER IF EXISTS trigger_crear_trimestres ON trayectos;');
        DB::statement('DROP FUNCTION IF EXISTS crear_trimestres_para_trayecto() CASCADE;');
        
        // Eliminar tabla trimestres
        Schema::dropIfExists('trimestres');
    }
}