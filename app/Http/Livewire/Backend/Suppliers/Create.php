<?php

namespace App\Http\Livewire\Backend\Suppliers;

use App\Models\Supplier;
use App\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $type_document, $num_document, $name, $last_name, $email, $address, $phone, $photo, $status = 1;

    public function render()
    {
        return view('livewire.backend.suppliers.create');
    }

    public function store()
    {

        $this->Validate([
            'name' => 'required||regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'last_name' => 'required||regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'type_document' => 'required|string',
            'num_document' => 'required|digits:10',
            'address' => 'required',
            'phone' => 'required|numeric|digits:10',
            'email' => 'required|unique:users,email|unique:suppliers,email',
//            'photo' => 'required',
        ]);
/*
, [
            'name.required' => 'Campo obligatorio.',
            'last_name.required' => 'Campo obligatorio.',
            'type_document.required' => 'Campo obligatorio.',
            'num_document.required' => 'Campo obligatorio.',
            'address.required' => 'Campo obligatorio.',
            'phone.required' => 'Campo obligatorio.',
            'email.required' => 'Campo obligatorio.',
            'email.unique' => 'El correo ya existe',
//            'photo.required' => 'Campo obligatorio.',
        ]
*/
        $data_user = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->num_document),
            'role' => 'user'
        ];

        $user = User::create($data_user);

        $data_supplier = [
            'user_id' => $user->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'type_document' => $this->type_document,
            'num_document' => $this->num_document,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'photo' => $this->photo,
            'status' => $this->status,
        ];

        $supplier = Supplier::create($data_supplier);
        $this->resetInputFields();
        $this->alert('success', 'Proveedor registrado con exito.');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->last_name = '';
        $this->type_document = '';
        $this->num_document = '';
        $this->address = '';
        $this->phone = '';
        $this->email = '';
        $this->photo = '';
        $this->status = '';
    }
}
