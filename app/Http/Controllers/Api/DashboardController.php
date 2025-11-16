<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function kpis()
    {
        // Total docentes
        $docentes = DB::table('docentes')->count();

        // Total clases
        $clases = DB::table('clases')->count();

        // Total espacios (aulas, labs, etc.)
        $espacios = DB::table('espacios')->count();

        // Total PNF
        $pnf = DB::table('pnfs')->count();

        return response()->json([
            'docentes' => $docentes,
            'clases'   => $clases,
            'espacios' => $espacios,
            'pnf'      => $pnf,
        ]);
    }
}
