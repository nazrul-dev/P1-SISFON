<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\{AparaturDesa};
use WireUi\Traits\Actions;
use Livewire\Attributes\On;
new class extends Component {
    use Actions;

    public $data = [];
    public $form = false;

    public $ids, $nip, $nama, $jabatan_id, $desa_id;

    public function mount()
    {
        $user = auth()->user();
        if ($user->role_user !== 'superadmin') {
            return abort('404');
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
        $data = AparaturDesa::find($item['id']);
        $this->ids = $data['id'];
        $this->nama = $data['nama'];
        $this->jabatan_id = $data['jabatan_id'];
        $this->nip = $data['nip'];
        $this->desa_id = $data['desa_id'];

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
        $this->data = AparaturDesa::find($id)->delete();
        $this->notification([
            'title' => 'Data Aparatur Desa Hapus!',
            'description' => ' Data Aparatur Desa berhasil dihapus',
            'icon' => 'success',
        ]);
        $this->fetching();
    }

    public function edit()
    {
        $validated = $this->validate([
            'nama' => 'required|min:3',
            'jabatan_id' => 'required',
            'desa_id' => 'required',
        ]);

        $data = AparaturDesa::find($this->ids);

        $data->update([...$validated, 'nip' => $this->nip]);

        $this->handleFormReset(true);

        $this->fetching();
        $this->handleForm();
        $this->notification([
            'title' => ' Data Aparatur Desa  simpan!',
            'description' => ' Data Aparatur Desa  berhasil disimpan',
            'icon' => 'success',
        ]);
    }

    public function store()
    {
        $validated = $this->validate([
            'nama' => 'required|min:3',
            'jabatan_id' => 'required',
            'desa_id' => 'required',
        ]);

        $this->data = AparaturDesa::create([...$validated, 'nip' => $this->nip]);
        $this->handleFormReset(true);

        $this->fetching();
        $this->handleForm();
        $this->notification([
            'title' => 'Aparatur Desa  simpan!',
            'description' => ' Aparatur Desa  berhasil disimpan',
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

    public function handleFormReset($all = false)
    {
        if ($all) {
            $this->reset('ids', 'nama', 'desa_id', 'nip', 'jabatan_id');
        } else {
            if ($this->ids) {
                $this->reset('nama', 'desa_id', 'nip', 'jabatan_id');
            } else {
                $this->reset('ids', 'nama', 'desa_id', 'nip', 'jabatan_id');
            }
        }
    }
}; ?>
<div>

    <x-card>
        <x-slot name="title">
            <div class="capitalize">
                Data Aparatur Desa
            </div>
        </x-slot>
        <x-slot name="action">
            <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <x-button.circle wire:click="handleForm()" positive icon="plus" />
            </button>
        </x-slot>
        <div>

            <livewire:datatables.aparatur-desa-table />


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


                <x-select label="Desa / Kelurahan ( Terdaftar )" wire:model="desa_id" placeholder="Pilih Kelurahan" :async-data="route('select-datadesa')"
                    option-label="nama_desa" option-value="id">
                </x-select>


                <x-select label="Jabatan" placeholder="pilih jabatan" wire:model="jabatan_id" :async-data="route('select-jabatan', ['tipe_jabatan' => 'Desa'])"
                    option-label="nama" option-value="id">
                </x-select>
                <x-input wire:model="nama" label="Nama Bersangkutan" placeholder="Nama" />
                <x-input wire:model="nip" label="NIP" placeholder="NIP" />


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
