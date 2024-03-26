<?php

namespace App\Livewire\Modal;

use LivewireUI\Modal\ModalComponent;
use App\Models\Supplier;

class SupplierForm extends ModalComponent
{
    public $supplier;
    public $action;
    public $id;

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }

    public function mount($id=null, $action)
    {
        if ($id) {
            $this->supplier = Supplier::findOrFail($id);
            $this->id = $this->supplier->id;
        } else {
            $this->action = route('suppliers.store');
        }
    }

    public function render()
    {
        return view('livewire.modal.supplier-form');
    }
}
