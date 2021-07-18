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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


class ShopController extends Controller
{

    public $payment_status;
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

    public function getOrders($status = '')
    {
        $this->payment_status = $status;
        $user = Auth::user();
        $orders = Order::where('user_id',$user->id)
            ->where(function ($query){
                $query->when($this->payment_status != '', function ($q) {
                    $q->where('payment_status', $this->payment_status);
                });
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        $list = new Collection();

        foreach ($orders as $data) {
            $item = [
                'id' => $data->id,
                'order_number' => $data->order_number,
                'user_id' => $data->user_id,
                'sub_total' => number_format($data->sub_total,"2",".",""),
                'total_amount' => number_format($data->total_amount,"2",".",""),
                'payment_status' => $data->payment_status,
                'url_file' => $data->url_file,
                'created_at' => $data->created_at,
            ];
            $list->push($item);
        }

        return response()->json([
            'success' => true,
            'orders' => $list
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
                'price' => number_format($data->price, "2",".",""),
                'status' => $data->status,
                'quantity' => $data->quantity,
                'amount' => number_format($data->amount, "2",".",""),
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

    public function registerPayment(Request $request){
        $user = User::find(Auth::user()->id);
        $order = Order::find($request->order_id);

        $rules = [
            'order_id' => 'required',
            'ticket_url' => 'required'
        ];
        $messages = [
            'order_id' => 'Error al identificar la reservacion',
            'ticket_url.required' => 'Para registrar su pago debe subir el ticket.',
//            'ticket_url.string' => 'El ticket debe estar en formato: .jpg,.jpeg ó .png.'
        ];


        $dataValidate = Validator::make($request->all(), $rules, $messages);

        $errors = $dataValidate->fails();
        $list = new Collection();
//        dd($dataValidate->errors()->toJson());
        if ($errors) {
            foreach ($dataValidate->errors()->toArray() as $k => $v) {
                $item = [
                    'input' => $k,
                    'value' => $v[0],
                ];

                $list->push($item);
            }
//            dd($list);
            return response()->json([
                'success' => false,
                'errors' => $list
            ]);
        } else {

            $url_ticket = null;

            $data = [
                'payment_status' => 'paid',
                'ticket_url' => $this->uploadImage($request, $url_ticket)
            ];

            $order->update($data);

            return response()->json([
                'success' => true,
                'code' => 'SUCCESS_REQUEST'
            ]);
        }
    }

    public function uploadImage(Request $request, $temp_image)
    {
        $url_file = "images/reservations/tickets/";
        if ($request->ticket_url) {
            $foto = time() . '.jpg';
            file_put_contents('images/reservations/tickets/' . $foto, base64_decode($request->ticket_url));
            return $url_file . $foto;

        } else {
            return $temp_image;
        }
    }


}
