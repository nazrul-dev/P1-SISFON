<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\{Pekerjaan};
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\Attributes\On;
new class extends Component {
    use Actions, WithPagination;

    public $data = [];
    public $form = false;

    public $paginate = 0,
        $term,
        $ids,
        $nama;
    public function mount()
    {
        $user = auth()->user();
        if ($user->role_user !== 'superadmin' && $user->role_user !== 'admin') {
            return abort('403', 'Tidak Memiliki Akses');
        }
    }
    public function updatedTerm()
    {
        $this->fetching();
    }

    public function handleForm(): void
    {
        $this->form = !$this->form;
        $this->resetErrorBag();
    }

    public function boot()
    {
        $this->fetching();
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
        $this->ids = $item['id'];
        $this->nama = $item['nama'];
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
        $this->data = Pekerjaan::find($id)->delete();
        $this->notification([
            'title' => 'Pekerjaan Hapus!',
            'description' => ' Pekerjaan berhasil dihapus',
            'icon' => 'success',
        ]);
        $this->fetching();
    }

    public function edit()
    {
        $validated = $this->validate([
            'nama' => 'required|min:3',
        ]);
        $data = Pekerjaan::find($this->ids);
        $data->update($validated);
        $this->reset('nama', 'ids');

        $this->fetching();
        $this->handleForm();
        $this->notification([
            'title' => ' Pekerjaan simpan!',
            'description' => ' Pekerjaan berhasil disimpan',
            'icon' => 'success',
        ]);
    }

    public function store()
    {
        $validated = $this->validate([
            'nama' => 'required|min:3',
        ]);
        $this->data = Pekerjaan::create($validated);
        $this->reset('nama');

        $this->fetching();
        $this->handleForm();
        $this->notification([
            'title' => 'Pekerjaan simpan!',
            'description' => ' Pekerjaan berhasil disimpan',
            'icon' => 'success',
        ]);
    }

    public function save()
    {
        if ($this->ids) {
            $this->edit();
        } else {
            $this->store();
        }
    }

    public function handlerPaginate($operator)
    {
        if ($operator === '-') {
            $this->paginate -= 1;
        } else {
            $this->paginate += 1;
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
                Data Pekerjaan
            </div>
        </x-slot>
        <x-slot name="action">
            <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <x-button.circle wire:click="handleForm()" positive icon="plus" />
            </button>
        </x-slot>
        <div>

            <livewire:datatables.pekerjaan-table />


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
                <x-input wire:model="nama" label="Nama Pekerjaan" placeholder="Nama Pekerjaan" />


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
