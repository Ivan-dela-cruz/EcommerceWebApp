<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputTitle" class="col-form-label">Tipo de Documento</label>
        <input id="inputTitle" type="text" placeholder="Ingrese el tipo de Documento"
               wire:model="type_document"
               class="form-control">
        @error('type_document')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="inputTitle" class="col-form-label">Número de Documento</label>
        <input id="inputTitle" type="text" placeholder="Ingrese el número de documento"
               wire:model="num_document"
               class="form-control">
        @error('num_document')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="col-md-6 form-group">
        <label for="inputTitle" class="col-form-label">Nombre</label>
        <input id="inputTitle" type="text" placeholder="Ingrese el nombre"
               wire:model="name"
               class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="inputTitle" class="col-form-label">Apellido</label>
        <input id="inputTitle" type="text" placeholder="Ingrese el apellido"
               wire:model="last_name"
               class="form-control">
        @error('last_name')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="inputTitle" class="col-form-label">Dirección</label>
        <input id="inputTitle" type="text"
               placeholder="Ingrese la direccipon"
               wire:model="address"
               class="form-control">
        @error('address')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="inputTitle" class="col-form-label">Teléfono</label>
        <input id="inputTitle" type="text"  placeholder="Ingrese el teléfono"
               wire:model="phone"
               class="form-control">
        @error('phone')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail" class="col-form-label">Correo</label>
        <input id="inputEmail" type="email"  placeholder="Ingrese el correo"
               wire:model="email"
               class="form-control">
        @error('email')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="inputPhoto" class="col-form-label">Foto</label>
        <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                <i class="fa fa-picture-o"></i> Elegir
                </a>
            </span>
            <input id="thumbnail" class="form-control" type="text"  wire:model="photo">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">
        @error('photo')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-6 form-group">
        <label for="status" class="col-form-label">Estado</label>
        <select  class="form-control" wire:model="status">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>
        @error('status')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</div>
