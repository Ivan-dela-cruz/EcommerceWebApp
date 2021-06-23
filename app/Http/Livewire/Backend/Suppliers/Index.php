<?php

namespace App\Http\Livewire\Backend\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $suppliers = Supplier::paginate(10);
        return view('livewire.backend.suppliers.index', compact('suppliers'));
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        $this->alert('success', 'Proveedor eliminado con exito.');
    }
}
