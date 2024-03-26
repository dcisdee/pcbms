<?php
namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;

class PosOrderTable extends Component
{
    public $item;
    public $items = [];

    protected $listeners = ['itemSentToOrder' => 'storeItemToOrder'];

    public function storeItemToOrder($item_id, $item_qty)
    {
        $item = Item::findOrFail($item_id);
        // $this->js('alert('.$item->barcode.')');
        $existing = array_search($item_id, array_column($this->items, 'id'));

        if ($existing !== false) {
            $this->items[$existing]['item_qty'] += $item_qty;
            $this->items[$existing]['total_price'] = $this->items[$existing]['selling_unit_price'] * $this->items[$existing]['item_qty'];
        } else {
            $this->items[] = [
                'id' => $item->id,
                'barcode' => $item->barcode,
                'product_name' => $item->product_name,
                'selling_unit_price' => $item->selling_unit_price,
                'item_qty' => $item_qty,
                'total_price' => $item->selling_unit_price * $item_qty,
            ];
        }
        $this->grandTotal();
    }

    public function deleteItemFromOrder($id){
        foreach ($this->items as $key => $item) {
            if ($item['id'] === $id) {
                unset($this->items[$key]);
                break;
            }
        }
        $this->grandTotal();
    }

    public function grandTotal(){
        $grandTotal =  collect($this->items)->sum('total_price');
        // $this->dispatch('sendGrandTotal', item_id: $grandTotal);
        $this->dispatch('sendGrandTotal', $grandTotal);
        // $this->js('alert('.$grandTotal.')');
    }
    public function render()
    {
        return view('livewire.pos-order-table', [
            'items' => Item::all()
        ]);
    }
}
