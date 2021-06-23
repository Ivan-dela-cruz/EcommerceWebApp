<div class="card-body">
    @include('livewire.backend.suppliers.partials.form')
    <div class="form-group mb-3">
        <button class="btn btn-success" type="button" wire:click="update()">Actualizar</button>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $('#thumbnail').on('change', function () {
            @this.set('photo',$('#thumbnail').val());
            });
        </script>
    @endpush
</div>
