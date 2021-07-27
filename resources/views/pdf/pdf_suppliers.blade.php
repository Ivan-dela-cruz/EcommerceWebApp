<!DOCTYPE>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Reporte de Proveedores</title>
<style>
    body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif;
        /*font-family: SourceSansPro;*/
    }

    #logo {
        height: 60;
        width:60;
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
    }

    #imagen {
        width: 120px;
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
        font-size: 13px;
    }

    #tiutlo_pdf {
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 18px;
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
        width: 60%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 12px;
    }

    #fac, #fv, #fa {
        color: #FFFFFF;
        font-size: 10px;
    }

    #facliente thead {
        padding: 20px;
        background: #238288;
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
        background: #238288;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
    }

    #facarticulo {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 15px;
    }

    #facarticuloS thead {
        padding: 20px;
        background: #019645;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
    }

    thead {
        background-color: #246355;
        color: white;
    }

    #gracias {
        text-align: center;
    }

    #datoOrden {
        text-align: left;
        font-size: 12px;
    }

    #headerOrden {
        text-align: left;
        vertical-align: center;
        font-size: 12px;
        color: white;
    }

    #tableOrdenDetalle {
        width: 100%;
        border: 1px solid #000;
    }

    #thOrdenDetalle, .tdOrdenDetalle {
        text-align: left;
        vertical-align: center;
        border: 1px solid #000;
        border-collapse: collapse;
        padding: 0.3em;
        font-size: 11px;

    }

    .encabezado {
        width: 100%;
        height: auto;
        background-color: #d0d2d4;
        display: flex;
    }

    .logo {
        margin-right: 20px;
        height: 80px;
    }

    .name-company {
        margin-bottom: 0px;
        font-size: 20px;
        color: #019645;
        font-family: 'Montserrat', sans-serif;
    }

    .box-company {
        float: right;
        text-align: center;
        width: 50%;
        height: 80px;
        align-content: center;
    }

    .dates-company {
        font-size: 9px;
        color: #3e3d3d;
    }

    .lines-1 {
        opacity: 0.5;
        margin-top: -5px;
        margin-bottom: 5px;
        height: 10px;
        width: 50%;
        background-color: #bcccef;
    }

    .lines-2 {
        margin-left: 50%;
        opacity: 0.5;
        margin-top: -5px;
        margin-bottom: 5px;
        height: 10px;
        width: 50%;
        background-color: #019645;
    }

    .box-1 {
        height: 190px;
        width: 300px;
        padding: 10px;
    }

    .box-derecho {
        height: 190px;
        width: 30%;
        margin-left: 50%;
        padding: 10px;
    }

    .box-2 {
        height: 120px;
        width: 100%;
        padding-left: 10px;
        background-color: #fff;
        border: 2px solid #019645;
        border-radius: 25px;
    }

    h1 {
        font-size: 11px;
        font-family: 'Montserrat', sans-serif;
        color: #000000;
        font-weight: bold;
        margin-bottom: 2px;
        margin-top: 2px;
    }

    span {
        margin-top: 2px;
        margin-bottom: 2px;
        text-transform: uppercase;
        font-family: 'Montserrat', sans-serif;
        font-size: 9px;
        color: #434343;
        font-weight: normal;
    }

    .box {
        height: auto;
        background-color: #0a1120;
        display: flex;
        flex-wrap: nowrap;
    }

    .diente {
        height: 40px;
        width: 40px;

    }

    .group-diente {
        display: flex;
        flex-wrap: nowrap;
        width: 300px;
        height: 45px;
    }

    .img-diente {
        height: 40px;
        width: 40px;

    }

    table {
        width: 100%;
        border: 1px solid #ffffff;
        border-collapse: collapse;
    }

    th, td {
        text-align: left;
        vertical-align: top;
        border: 1px solid #FFFFFF;
        border-collapse: collapse;
        padding: 0.3em;
        caption-side: bottom;
        font-size: 10px;
        font-family: 'Montserrat', sans-serif;
    }

    table tbody tr:nth-child(2n) {
        background: #f2f2f2;
    }


</style>
<body>
<section style="margin-bottom: 0px; height: auto;">
    <div class="encabezado">
        <img class="logo" src="{{public_path('backend/img/logo_.png')}}" alt="">
        <div class="box-company">
            <h1 class="name-company">ASPRALNUES</h1>
            <small class="dates-company">RUC: 0502828668001<br></small>
            <small class="dates-company">Parroquia Belisario Quevedo, barrio La Compania-Ecuador</small>
            <small class="dates-company">Telefono: 0958772874</small>
            <small class="dates-company">Email: aspralnues@gmail.com</small>


        </div>
    </div>
    <div class="box">
        <div class="lines-1"></div>
        <div class="lines-2"></div>
    </div>

</section>
<section style="margin-top: 0px; margin-top: 5px;">
    <div>
        <table>
            <thead>
            <tr style="color: black; text-align: center; background-color: #FFFFFF; border: 1px solid #FFFFFF;">
                <th style="text-align: left; font-size: 11px;" colspan="3">Reporte de Proveedores - {{time()}}</th>
                <th style="text-align: left;  font-weight: normal; font-size: 11px; font-size: 12px;" colspan="2">Usuario
                    - {{\Illuminate\Support\Facades\Auth::user()->name}}</th>
                <th style="text-align: right; font-weight: normal; font-size: 11px;" colspan="2">Fecha
                    - {{\Carbon\Carbon::parse(time())->toFormattedDateString()}}</th>
            </tr>
            <tr style="text-align: left; background-color: #019645; border: 2px solid #019645;">
                <th width="20px">N°</th>
                <th style="text-align: center" width="70px">DNI</th>
                <th style="text-align: center" width="125px">Proveedor</th>
                <th style="text-align: center" width="85px">Correo</th>
                <th style="text-align: center" width="55px">Teléfono</th>
                <th style="text-align: center" width="105px">Creación</th>
                <th style="text-align: center" width="80px">Estado</th>

            </tr>
            </thead>
            <tbody>
            {{$contador = 1}}
            @foreach($suppliers as $data)
                <tr>
                    <td>{{$contador}}</td>
                    <td style="text-align: center">
                        {{$data->num_document}}
                    </td>
                    <td >
                        {{$data->last_name}} {{$data->name}}
                    </td>

                    <td style="text-align: center">
                        {{$data->email}}
                    </td>
                    <td style="text-align: center">
                        {{$data->phone}}
                    </td>
                    <td style="text-align: center">
                        {{\Carbon\Carbon::parse($data->created_at)->format('Y-m-d') }}
                    </td>
                    <td style="text-align: center">
                        {{ $data->status === 1 ? 'Activo' : 'Inactivo' }}
                    </td>




                </tr>
                {{$contador++}}
            @endforeach


            <tr style="color: black; text-align: center; background-color: #FFFFFF; border: 1px solid #FFFFFF;">
                <th style="text-align: right; font-size: 12px;" colspan="4"></th>
                <th style="text-align: center; font-size: 12px;" colspan="2">Total registros</th>
                <th style="text-align: center; font-size: 12px;">{{$contador -1}}</th>
            </tr>
            </tbody>
        </table>
    </div>
</section>

</body>
</html>
