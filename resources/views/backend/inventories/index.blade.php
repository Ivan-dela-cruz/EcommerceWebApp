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
      <h6 class="m-0 font-weight-bold text-primary float-left">Stock de productos</h6>
      <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Crear Nuevo Producto</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($products)>0)
        <table class="table table-bordered table-striped" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>N°</th>
              <th>Título</th>
              <th>Categoría</th>
              <th>Precio</th>
              <th>Descuento</th>
              <th>Tamaño</th>
              <th>Plataforma</th>
              <th>Cantidad</th>
              <th>Estado</th>
            </tr>
          </thead>
          
          <tbody>

            @foreach($products as $product)
              @php
              $sub_cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
              // dd($sub_cat_info);
              $brands=DB::table('brands')->select('title')->where('id',$product->brand_id)->get();
              @endphp
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->title}}</td>
                    <td>{{$product->cat_info['title']}}
                      <sub>
                        @foreach($sub_cat_info as $data)
                          {{$data->title}}
                        @endforeach
                      </sub>
                    </td>
                    <td>$ {{$product->price}}</td>
                    <td>  {{$product->discount}}% </td>
                    <td>
                      @if ($product->size == "P")
                          Pequeño
                      @else
                          Grande
                      @endif
                    </td>
                    <td>@foreach($brands as $brand) {{$brand->title}} @endforeach</td>
                    <td>
                      @if($product->stock>10)
                      <span class="badge badge-primary">{{$product->stock}}</span>
                      @else
                      <span class="badge badge-danger">{{$product->stock}}</span>
                      @endif
                    </td>
                    
                    <td>
                        @if($product->status=='active')
                            <span class="badge badge-success">{{$product->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$product->status}}</span>
                        @endif
                    </td>
                    
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$products->links()}}</span>
        @else
          <h6 class="text-center">¡No se han encontrado productos! Por favor registre productos</h6>
        @endif
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

      $('#product-dataTable').DataTable( {
        "scrollX": false,
        "language":data
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
                  title: "¿Estas seguro?",
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
