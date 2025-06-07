<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\clients;
use App\Models\payments;

class pagosController extends Controller
{
    public function registropagos()
    {

        $type = $this->gettype();
        $clients = clients::all();
        return view('pagos.registrodepagos', ['type' => $type, 'clients' => $clients]);
    }

    public function registrarpago(Request $request)
    {

        try {

            // Crear una nueva instancia del modelo Usuario
            $payment = new payments();
            $payment->idcliente = intval($request->idcliente);
            $payment->monto = floatval($request->monto);
            $payment->concepto = $request->concepto;
            $payment->fecha_pago = $request->fecha_pago;
            $payment->metodo_pago = $request->metodo_pago;
            $iduser = Auth::user()->id;
            $payment->idusuario = intval($iduser);
            $payment->observaciones = $request->observaciones;
            $payment->mes_correspondiente = $request->mes_correspondiente;
            $payment->estatus = 'Emitido';
            // Guardar el usuario en la base de datos
            $payment->save();


            return response()->json(['message' => 'Pago registrado correctamente'], 200);
        } catch (\Throwable $e) {
            // Devolver una respuesta de error
            return response()->json(['message' => 'Error al registrar el pago: ' . $e->getMessage()], 500);
        }
    }

    public function historicodepagos()
    {
        $type = $this->gettype();
            $pagos = payments::select([
            'payments.id',
            'clients.nombre',
            'payments.monto',
            'payments.concepto',
            'payments.fecha_pago',
            'payments.metodo_pago',
            'payments.observaciones',
            'payments.mes_correspondiente',
            'payments.estatus',

            'users.name as usuario',
            DB::raw('COALESCE(payments.observaciones, "Sin observaciones") as observaciones')
        ])
            ->leftJoin('users', 'payments.idusuario', '=', 'users.id')
            ->leftJoin('clients', 'payments.idcliente', '=', 'clients.id')
            ->get();


        return view('pagos.historicodepagos', ['type' => $type, 'pagos' => $pagos]);
    }



    public function gettype()
    {
        if (Auth::check()) {
            $type = Auth::user()->role;
        }
        return $type;
    }
}
