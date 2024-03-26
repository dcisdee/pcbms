<?php

namespace App\Livewire\Modal;

use App\Models\Sale;
use App\Models\SaleItems;
use App\Models\Item;
use LivewireUI\Modal\ModalComponent;

class SaleForm extends ModalComponent
{
    public $sale;
    public $sale_items;
    public $item;
    public $action;
    public $id;

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function mount($id=null)
    {
        if ($id) {
            $this->sale = Sale::findOrFail($id);
            $this->id = $this->sale->id;
        }
    }

    public function render()
    {
        return view('livewire.modal.sale-form');
    }

    public function getItems($id)
    {
        $this->item = Item::findOrFail($this->sale->item_id);
    }
}
