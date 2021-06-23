@extends('backend.layouts.master')

@section('title','Aspralnues || Banner Create')

@section('main-content')

<div class="card">
    <h5 class="card-header">Agregar Banner</h5>
    <div class="card-body">
        <form method="post" action="{{route('banner.store')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputTitle" class="col-form-label">Título <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Ingresar el título" value="{{old('title')}}" class="form-control">
                @error('title')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="inputDesc" class="col-form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
                @error('description')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="inputPhoto" class="col-form-label">Foto <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Elegir
                        </a>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
                </div>
                <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                @error('photo')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status" class="col-form-label">Estado <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>
                @error('status')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-check form-group ">
                <input name="caption" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Visibilidad de elementos
                </label>
            </div>
            <div class="form-group mb-3">
                <button type="reset" class="btn btn-warning">Cancelar</button>
                <button class="btn btn-success" type="submit">Guardar</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
        $('#description').summernote({
            placeholder: "Escriba una descripción corta....."
            , tabsize: 2
            , height: 150
        });
    });

</script>
@endpush
