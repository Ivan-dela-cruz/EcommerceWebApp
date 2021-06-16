<!DOCTYPE>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Reporte de venta</title>
<style>
    body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif;
        font-size: 14px;
        /*font-family: SourceSansPro;*/
    }

    #logo {
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
    }

    #imagen {
        width: 75px;
        height: 75px;
    }

    #datos {
        float: left;
        margin-top: 0%;
        margin-left: 0%;
        margin-right: 2%;
        /*text-align: justify;*/
    }

    #encabezado {
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
    }

    #fact {
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
    }

    section {
        clear: left;
    }

    #cliente {
        text-align: left;
    }

    #facliente {
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
    }

    #fac, #fv, #fa {
        color: #FFFFFF;
        font-size: 15px;
    }

    #facliente thead {
        padding: 20px;
        background: #06AB53;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;
    }

    #facvendedor {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
    }

    #facvendedor thead {
        padding: 20px;
        background: #06AB53;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
    }

    #facarticulo {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
    }

    #facarticulo thead {
        padding: 20px;
        background: #06AB53;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
    }

    #facarticulo tbody, tfoot {
        text-align: center;
    }

    #facarticulo tbody tr:nth-child(2n) {
        background: #f2f2f2;
    }


    #gracias {
        text-align: center;
    }
</style>
<body>
{{--@foreach ($venta as $v)--}}
<header>
    <div id="logo">
        <img src="{{public_path('backend/img/logo_.png')}}" alt="CompartiendoCodigo" id="imagen">
    </div>
    <div id="datos">
        <p id="encabezado">
            <b>ASPRALNUES</b>
{{--            <br>La unidad hace la fuerza ASOCIACIÓN "ASPRALNUES "--}}
            <br><b>RUC: 0502828668001</b>
            <br>Parroquia Belisario Quevedo, barrio La Compania-Ecuador
            <br>Telefono: 0958772874
            <br>Email: aspralnues@gmail.com
        </p>
    </div>
    <div id="fact">
        <p>{{$order->order_number}}</p>
    </div>
</header>
<br>
<section>
    <div>
        <table id="facliente">
            <thead>
            <tr>
                <th id="fac">Cliente</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th><p id="cliente">Sr(a). {{$order->first_name}}&nbsp;{{$order->last_name}}<br>
                        {{--                            {{$v->tipo_documento}}: {{$v->num_documento}}<br>--}}
                        Dirección: {{$order->address1}}<br>
                        Teléfono: {{$order->phone}}<br>
                        Email: {{$order->email}}</p></th>
            </tr>
            </tbody>
        </table>
    </div>
</section>
{{--@endforeach--}}
{{--<br>--}}
{{--<section>--}}
{{--    <div>--}}
{{--        <table id="facvendedor">--}}
{{--            <thead>--}}
{{--            <tr id="fv">--}}
{{--                <th>VENDEDOR</th>--}}
{{--                <th>FECHA</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            <tr>--}}
{{--                <td>{{$v->usuario}}</td>--}}
{{--                <td>{{$v->created_at}}</td>--}}
{{--            </tr>--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--</section>--}}
<br>
<section>
    <div>
        <table id="facarticulo">
            <thead>
            <tr id="fa">
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($details as $data)
                <tr>
                    <td>{{$data['product_name']}}</td>
                    <td>{{$data['quantity']}}</td>
                    <td><strong>$</strong>{{number_format($data['price'],2)}}</td>
                    <td><strong>$</strong>{{number_format($data['amount'],2)}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4"></td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2"></td>
                <td><strong>Subtotal:</strong></td>
                <td><strong>$</strong>{{number_format($order->sub_total,2)}}</td>
            </tr>
            @php
                $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->value('price');
            @endphp
            <tr>
                <td colspan="2"></td>
                <td>Costo de envío</td>
                <td><strong>$ </strong>
                    @if(is_null($shipping_charge))
                        0
                    @else
                     {{number_format($shipping_charge[0],2)}} 
                    @endif
                   
                    
                </td>
            </tr>

            <tr>
                <td colspan="2"></td>
                <td style="vertical-align: middle"><strong>Total:</strong></td>
                <td style="color: green">
                    <strong>$</strong>{{number_format($order->total_amount,2)}}</td>
            </tr>
            </tfoot>

        </table>
    </div>
</section>
<br>
<br>
<footer>
    <div id="gracias">
        <p><b>Gracias por su compra!</b></p>
    </div>
</footer>
</body>
</html>
