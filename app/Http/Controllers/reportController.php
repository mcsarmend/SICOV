<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class reportController extends Controller
{
    public function existencias()
    {
        $type = $this->gettype();

        $products = DB::select('CALL lista_existencias_activas()');
        return view('inventario.existencias', ['type' => $type, 'products' => $products]);
    }
    public function reporteremisiones()
    {
        $type = $this->gettype();
        return view('reportes.remisiones', ['type' => $type]);
    }
    public function reportecortecaja()
    {
        $type = $this->gettype();
        return view('reportes.cortedecaja', ['type' => $type]);
    }
    public function gettype()
    {
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }
    public function generarreporteremisiones(Request $request)
    {
        try {
            $timezone   = 'America/Mexico_City';
            $hoy_inicio = Carbon::today($timezone)->startOfDay()->toDateTimeString(); // '2024-12-10 00:00:00'
            $hoy_fin    = Carbon::today($timezone)->endOfDay()->toDateTimeString();   // '2024-12-10 23:59:59'
            $id         = Auth::user()->id;
            $query      = 'CALL obtenerremisiones("' . $hoy_inicio . '","' . $hoy_fin . '",NULL)';

            $remisiones = DB::select($query);

            return response()->json(['message' => 'Reporte Generado Correctamente', 'remisiones' => $remisiones], 200);
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error al generar el reporte' . $th->getMessage()], 500);
        }
    }
}
