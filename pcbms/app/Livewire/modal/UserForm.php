<?php

namespace App\Livewire\Modal;

use LivewireUI\Modal\ModalComponent;
use App\Models\Personnel;
use App\Models\User;

class UserForm extends ModalComponent
{
    public $account;
    public $action;
    public $id;
    public $errorMessage;

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }

    public function checkPersonnel($personnelId)
    {
        $personnel = Personnel::findOrFail($personnelId);
        $this->errorMessage = 'Personnel not found';
    }

    public function mount($id=null, $action)
    {
        if ($id) {
            $this->account = User::findOrFail($id);
            $this->id = $this->account->id;
        } else {
            $this->action = route('accounts.store');
        }
    }

    public function render()
    {
        return view('livewire.modal.user-form');
    }
}
