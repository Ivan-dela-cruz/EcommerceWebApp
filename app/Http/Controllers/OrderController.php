<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use Exception;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('backend.order.index')->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name'=>'string|required',
            'last_name'=>'string|required',
            'address1'=>'string|required',
            'address2'=>'string|nullable',
            'coupon'=>'nullable|numeric',
            'phone'=>'numeric|required',
            'post_code'=>'string|nullable',
            'email'=>'string|required'
        ]);
        // return $request->all();

        if(empty(Cart::where('user_id',auth()->user()->id)->where('order_id',null)->first())){
            request()->session()->flash('error','Cart is Empty !');
            return back();
        }
        // $cart=Cart::get();
        // // return $cart;
        // $cart_index='ORD-'.strtoupper(uniqid());
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }

        // $total_prod=0;
        // if(session('cart')){
        //         foreach(session('cart') as $cart_items){
        //             $total_prod+=$cart_items['quantity'];
        //         }
        // }

        $order=new Order();
        $order_data=$request->all();
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        $order_data['user_id']=$request->user()->id;
        $order_data['shipping_id']=$request->shipping;
        $shipping=Shipping::where('id',$order_data['shipping_id'])->pluck('price');
        // return session('coupon')['value'];
        $order_data['sub_total']=Helper::totalCartPrice();
        $order_data['quantity']=Helper::cartCount();
        if(session('coupon')){
            $order_data['coupon']=session('coupon')['value'];
        }
        if($request->shipping){
            if(session('coupon')){
                $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0];
            }
        }
        else{
            if(session('coupon')){
                $order_data['total_amount']=Helper::totalCartPrice()-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=Helper::totalCartPrice();
            }
        }
        // return $order_data['total_amount'];
        $order_data['status']="new";
        if(request('payment_method')=='paypal'){
            $order_data['payment_method']='paypal';
            $order_data['payment_status']='paid';
        }
        else{
            $order_data['payment_method']='cod';
            $order_data['payment_status']='Unpaid';
        }
        $order->fill($order_data);
        $status=$order->save();
        if($order)
            // dd($order->id);
            $users=User::where('role','admin')->first();
        $details=[
            'title'=>'Nueva Orden Creada',
            'actionURL'=>route('order.show',$order->id),
            'fas'=>'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));
        if(request('payment_method')=='paypal'){
            return redirect()->route('payment')->with(['id'=>$order->id]);
        }
        else{
            session()->forget('cart');
            session()->forget('coupon');
        }
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

        try{
            $this->savePdfStorage($order->id);
        }catch(Exception $e){

        }
        // dd($users);
        request()->session()->flash('success','Su producto se puso en orden con éxito');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('backend.order.edit')->with('order',$order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order=Order::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,process,delivered,cancel'
        ]);
        $data=$request->all();
        // return $request->status;
        if($request->status=='delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }
        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('success','Pedido actualizado con éxito');
        }
        else{
            request()->session()->flash('error','Error al actualizar el pedido');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order=Order::find($id);
        if($order){
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Pedido eliminado correctamente');
            }
            else{
                request()->session()->flash('error','El pedido no se puede eliminar');
            }
            return redirect()->route('order.index');
        }
        else{
            request()->session()->flash('error','No se puede encontrar el pedido');
            return redirect()->back();
        }
    }

    public function orderTrack(){
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request){
        // return $request->all();
        $order=Order::where('user_id',auth()->user()->id)->where('order_number',$request->order_number)->first();
        if($order){
            if($order->status=="new"){
                request()->session()->flash('success','Su orden ha sido puesta. espere por favor.');
                return redirect()->route('home');

            }
            elseif($order->status=="process"){
                request()->session()->flash('success','Su pedido está en proceso por favor espere.');
                return redirect()->route('home');

            }
            elseif($order->status=="delivered"){
                request()->session()->flash('success','Your order is successfully delivered.');
                return redirect()->route('home');

            }
            else{
                request()->session()->flash('error','Tu orden cancelada. Inténtalo de nuevo');
                return redirect()->route('home');

            }
        }
        else{
            request()->session()->flash('error','Número de pedido no válido, inténtelo de nuevo');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request){
        $order=Order::getAllOrder($request->id);
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        $pdf=PDF::loadview('backend.order.pdf',compact('order'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('payment_status','paid')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                $m=intval($month);
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }

    public function savePdfStorage($id)
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
        $client = $order->user;
        $pdf = \PDF::loadView('pdf.order', ['order' => $order, 'details' => $list,'client' => $client]);
        $nombrePdf = 'orden-' . $id . '.pdf';
        $path = public_path('docs/');
        $pdf->save($path . '/' . $nombrePdf);
        $order->url_file = "docs/orden-" . $order->id . '.pdf';
        $order->save();
    }
    public function generatePdf($id)
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
        $client = $order->user;
        $pdf = \PDF::loadView('pdf.order', ['order' => $order, 'details' => $list,'client' => $client]);
        $nombrePdf = 'orden-' . $id . '.pdf';
        return $pdf->download($nombrePdf);
        //$path = public_path('docs/');
        //$pdf->save($path . '/' . $nombrePdf);
    }
}
