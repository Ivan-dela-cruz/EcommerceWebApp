<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Venta;
use App\DetalleVenta;
use App\User;
use App\Persona;
use App\Notifications\NotifyAdmin;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


class ShopController extends Controller
{
    public function store(Request $request)
    {
        try {

            $user = User::find(Auth::user()->id);
            $customer = Persona::find($user->id);

            $date = Carbon::now()->format('Y-m-d H:i:s');
            DB::beginTransaction();
            $venta = new Venta();
            $venta->idcliente = $customer->id;
            $venta->idusuario = $customer->id;
            $venta->tipo_comprobante = "RECIBO";
            $venta->serie_comprobante = time();
            $venta->num_comprobante = time();
            $venta->fecha_hora = $date;
            $venta->impuesto = 0.14;
            $venta->total = $request->total_order;
            $venta->estado = "Registrado";

            $venta->save();

            $details = $request->detail_order;
            $data = json_decode($details, true);
            foreach ($data as $ep => $det) {

                $detail = new DetalleVenta();
                $detail->idventa = $venta->id;
                $detail->idarticulo = $det['id_product'];
                $detail->cantidad = $det['quanty'];
                $detail->precio = $det['total_price'];
                $detail->descuento = 0;
                $detail->save();

            }
            $venta->url_file = "facturas/venta-" . $venta->id . '.pdf';
            $venta->save();
            $this->savePdfStorage($venta->id);

            $fechaActual = date('Y-m-d');
            $numVentas = DB::table('ventas')->whereDate('created_at', $fechaActual)->count();
            $numIngresos = DB::table('ingresos')->whereDate('created_at', $fechaActual)->count();

            $arreglosDatos = [
                'ventas' => [
                    'numero' => $numVentas,
                    'msj' => 'Ventas'
                ],
                'ingresos' => [
                    'numero' => $numIngresos,
                    'msj' => 'Ingresos'
                ]
            ];
            $allUsers = User::all();

            foreach ($allUsers as $notificar) {
                User::findOrFail($notificar->id)->notify(new NotifyAdmin($arreglosDatos));
            }

            DB::commit();

            return response()->json([
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug('=====================================>>>>>>>>>>>>>>>>>>>>>>>' . $e);
            return response()->json([
                'success' => false,
                'error' => $e
            ], 500);
        }


    }

    public function getVentas()
    {
        $user = User::find(Auth::user()->id);
        $customer = Persona::find($user->id);

        $ventas = Venta::join('personas', 'ventas.idcliente', '=', 'personas.id')
            ->join('users', 'ventas.idusuario', '=', 'users.id')
            ->select('ventas.id', 'ventas.tipo_comprobante', 'ventas.serie_comprobante',
                'ventas.num_comprobante', 'ventas.fecha_hora', 'ventas.impuesto', 'ventas.total',
                'ventas.estado', 'personas.nombre', 'users.usuario', 'ventas.idcliente', 'ventas.url_file')
            ->where('ventas.idcliente', $customer->id)
            ->orderBy('ventas.id', 'desc')->get();

        return response()->json([
            'success' => true,
            'orders' => $ventas
        ], 200);
    }

    public function getDetalle($id)
    {


        $detalles = DetalleVenta::join('articulos', 'detalle_ventas.idarticulo', '=', 'articulos.id')
            ->select('detalle_ventas.id', 'detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento',
                'articulos.nombre as articulo', 'articulos.precio_venta'
                , 'articulos.descripcion', 'articulos.id as articulo_id')
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')->get();

        return response()->json([
            'details' => $detalles,
            'success' => true
        ], 200);
    }


    public function savePdfStorage($id)
    {
        $venta = Venta::join('personas', 'ventas.idcliente', '=', 'personas.id')
            ->join('users', 'ventas.idusuario', '=', 'users.id')
            ->select('ventas.id', 'ventas.tipo_comprobante', 'ventas.serie_comprobante',
                'ventas.num_comprobante', 'ventas.created_at', 'ventas.impuesto', 'ventas.total',
                'ventas.estado', 'personas.nombre', 'personas.tipo_documento', 'personas.num_documento',
                'personas.direccion', 'personas.email',
                'personas.telefono', 'users.usuario')
            ->where('ventas.id', '=', $id)
            ->orderBy('ventas.id', 'desc')->take(1)->get();

        $detalles = DetalleVenta::join('articulos', 'detalle_ventas.idarticulo', '=', 'articulos.id')
            ->select('detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento',
                'articulos.nombre as articulo')
            ->where('detalle_ventas.idventa', '=', $id)
            ->orderBy('detalle_ventas.id', 'desc')->get();

        $numventa = Venta::select('num_comprobante')->where('id', $id)->get();

        $pdf = \PDF::loadView('pdf.venta', ['venta' => $venta, 'detalles' => $detalles]);

        $nombrePdf = 'venta-' . $id . '.pdf';
        $path = public_path('facturas/');
        $pdf->save($path . '/' . $nombrePdf);
    }

    public function registerPayment(Request $request)
    {

        $size = $_FILES['files1']['size'];
        $target1 = basename($_FILES['files1']['name']);
        $filename = $target1;
        $filepath = public_path('facturas/payments/');

        $order = Venta::find($request->order_id);
        $order->update([
            'url_image' => 'facturas/payments/' . $filename,
            'estado' => 'Confirmado'
        ]);

        move_uploaded_file($_FILES['files1']['tmp_name'], $filepath . $filename);

        return response()->json([
            'success' => true,
        ], 200);
    }

}
