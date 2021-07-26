
<div class="form-group">
    <label for="suplier_id" class="col-form-label">Proveedor <span class="text-danger">*</span></label>
    {!! Form::select('suplier_id', $suppliers , null , ['class' => 'form-control','required'=>'required']) !!}
    @error('suplier_id')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::date('date',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('date')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::text('biweekly',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('biweekly')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::text('address',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('address')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::textarea('description',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('description')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::numeric('total_liters',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('total_liters')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::numeric('cheese',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('cheese')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::numeric('serum',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('serum')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::numeric('yogurt',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('yogurt')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::numeric('loan',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('loan')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::numeric('balanced',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('balanced')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::numeric('balanced',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('balanced')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::numeric('balanced',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('balanced')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group">
    <label for="inputTitle" class="col-form-label">Dirección <span class="text-danger">*</span></label>
    {!! Form::numeric('balanced',null, ['id'=>'address','required'=>'required','class' => 'form-control']) !!}
    @error('balanced')
        <strong class="text-danger">{{ $message }}</strong>
    @enderror
</div>
<div class="form-group mb-3">
    <button type="reset" class="btn btn-warning">Cancelar</button>
    <button class="btn btn-success" type="submit">Guardar</button>
</div>