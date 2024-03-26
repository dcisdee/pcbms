<?php
namespace App\Livewire\Modal;

use App\Models\Item;
use LivewireUI\Modal\ModalComponent;


class ItemQtyModal extends ModalComponent
{
    // public $item_qty;
    public $item;
    public $data;

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }

    public function mount($id)
    {
        $this->item = Item::findOrFail($id);
    }

    public function sendItemToOrder($item_qty)
    {
        if($item_qty > $this->item->qty)
        {
            $this->addError('item_qty', 'The quantity exceeds available stock.');
            return;
        }elseif($item_qty < 1)
        {
            $this->addError('item_qty', 'Product needs to be atleast 1');
            return;
        }else{
            $this->dispatch('itemSentToOrder', item_id: $this->item->id, item_qty: $item_qty);
            $this->dispatch('closeModal');
        }

    }

    public function render()
    {
        return view('livewire.modal.item-qty-modal');
    }
}
