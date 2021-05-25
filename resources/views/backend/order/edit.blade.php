@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header">Editar Pedido</h5>
  <div class="card-body">
    <form action="{{route('order.update',$order->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="status">Estado :</label>
        <select name="status" id="" class="form-control">
          <option value="">--Seleccionar--</option>
          <option value="new" {{(($order->status=='new')? 'selected' : '')}}>Nuevo</option>
          <option value="process" {{(($order->status=='process')? 'selected' : '')}}>En Proceso</option>
          <option value="delivered" {{(($order->status=='delivered')? 'selected' : '')}}>Entregado</option>
          <option value="cancel" {{(($order->status=='cancel')? 'selected' : '')}}>Cancelado</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
