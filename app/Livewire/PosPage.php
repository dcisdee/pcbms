<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\View;
use App\Models\Order;

class PosPage extends Component
{
    public $order_id;
    public $grandTotal = "0";

    protected $listeners = ['sendGrandTotal' => 'showGrandTotal'];

    public function showGrandTotal($grandTotal)
    {
        $this->grandTotal = $grandTotal;
    }

    public function resetForm()
    {
        $this->reset();
    }

    public function render()
    {
        $form_data = [
            'transaction_status' => 'successful',
        ];

        return view('livewire.pos-page',['form_data' => $form_data])
        // ->extends('layouts.app');
        ->layout(\App\View\Components\AppLayout::class);
    }
}
