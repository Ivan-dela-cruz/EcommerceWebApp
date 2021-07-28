@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
    <h5 class="card-header">Pedido
        <a href="{{route('order.index')}}"  class=" btn btn-sm btn-primary shadow-sm float-right mr-2 ml-2"><i
            class="fas fa-arrow-alt-circle-left fa-sm text-white-50"></i> Atras </a>
        @if(is_null($order->url_file) || !file_exists($order->url_file))
            <a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-info shadow-sm float-right"><i
                class="fas fa-download fa-sm text-white-50"></i> Generar PDF</a>
        @else
            <a href="{{asset($order->url_file)}}" target="_blank" class=" btn btn-sm btn-success shadow-sm float-right"><i
                class="fas fa-download fa-sm text-white-50"></i> Descargar PDF</a>
        @endif
    </h5>
    <div class="card-body">
        @if($order)
        <table class="table table-striped table-hover">
            @php
            $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
            @endphp
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>No. de Pedido</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Cantidad</th>
                    <th>Cargo</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->order_number}}</td>
                    <td>{{$order->first_name}} {{$order->last_name}}</td>
                    <td>{{$order->email}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>@foreach($shipping_charge as $data) $ {{number_format($data,2)}} @endforeach</td>
                    <td>${{number_format($order->total_amount,2)}}</td>
                    <td>
                        @if($order->status=='new')
                        <span class="badge badge-primary">Nueva</span>
                        @elseif($order->status=='process')
                        <span class="badge badge-warning">En proceso</span>
                        @elseif($order->status=='delivered')
                        <span class="badge badge-success">Etregada</span>
                        @else
                        <span class="badge badge-danger">Cancelada</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1"
                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                            data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}}
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>

                </tr>
            </tbody>
        </table>
        <section class="confirmation_part section_padding">
            <div class="order_boxes">
                <div class="row">
                    <div class="col-lg-6 col-lx-4">
                        <div class="order-info">
                            <h4 class="text-center pb-4">INFORMACIÓN DEL PEDIDO</h4>

                            <table class="table">
                                <tr class="">
                                    <td>Número de pedido</td>
                                    <td> : {{$order->order_number}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha de pedido</td>
                                    <td> : {{\Carbon\Carbon::parse($order->created_at)->isoFormat('llll')}} </td>
                                </tr>
                                <tr>
                                    <td>Cantidad</td>
                                    <td> : {{$order->quantity}}</td>
                                </tr>
                                <tr>
                                    <td>Estado de pedido</td>
                                    <td> :
                                        @if($order->status=='new')
                                        <span class="badge badge-primary">Nueva</span>
                                        @elseif($order->status=='process')
                                        <span class="badge badge-warning">En proceso</span>
                                        @elseif($order->status=='delivered')
                                        <span class="badge badge-success">Etregada</span>
                                        @else
                                        <span class="badge badge-danger">Cancelada</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    @php
                                    $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->value('price');
                                    @endphp
                                    <td>Costo de envío</td>
                                    <td> :
                                        @if(is_null($shipping_charge))
                                        $ 0
                                        @else
                                        $ {{number_format($shipping_charge[0],2)}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cupón</td>
                                    <td> : $ {{number_format($order->coupon,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td> : $ {{number_format($order->total_amount,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Método de pago</td>
                                    <td> : @if($order->payment_method=='cod') Pago al Repartidor @else NA @endif</td>
                                </tr>
                                <tr>
                                    <td>Estado de pago</td>
                                    <td> : {{$order->payment_status == 'paid' ? 'Pagado' : 'Pendiente'}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-6 col-lx-4">
                        <div class="shipping-info">
                            <h4 class="text-center pb-4">INFORMACIÓN DE ENVÍO</h4>
                            <table class="table">
                                <tr class="">
                                    <td>Nombre completo</td>
                                    <td> : {{$order->first_name}} {{$order->last_name}}</td>
                                </tr>
                                <tr>
                                    <td>Correo</td>
                                    <td> : {{$order->email}}</td>
                                </tr>
                                <tr>
                                    <td>Teléfono.</td>
                                    <td> : {{$order->phone}}</td>
                                </tr>
                                <tr>
                                    <td>Dirección</td>
                                    <td> : {{$order->address1}}, {{$order->address2}}</td>
                                </tr>
                                <tr>
                                    <td>País</td>
                                    <td> : {{$order->country}}</td>
                                </tr>
                                <tr>
                                    <td>Código postal</td>
                                    <td> : {{$order->post_code}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

    </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,
    .shipping-info {
        background: #ECECEC;
        padding: 20px;
    }

    .order-info h4,
    .shipping-info h4 {
        text-decoration: underline;
    }
</style>
@endpush