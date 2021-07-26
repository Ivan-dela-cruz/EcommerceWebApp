<div>
    <h5 class="card-header d-flex justify-content-between align-items-center">
        {{ $action=="POST"?'Nuevo Pago':'Actualizar Datos del Pago' }}
        <a href="{{ route('payment-index') }}" class="btn btn-info">Atras</a>
    </h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>Información del pago</h4>
                <div class="form-group">
                    <label for="suplier_id" class="col-form-label">Proveedor <span class="text-danger">*</span></label>
                    <select class="form-control" wire:model="suplier_id" name="supplier">
                        <option value="">Seleccione un Proveedor</option>
                        @foreach($suppliers as $sp)
                        <option value="{{$sp->id  }}">{{$sp->name  }}</option>
                        @endforeach
                    </select>
                    @error('suplier_id')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
                    <input class="form-control" wire:model="address" type="text">
                    @error('address')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Fecha <span class="text-danger">*</span></label>
                    <input class="form-control" wire:model="date" type="date">
                    @error('date')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Quincena <span class="text-danger">*</span></label>
                    <input class="form-control" wire:model="biweekly" type="text">
                    @error('biweekly')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Total Litros <span
                            class="text-danger">*</span></label>
                    <input class="form-control" wire:model="total_liters" type="text">
                    @error('total_liters')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Precio Unitario <span
                            class="text-danger">*</span></label>
                    <input class="form-control" wire:model="unit_price" type="text">
                    @error('unit_price')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Total a Pagar <span
                            class="text-danger">*</span></label>
                    <input class="form-control" wire:model="total" type="text">
                    @error('total')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <h4>Descuentos del pago</h4>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Quesos </label>
                    <input class="form-control" wire:model="cheese" type="text">
                    @error('cheese')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Suero </label>
                    <input class="form-control" wire:model="serum" type="text">
                    @error('serum')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Yogurt </label>
                    <input class="form-control" wire:model="yogurt" type="text">
                    @error('yogurt')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Prestamo </label>
                    <input class="form-control" wire:model="loan" type="text">
                    @error('loan')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Balanceado </label>
                    <input class="form-control" wire:model="balanced" type="text">
                    @error('balanced')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Sal </label>
                    <input class="form-control" wire:model="salt" type="text">
                    @error('salt')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Transaccion Bancaria </label>
                    <input class="form-control" wire:model="transaction" type="text">
                    @error('transaction')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>

            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Descripción </label>
                    <textarea class="form-control" wire:model="description"></textarea>
                    @error('description')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="button" wire:click="resetInputFields()" class="btn btn-warning">Cancelar</button>
                    @if($action=="POST")
                    <button class="btn btn-success" type="button" wire:click="store()">Guardar</button>
                    @else
                    <button class="btn btn-primary" type="button" wire:click="update()">Actualizar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>