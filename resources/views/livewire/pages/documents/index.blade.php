<?php

use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component
{
    use Actions, WithPagination;
    public string $tab = 'nikah';

    public function mount(Request $request)
    {
        if ($request->tab) {
            $this->tab = $request->tab;
        }
    }
    public function changeTab($tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }
}; ?>


<div class="container mx-auto">
    <div class="flex flex-col gap-2">

        <div>
            <x-button wire:click="changeTab('nikah')" :secondary="$tab !== 'nikah'" :positive="$tab === 'nikah'" label="Nikah" />
            <x-button wire:click="changeTab('n6')" :secondary="$tab !== 'n6'" :positive="$tab === 'n6'" label="N6" />
        </div>
        @if ($tab === 'nikah')
            <livewire:pages.documents.nikah.index />
        @elseif($tab === 'n6')
            <livewire:pages.documents.n6.index />
        @endif

    </div>

</div>
