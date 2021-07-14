<?php

namespace App\Http\Livewire\Backend\Suppliers;

use App\Models\Supplier;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public $supplier;
    public $supplier_id, $user_id, $type_document, $num_document, $name, $last_name, $email, $address, $phone, $photo, $status = 1;
    public function mount($id)
    {
        $this->supplier = Supplier::find($id);

        //load data
        $this->supplier_id = $this->supplier->id;
        $this->user_id = $this->supplier->user_id;
        $this->name = $this->supplier->name;
        $this->last_name = $this->supplier->last_name;
        $this->type_document = $this->supplier->type_document;
        $this->num_document = $this->supplier->num_document;
        $this->address = $this->supplier->address;
        $this->phone = $this->supplier->phone;
        $this->email = $this->supplier->email;
        $this->photo = $this->supplier->photo;
        $this->status = $this->supplier->status;
    }

    public function render()
    {
        return view('livewire.backend.suppliers.edit');
    }


    public function update(){
        $this->Validate([
            'name' => 'required||regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'last_name' => 'required||regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/u',
            'type_document' => 'required|string',
            'num_document' => 'required|digits:10',
            'address' => 'required',
            'phone' => 'required|numeric|digits:10',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user_id), Rule::unique('suppliers')->ignore($this->supplier_id)],
//            'photo' => 'required',
        ]);
        /*
        ,[
            'name.required' => 'Campo obligatorio.',
            'last_name.required' => 'Campo obligatorio.',
            'type_document.required' => 'Campo obligatorio.',
            'num_document.required' => 'Campo obligatorio.',
            'address.required' => 'Campo obligatorio.',
            'phone.required' => 'Campo obligatorio.',
            'email.required' => 'Campo obligatorio.',
//            'photo.required' => 'Campo obligatorio.',
        ]
        */

        $data_user = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->num_document),
            'role' => 'user'
        ];

        $user = User::find($this->user_id);
        $user->update($data_user);

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

        $this->supplier->update($data_supplier);
        $this->alert('success','Proveedor actualizado con exito.');
    }
}
