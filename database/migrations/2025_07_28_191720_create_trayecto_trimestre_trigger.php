<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTrayectoTrimestreTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION crear_trimestres_para_trayecto()
            RETURNS TRIGGER AS $$
            DECLARE
                trayecto_num INTEGER;
                romanos TEXT[] := ARRAY[\'I\', \'II\', \'III\', \'IV\', \'V\', \'VI\', \'VII\', \'VIII\', \'IX\', \'X\', 
                                       \'XI\', \'XII\', \'XIII\', \'XIV\', \'XV\', \'XVI\', \'XVII\', \'XVIII\', \'XIX\', \'XX\',
                                       \'XXI\', \'XXII\', \'XXIII\', \'XXIV\', \'XXV\', \'XXVI\', \'XXVII\', \'XXVIII\', \'XXIX\', \'XXX\'];
                inicio_trimestre INTEGER;
                i INTEGER;
                trimestre_base INTEGER;
            BEGIN
                -- Extraer el número del trayecto del nombre
                BEGIN
                    trayecto_num := CAST(NEW.nombre AS INTEGER);
                EXCEPTION WHEN OTHERS THEN
                    trayecto_num := 1;
                END;
                
                trimestre_base := (trayecto_num - 1) * 3;
                
                IF array_length(romanos, 1) < trimestre_base + 3 THEN
                    RAISE EXCEPTION \'No hay suficientes números romanos definidos para el trayecto %\', trayecto_num;
                END IF;
                
                FOR i IN 1..3 LOOP
                    INSERT INTO public.trimestres (
                        nombre, 
                        trayecto_id, 
                        created_at, 
                        updated_at
                    ) VALUES (
                        romanos[trimestre_base + i],
                        NEW.id,
                        NOW(),
                        NOW()
                    );
                END LOOP;
                
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER after_trayecto_insert
            AFTER INSERT ON trayectos
            FOR EACH ROW
            EXECUTE FUNCTION crear_trimestres_para_trayecto();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_trayecto_insert ON trayectos;');
        DB::unprepared('DROP FUNCTION IF EXISTS crear_trimestres_para_trayecto();');
    }
}
