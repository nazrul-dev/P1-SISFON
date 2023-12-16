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
    public $desa_select = true;
    public $ids, $name, $role_user, $email, $password, $nip, $telepon, $jabatan_id, $desa_id;

    public function updatedTerm()
    {
        $this->fetching();
    }

    public function mount()
    {
        $user = auth()->user();
        if ($user->role_user !== 'admin' && $user->role_user !== 'superadmin') {
            return abort('404');
        }

        if ($user->tipe_user === 'desa'  && $user->role_user !== 'superadmin' ) {
            $this->desa_id = $user->desa_id;
            $this->desa_select = false;
        }
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
        $this->jabatan_id = $user->jabatan_id;
        $this->role_user = $user->role_user;
        $this->desa_id = $user->desa_id;
        $this->handleForm();
    }

    public function resetPassword($id): void
    {
        $this->dialog()->confirm([
            'title' => 'Apakah anda yakin?',
            'description' => 'Mereset Password User?',
            'acceptLabel' => 'Ya, saya yakin',
            'method' => 'resettingpass',
            'params' => $id,
        ]);
    }

    public function resettingpass($id)
    {
        function quickRandom($length = 16)
        {
            $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
        }

        $randomPass = quickRandom(6);
        $this->data = User::find($id)->update(['password' => Hash::make($randomPass)]);
        $this->notification([
            'title' => 'User Reset Password Berhasil !',
            'description' => 'Password baru user ini adalah <b>' . $randomPass . '</b>',
            'icon' => 'success',
        ]);
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
            'desa_id' => 'required',
            'email' => 'required|email',
            'role_user' => 'required',
        ]);
        $data = User::find($this->ids);
        $data->update([...$validated, 'jabatan_id' => $this->jabatan_id, 'nip' => $this->nip, 'telepon' => $this->telepon]);
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
            'desa_id' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
            'role_user' => 'required',
        ]);
        $this->data = User::create([...$validated, 'password' => Hash::make($this->password), 'tipe_user' => 'desa', 'jabatan_id' => $this->jabatan_id, 'nip' => $this->nip, 'telepon' => $this->telepon]);
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
        $this->reset('ids', 'name', 'email', 'password', 'nip', 'telepon', 'jabatan_id', 'desa_id');
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
                Data Pengguna DESA
            </div>
        </x-slot>
        <x-slot name="action">
            <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <x-button.circle wire:click="handleForm()" positive icon="plus" />
            </button>
        </x-slot>
        <div>

            <livewire:datatables.user-table tipe="desa" />


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
                <x-select :disabled="!$desa_select" label="Desa" wire:model="desa_id" placeholder="Desa " :async-data="route('select-datadesa')"
                    option-label="nama_desa" option-value="id">
                </x-select>
                <x-input wire:model="name" label="Nama " placeholder="Nama " />
                <x-select label="Jabatan" wire:model="jabatan_id" :async-data="route('select-jabatan')" option-label="nama"
                    option-value="id">
                </x-select>
                <x-select label="Hak Akses" placeholder="Pilih salah satu" :options="['admin', 'operator']" wire:model="role_user" />
                <x-input type="number" wire:model="nip" label="NIP" placeholder="Nomor Telepon" />
                <x-input type="number" wire:model="telepon" label="Nomor Telepon" placeholder="Nomor Telepon" />
                <x-input wire:model="email" label="Email" placeholder="Email" />
                @if (!isset($ids))
                    <x-inputs.password wire:model="password" label="Password" />
                @endif


            </div>
            <div class="bg-gray-200 sticky bottom-0 p-2">
                <div class="flex justify-between items-center">
                    <x-button wire:click="handleForm()" secondary icon="reply" />
                    <div class="flex gap-2">
                        @if ($ids)
                            <x-button wire:click="handlerRemove({{ $ids }})" negative icon="trash" />
                            <x-button warning wire:click="resetPassword({{ $ids }})" icon="key" />
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
