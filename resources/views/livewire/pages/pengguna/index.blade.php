<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component
{
    use Actions, WithPagination;
    public string $tab = 'pengguna-desa';
    public function mount()
    {
        $user = auth()->user();
        if ($user->role_user !== 'admin' && $user->tipe_user !== 'desa' && $user->role_user !== 'superadmin') {
            return abort('404');
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
            @if (auth()->user()->role_user === 'admin' || auth()->user()->role_user === 'superadmin')
                <x-button wire:click="changeTab('pengguna-desa')" :secondary="$tab !== 'pengguna-desa'" :positive="$tab === 'pengguna-desa'"
                    label="Pengguna DESA" />
                @if (auth()->user()->role_user === 'kua' || auth()->user()->role_user === 'superadmin')
                    <x-button wire:click="changeTab('pengguna-kua')" :secondary="$tab !== 'pengguna-kua'" :positive="$tab === 'pengguna-kua'"
                        label="Pengguna  KUA" />
                @endif

            @endif

            @if (auth()->user()->role_user === 'superadmin')
                <x-button wire:click="changeTab('superadmin')" :secondary="$tab !== 'superadmin'" :positive="$tab === 'superadmin'"
                    label="Pengguna SUPER ADMIN" />
            @endif

        </div>
        @if (
            $tab === 'pengguna-kua' &&
                (auth()->user()->role_user === 'superadmin' ||
                    (auth()->user()->role_user === 'admin' && auth()->user()->role_user === 'kua')))
            <livewire:pages.pengguna.pengguna-kua />
        @elseif ($tab === 'pengguna-desa' && (auth()->user()->role_user === 'superadmin' || auth()->user()->role_user === 'admin'))
            <livewire:pages.pengguna.pengguna-desa />
        @elseif ($tab === 'superadmin' && auth()->user()->role_user === 'superadmin')
            <livewire:pages.pengguna.pengguna-superadmin />
        @endif

    </div>

</div>
