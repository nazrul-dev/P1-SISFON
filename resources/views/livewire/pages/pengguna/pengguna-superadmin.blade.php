<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\{User};
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\Attributes\On;
new class extends Component {
    use Actions, WithPagination;

    public $data = [];
    public $form = false;

    public $ids, $name, $email, $password, $nip, $telepon;

    public function updatedTerm()
    {
        $this->fetching();
    }

    public function handleForm(): void
    {
        $this->form = !$this->form;
        $this->resetErrorBag();
    }

    public function fetching()
    {
        $this->dispatch('refreshDatatable');
        $this->dispatch('clearFilters');
        $this->dispatch('clearSorts');
    }

    #[On('handlerEdit')]
    public function handlerEdit($row)
    {
        $item = json_decode($row, true);
        $user = User::find($item['id']);
        $this->ids = $item['id'];
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nip = $user->nip;
        $this->telepon = $user->telepon;

        $this->handleForm();
    }

    public function handlerRemove($id): void
    {
        $this->dialog()->confirm([
            'title' => 'Apakah anda yakin?',
            'description' => 'Menghapus data ini?',
            'acceptLabel' => 'Ya, saya yakin',
            'method' => 'destroy',
            'params' => $id,
        ]);
    }

    public function destroy($id)
    {
        $this->data = User::find($id)->delete();
        $this->notification([
            'title' => 'User Hapus!',
            'description' => ' User berhasil dihapus',
            'icon' => 'success',
        ]);
        $this->fetching();
    }

    public function edit()
    {
        $validated = $this->validate([
            'name' => 'required|min:3',

            'email' => 'required|email',
        ]);
        $data = User::find($this->ids);
        $req = [...$validated, 'nip' => $this->nip, 'telepon' => $this->telepon];
        if ($this->password) {
            $data->update([...$req, 'password' => $this->password]);
        } else {
            $data->update($req);
        }

        $this->handleFormReset();
        $this->fetching();
        $this->handleForm();
        $this->notification([
            'title' => ' User simpan!',
            'description' => ' User berhasil disimpan',
            'icon' => 'success',
        ]);
    }

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|min:3',

            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
        $this->data = User::create([...$validated, 'role_user' => 'superadmin', 'nip' => $this->nip, 'telepon' => $this->telepon]);
        $this->handleFormReset();

        $this->fetching();
        $this->handleForm();
        $this->notification([
            'title' => 'User simpan!',
            'description' => ' User berhasil disimpan',
            'icon' => 'success',
        ]);
    }

    public function handleFormReset()
    {
        $this->reset('ids', 'name', 'email', 'password', 'nip', 'telepon');
    }

    public function save()
    {
        if ($this->ids) {
            $this->edit();
        } else {
            $this->store();
        }
    }

    public function updatedPaginate()
    {
        $this->fetching();
    }
}; ?>


<div>

    <x-card>
        <x-slot name="title">
            <div class="capitalize">
                Data Pengguna SUPERADMIN
            </div>
        </x-slot>
        <x-slot name="action">
            <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <x-button.circle wire:click="handleForm()" positive icon="plus" />
            </button>
        </x-slot>
        <div>

            <livewire:datatables.user-table tipe="superadmin" />


        </div>
    </x-card>
    @if ($form)
        <div class="fixed inset-0 end-0 w-full bg-black bg-opacity-60 z-0 backdrop-blur ">

        </div>
        <div class="fixed   inset-0 end-0 w-96 bg-white z-10  ml-auto">
            <div class="px-5 py-2 border-b capitalize font-semibold">
                {{ $ids ? 'Edit' : 'Tambah' }}
            </div>
            <div class="p-5 pb-32 space-y-2 overflow-y-auto h-screen soft-scrollbar">

                <x-input wire:model="name" label="Nama " placeholder="Nama " />
                <x-input type="number" wire:model="nip" label="NIP" placeholder="Nomor Telepon" />
                <x-input type="number" wire:model="telepon" label="Nomor Telepon" placeholder="Nomor Telepon" />
                <x-input wire:model="email" label="Email" placeholder="Email" />
                <x-inputs.password wire:model="password" label="Password" />

            </div>
            <div class="bg-gray-200 sticky bottom-0 p-2">
                <div class="flex justify-between items-center">
                    <x-button wire:click="handleForm()" secondary icon="reply" />
                    <div class="flex gap-2">
                        @if ($ids)
                            <x-button wire:click="handlerRemove({{ $ids }})" negative icon="trash" />

                        @else
                            <x-button wire:click="handleFormReset()" positive icon="refresh" />
                        @endif
                        <x-button wire:click="save()" positive icon="clipboard-check" />
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
