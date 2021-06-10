<?php

namespace App\Http\Controllers\Api;


use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Venta;
use App\DetalleVenta;
use App\User;
use App\Persona;
use App\Notifications\NotifyAdmin;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


class ShopController extends Controller
{
    public function store(Request $request)
    {
        try {

            $user = Auth::user();
            $customer = Customer::where('user_id',$user->id)->first();


            $details = $request->detail_order;
            $data = json_decode($details, true);

            DB::beginTransaction();
            $order = new Order();
            $order->order_number = 'ORD-'.strtoupper(Str::random(10));
            $order->user_id = $user->id;
            $order->sub_total =  $request->total_order;
            $order->total_amount =  $request->total_order;
            $order->quantity =  count($data);
            $order->status = "new";
            $order->payment_method = "cod";

            $order->first_name = $customer->name;
            $order->last_name = $customer->last_name;
            $order->email = $customer->email;
            $order->phone = $customer->phone;
            $order->country = 'EC';
            $order->post_code = '012345';
            $order->address1 = $customer->address;
            $order->save();



            foreach ($data as $ep => $det) {

                $cart = new Cart();
                $cart->product_id = $det['id_product'];
                $cart->order_id = $order->id;
                $cart->user_id = $user->id;
                $cart->price = $det['price_unit'];
                $cart->status = 'new';
                $cart->quantity = $det['quanty'];
                $cart->amount =  $det['total_price'];
                $cart->save();

            }
            $order->url_file = "docs/orden-" . $order->id . '.pdf';
            $order->save();
            $this->savePdfStorage($order->id);

//            $fechaActual = date('Y-m-d');
//            $numVentas = DB::table('ventas')->whereDate('created_at', $fechaActual)->count();
//            $numIngresos = DB::table('ingresos')->whereDate('created_at', $fechaActual)->count();
//
//            $arreglosDatos = [
//                'ventas' => [
//                    'numero' => $numVentas,
//                    'msj' => 'Ventas'
//                ],
//                'ingresos' => [
//                    'numero' => $numIngresos,
//                    'msj' => 'Ingresos'
//                ]
//            ];
//            $allUsers = User::all();
//
//            foreach ($allUsers as $notificar) {
//                User::findOrFail($notificar->id)->notify(new NotifyAdmin($arreglosDatos));
//            }

            DB::commit();

            return response()->json([
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug('=====>>>>>>>' . $e);
            return response()->json([
                'success' => false,
                'error' => $e
            ], 500);
        }


    }

    public function getOrders()
    {

        $user = Auth::user();
        $orders = Order::where('user_id',$user->id)->get();

//        $user = User::find(Auth::user()->id);
//        $customer = Persona::find($user->id);
//
//        $ventas = Venta::join('personas', 'ventas.idcliente', '=', 'personas.id')
//            ->join('users', 'ventas.idusuario', '=', 'users.id')
//            ->select('ventas.id', 'ventas.tipo_comprobante', 'ventas.serie_comprobante',
//                'ventas.num_comprobante', 'ventas.fecha_hora', 'ventas.impuesto', 'ventas.total',
//                'ventas.estado', 'personas.nombre', 'users.usuario', 'ventas.idcliente', 'ventas.url_file')
//            ->where('ventas.idcliente', $customer->id)
//            ->orderBy('ventas.id', 'desc')->get();

        return response()->json([
            'success' => true,
            'orders' => $orders
        ], 200);
    }

    public function getDetail($id)
    {
        $order = Order::find($id);
        $details = Cart::where('order_id',$order->id)->get();

        $list = new Collection();

        foreach ($details as $data) {
            $item = [
                'id' => $data->id,
                'product_id' => $data->product_id,
                'product_name' => $data->product->title,
                'product_description' => $data->product->summary,
                'order_id' => $data->order_id,
                'user_id' => $data->user_id,
                'price' => $data->price,
                'status' => $data->status,
                'quantity' => $data->quantity,
                'amount' => $data->amount,
            ];

            $list->push($item);
        }
//        $detalles = DetalleVenta::join('articulos', 'detalle_ventas.idarticulo', '=', 'articulos.id')
//            ->select('detalle_ventas.id', 'detalle_ventas.cantidad', 'detalle_ventas.precio', 'detalle_ventas.descuento',
//                'articulos.nombre as articulo', 'articulos.precio_venta'
//                , 'articulos.descripcion', 'articulos.id as articulo_id')
//            ->where('detalle_ventas.idventa', '=', $id)
//            ->orderBy('detalle_ventas.id', 'desc')->get();

        return response()->json([
            'success' => true,
            'details' => $list,

        ], 200);
    }

    public function savePdfStorage($id)
    {
        $order = Order::find($id);
        $details = Cart::where('order_id',$order->id)->get();

//        dd($details);

        $list = new Collection();

        foreach ($details as $data) {
            $item = [
                'id' => $data->id,
                'product_id' => $data->product_id,
                'product_name' => $data->product->title,
                'product_description' => $data->product->summary,
                'order_id' => $data->order_id,
                'user_id' => $data->user_id,
                'price' => $data->price,
                'status' => $data->status,
                'quantity' => $data->quantity,
                'amount' => $data->amount,
            ];

            $list->push($item);
        }
//        dd($list);
        $client = $order->user;

        $pdf = \PDF::loadView('pdf.order', ['order' => $order, 'details' => $list,'client' => $client]);

        $nombrePdf = 'orden-' . $id . '.pdf';
        $path = public_path('docs/');
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
