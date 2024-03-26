<?php

namespace App\Livewire\Modal;

use App\Models\Personnel;
use LivewireUI\Modal\ModalComponent;

class PersonnelForm extends ModalComponent
{
    public $personnel;
    public $action;
    public $id;

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function mount($id=null, $action)
    {
        if ($id) {
            $this->personnel = Personnel::findOrFail($id);
            $this->id = $this->personnel->id;
        } else {
            $this->action = route('personnels.store');
        }
    }

    public function render()
    {
        return view('livewire.modal.personnel-form');
    }
}
