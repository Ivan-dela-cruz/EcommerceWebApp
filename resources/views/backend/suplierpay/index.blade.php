@extends('backend.layouts.master')

@section('main-content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Lista de pagos</h6>
        <a href="{{route('payment-create')}}?id=0" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
            data-placement="bottom"><i class="fas fa-plus"></i> Crear Nuevo</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($payments)>0)
            <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>

                        <th>Proveedor</th>
                        <th>Litros</th>
                        <th>Detalle Desc.</th>
                        <th>Total Desc.</th>
                        <th>Total Pag.</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($payments as $pay)
                    <tr>
                        <td>
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <b> {{$pay->supplier->name}} {{$pay->supplier->last_name}}</b>
                                </div>
                                <div class="col-sm-12">
                                    <small style="text-primary">{{$pay->address}}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{$pay->total_liters}}</td>
                        <td>
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <a href="javascript:void(0);" class="text-muted" data-toggle="collapse"
                                                data-target="#collapseOne{{$pay->id  }}" aria-expanded="true"
                                                aria-controls="collapseOne{{$pay->id  }}">
                                                <small><i class="fas fa-file"></i>
                                                    Ver detalle</small>
                                            </a>
                                        </h5>
                                    </div>

                                    <div id="collapseOne{{$pay->id  }}" class="collapse" aria-labelledby="headingOne"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>Quesos</td>
                                                        <td>{{ $pay->cheese }}</td>
                                                        <td>Suero</td>
                                                        <td>{{ $pay->serum }}</td>
                                                        <td>Yogurt</td>
                                                        <td>{{ $pay->yogurt }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Prestamo</td>
                                                        <td>{{ $pay->loan }}</td>
                                                        <td>Balanceado</td>
                                                        <td>{{ $pay->balanced }}</td>
                                                        <td>Sal</td>
                                                        <td>{{ $pay->salt }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Transferencia</td>
                                                        <td>{{ $pay->transaction }}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{$pay->cheese+$pay->serum+$pay->yogurt+$pay->loan+$pay->balanced+$pay->salt+$pay->transaction}}</td>
                        <td>{{$pay->total}}</td>
                        <td>
                            <a href="{{route('payment-create')}}?id={{$pay->id }}"
                                class="btn btn-primary btn-sm float-left mr-1"
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Editar"
                                data-placement="bottom"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{route('payment-delete',[$pay->id])}}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$pay->id}}
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <span style="float:right">{{$payments->links()}}</span>
            @else
            <h6 class="text-center">¡No se han encontrado pagos! Por favor realice un registro</h6>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    div.dataTables_wrapper div.dataTables_paginate {
        display: none;
    }

    .zoom {
        transition: transform .2s;
        /* Animation */
    }

    .zoom:hover {
        transform: scale(5);
    }
</style>
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
    $('#product-dataTable').DataTable({
        "scrollX": false
        
        , "language": data
    });

    // Sweet alert

    function deleteData(id) {

    }

</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function(e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            // alert(dataID);
            e.preventDefault();
            swal({
                    title: "¿Estas seguro?"
                    , text: "Una vez eliminados, ¡no podrá recuperar estos datos!"
                    , icon: "warning"
                    , buttons: true
                    , dangerMode: true
                , })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("¡Sus datos están seguros!");
                    }
                });
        })
    })

</script>
@endpush