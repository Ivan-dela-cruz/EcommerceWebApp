@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Editar Proveedor</h5>
        @livewire('backend.suppliers.edit',['id' => $id])
    </div>

@endsection

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush
