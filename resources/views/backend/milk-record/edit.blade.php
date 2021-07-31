@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Editar Recolección de Leche</h6>
        <a href="{{route('milk-record.show',$milk->income_id)}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
            data-placement="bottom" title="Regresa"><i class="fas fa-arrow-alt-circle-left"></i> Regresar</a>
    </div>
    <div class="card-body">
        <form method="post" action="{{route('milk-record.update',$milk->id)}}">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Proveedor <span class="text-danger">*</span></label>
                        <input disabled type="text" value="{{$milk->supplier->name}} {{$milk->supplier->last_name}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Fecha de registro <span class="text-danger">*</span></label>
                        <input disabled type="text" value="{{\Carbon\Carbon::parse($milk->income->date)->format('Y-m-d')}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Hora de registro <span class="text-danger">*</span></label>
                        <input disabled type="text" value="{{\Carbon\Carbon::parse($milk->income->hour)->format('H:i:s')}}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Litros <span class="text-danger">*</span></label>
                        <input id="liters" type="text" name="total_liters" placeholder="Ingrese litros" value="{{$milk->total_liters}}" class="form-control">
                        @error('total_liters')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-form-label">Precio <span class="text-danger">*</span></label>
                        <input id="price" type="text" name="price" placeholder="Ingrese el precio" value="{{number_format($milk->price,'2','.','')}}" class="form-control">
                        @error('price')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Sub Total <span class="text-danger">*</span></label>
                        <input id="total" type="text" name="sub_total" placeholder="Ingrese Sub Total" value="{{number_format($milk->sub_total,'2','.','')}}" class="form-control">
                        @error('sub_total')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <button class="btn btn-success" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')

<script>
    $('#liters').on('change', function() {
        var li = $('#liters').val();
        var price = $('#price').val();
        var total  = li * price;
        $('#total').val(total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&'));
    });
    $('#price').on('change', function() {
        var li = $('#liters').val();
        var price = $('#price').val();
        var total  = li * price;
        $('#total').val(total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&')) ;
    });
</script>
@endpush
