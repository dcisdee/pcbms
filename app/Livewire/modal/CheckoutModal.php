<?php

namespace App\Livewire\Modal;

use App\Models\Sale;
use LivewireUI\Modal\ModalComponent;
use App\Http\Controllers\SaleItemsController;
use Illuminate\Http\Request;

class CheckoutModal extends ModalComponent
{
    public $grand_total = "";
    protected $listeners = ['itemSentToOrder' => 'storeItemToOrder'];

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }

    public function mount($grand_total)
    {
        $this->grand_total = $grand_total;
    }

    public function render()
    {
        return view('livewire.modal.checkout-modal');
    }
}
