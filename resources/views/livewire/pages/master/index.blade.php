<?php

use Illuminate\Support\Facades\Auth;

use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component
{
    use Actions, WithPagination;
    public string $tab = 'pekerjaan';

    public function changeTab($tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }
}; ?>


<div class="container mx-auto">
    <div class="flex flex-col gap-2">

        <div>
            <x-button wire:click="changeTab('pekerjaan')" :secondary="$tab !== 'pekerjaan'" :positive="$tab === 'pekerjaan'" label="Pekerjaan" />
            <x-button wire:click="changeTab('jabatan')" :secondary="$tab !== 'jabatan'" :positive="$tab === 'jabatan'" label="Jabatan" />
            <x-button wire:click="changeTab('desa')" :secondary="$tab !== 'desa'" :positive="$tab === 'desa'" label="Desa" />
            <x-button wire:click="changeTab('Aparatur Desa')" :secondary="$tab !== 'Aparatur Desa'" :positive="$tab === 'Aparatur Desa'"
                label="Aparatur Desa" />
            <x-button wire:click="changeTab('data KUA')" :secondary="$tab !== 'data KUA'" :positive="$tab === 'data KUA'" label="Data KUA" />
        </div>
        @if ($tab === 'pekerjaan')
            <livewire:pages.master.pekerjaan />
        @elseif ($tab === 'jabatan')
            <livewire:pages.master.jabatan />
        @elseif ($tab === 'desa')
            <livewire:pages.master.desa />
        @elseif ($tab === 'data KUA')
            <livewire:pages.master.datakua />
        @elseif ($tab === 'Aparatur Desa')
            <livewire:pages.master.aparatur />
        @endif

    </div>

</div>
