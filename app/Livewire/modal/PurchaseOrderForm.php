<?php

namespace App\Livewire\Modal;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use LivewireUI\Modal\ModalComponent;

class PurchaseOrderForm extends ModalComponent
{
    public $purchase_order;
    public $suppliers;
    public $grandTotal;
    public $action;
    public $id;
    public $count = 0;
    public $items = [];
    public $purchase_items;

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function mount($id=null, $action)
    {
        $this->suppliers = Supplier::all();
        if ($id) {
            $this->purchase_order = PurchaseOrder::findOrFail($id);
            $this->id = $this->purchase_order->id;
            $this->purchase_items = $this->purchase_order->purchase_items;

            $this->grandTotal = 0;

            foreach ($this->purchase_items as $item) {
                $this->grandTotal += $item->total;
            }

        } else {
            $this->action = route('purchase_orders.store');
        }
    }

    public function addItem()
    {
        $this->count++;
        $this->items[] = $this->count;
    }

    public function render()
    {
        return view('livewire.modal.purchase-order-form');
    }
}
