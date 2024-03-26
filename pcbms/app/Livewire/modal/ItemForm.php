<?php

namespace App\Livewire\Modal;

use App\Models\Item;
use LivewireUI\Modal\ModalComponent;

class ItemForm extends ModalComponent
{
    public $item;
    public $action;
    public $id;

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function mount($id=null, $action)
    {
        if ($id) {
            $this->item = Item::findOrFail($id);
            $this->id = $this->item->id;
        } else {
            $this->action = route('items.store');
        }
    }

    public function render()
    {
        return view('livewire.modal.item-form');
    }
}
