<div class="card-body">
    {{--    <form method="post" action="{{route('users.store')}}">--}}
    {{--    {{csrf_field()}}--}}
    @include('livewire.backend.suppliers.partials.form')


    <div class="form-group mb-3">
        <button type="button" wire:click="resetInputFields()" class="btn btn-warning">Cancelar</button>
        <button class="btn btn-success" type="button" wire:click="store()">Guardar</button>
    </div>
    {{--    </form>--}}

    @push('scripts')
        <script type="text/javascript">
            $('#thumbnail').on('change', function () {
                @this.set('photo',$('#thumbnail').val());
            });
        </script>
    @endpush
</div>
