<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;

class PosItemTable extends Component
{
    public $search = '';
    public $sortDirection = 'ASC';
    public $sortColumn = 'barcode';

    public function doSort($column){
        if($this->sortColumn == $column){
            $this->sortDirection = $this->sortDirection ? 'DESC' : 'ASC';
            return;
        }
        $this->sortColumn = $column;
    }

    public function render()
    {
        return view('livewire.pos-item-table', [
            'items' => Item::search($this->search)
                    ->orderBy($this->sortColumn, $this->sortDirection)
                    ->paginate(10)
        ]);
    }
}
