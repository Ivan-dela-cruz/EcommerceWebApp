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
            <h6 class="m-0 font-weight-bold text-primary float-left">Detalle de Recolección de Leche</h6>
            <a href="{{route('milk-record.index')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Regresa"><i class="fas fa-caret-left"></i> Regresar</a>
        </div>
        <div class="card-body">
            <div class="container">
               <div class="row">
                   <div class="col-md-6">
                       <h6><Strong>Fecha de Registro:</Strong>&nbsp;{{\Carbon\Carbon::parse($income->date)->format('Y-m-d')}}</h6>
                       <h6><Strong>Hora de Registro:</Strong>&nbsp;{{\Carbon\Carbon::parse($income->hour)->format('H:i:s')}}</h6>
                   </div>
                   <div class="col-md-6">
                       <h6><strong>Total de Litros:</strong>&nbsp;{{$income->total_liters}}</h6>
                       <h6><strong>Precio Total:</strong>&nbsp;$&nbsp;{{number_format($income->total_price,2)}}</h6>
                   </div>
               </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="banner-dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Proveedor</th>
                        <th>Total Litros</th>
                        <th>Precio</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th colspan="3"></th>
                        <th>Total</th>
                        <td>{{number_format($income->total_liters)}}</td>
                        <th>&nbsp;</th>
                        <td>$&nbsp;{{number_format($income->total_price,2)}}</td>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($income->milkRecord as $data)
                        <tr>
                            <td>{{$data->id}}</td>
                            <td>{{\Carbon\Carbon::parse($data->date)->format('Y-m-d')}}</td>
                            <td>{{\Carbon\Carbon::parse($data->hour)->format('H:i:s')}}</td>
                            <td>
                                <div class="container">
                                <h6><strong>{{$data->supplier->last_name}}&nbsp;{{$data->supplier->name}}</strong></h6>
                                    <small> <strong>Correo:&nbsp;</strong>{{$data->supplier->email}}</small><br>
                                    <small> <strong>Teléfono:&nbsp;</strong>{{$data->supplier->phone}}</small>
                                </div>
                            </td>
                            <td>{{$data->total_liters}}</td>
                            <td>$ {{number_format($data->price,2)}}</td>
                            <td>$ {{number_format($data->sub_total,2)}}</td>
                            {{-- Delete Modal --}}
                            {{-- <div class="modal fade" id="delModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="#delModal{{$user->id}}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="#delModal{{$user->id}}Label">Delete user</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <form method="post" action="{{ route('banners.destroy',$user->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" style="margin:auto; text-align:center">Parmanent delete user</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            </div> --}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate{
            display: none;
        }
        .zoom {
            transition: transform .2s; /* Animation */
        }

        .zoom:hover {
            transform: scale(3.2);
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

        $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[4,5]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
    </script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e){
                var form=$(this).closest('form');
                var dataID=$(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                    title: "¿Está seguro?",
                    text: "Una vez eliminados, ¡no podrá recuperar estos datos!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
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
