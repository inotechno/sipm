<?php

namespace App\Livewire\Component\Widget;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class CardMini extends Component
{
    #[Reactive]
    public $title;

    #[Reactive]
    public $value;

    public $clickToOpenModal;

    #[Reactive]
    public $data;

    protected $listeners = ['refreshCard' => 'refreshCard'];


    public function mount($title, $value, $clickToOpenModal, $data)
    {
        $this->title = $title;
        $this->value = $value;
        $this->clickToOpenModal = $clickToOpenModal;
        $this->data = $data;
    }

    public function openModal()
    {
        $this->dispatch('open-modal', modal_id: $this->clickToOpenModal, modal_title: $this->title, data: $this->data);
    }

    public function render()
    {
        return view('livewire.component.widget.card-mini');
    }
}
