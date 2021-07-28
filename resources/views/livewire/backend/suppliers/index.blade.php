<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="user-dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>S.N.</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Foto</th>
                <th>Fecha de Ingreso</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
            </thead>
            
            <tbody>
              <p hidden>{{$cont = 1  }}</p>
            @foreach($suppliers as $data)
                <tr>
                    <td>{{$cont++}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->email}}</td>
                    <td>
                        @if($data->photo)
                            <img src="{{$data->photo}}" class="img-fluid rounded-circle" style="max-width:50px"
                                 alt="{{$data->photo}}">
                        @else
                            <img src="{{asset('backend/img/avatar.png')}}" class="img-fluid rounded-circle"
                                 style="max-width:50px" alt="avatar.png">
                        @endif
                    </td>
                    <td>{{(($data->created_at)? $data->created_at->diffForHumans() : '')}}</td>
                    <td>
                        <span
                            class="badge badge-{{$data->status === 1 ? 'success' : 'danger'}}">{{$data->status === 1 ? 'Activo' : 'Inactivo'}}</span>
                    </td>
                    <td>
                        <a href="{{route('suppliers.edit',$data->id)}}" class="btn btn-primary btn-sm float-left mr-1"
                           style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Editar"
                           data-placement="bottom"><i class="fas fa-edit"></i></a>

                        <button class="btn btn-danger btn-sm"  type="button" wire:click="delete({{$data->id}})" style="height:30px;
                                    width:30px;border-radius:50%"
                                data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i
                                class="fas fa-trash-alt"></i></button>
                    </td>
                    {{-- Delete Modal --}}
                    {{-- <div class="modal fade" id="delModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="#delModal{{$user->id}}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="#delModal{{$user->id}}Label">Delete user</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="{{ route('users.destroy',$user->id) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger" style="margin:auto; text-align:center">Parmanent delete user</button>
                              </form>
                            </div>
                          </div>
                        </div>
                    </div> --}}
                </tr>
            @endforeach
            </tbody>
        </table>
        <span style="float:right">{{$suppliers->links()}}</span>
    </div>
</div>
