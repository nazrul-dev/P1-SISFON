<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\Attributes\On;

new class extends Component {
    use Actions, WithPagination;

    public function handleForm()
    {
        return $this->redirect(route('document.n6.add'), navigate: false);
    }

     #[On('handlerPrint')]
     public function handlerPrint($id)
    {
        $url = app('DataN6Printer')->run($id);
        $filename = pathinfo($url, PATHINFO_FILENAME);
        $filename = basename($url);
        $this->dispatch('downloadZip', url: $filename);
    }
}; ?>

<div>
    <x-card>
        <x-slot name="title">
            <div class="capitalize">
                Data N6
            </div>
        </x-slot>
        <x-slot name="action">
            <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <x-button.circle wire:click="handleForm()" positive icon="plus" />
            </button>
        </x-slot>
        <div>

            <livewire:datatables.document-nsix-table />


        </div>
    </x-card>



</div>
