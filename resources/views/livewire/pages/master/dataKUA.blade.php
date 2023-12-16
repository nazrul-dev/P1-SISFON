<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\{Datakua};
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\Attributes\On;
new class extends Component {
    use Actions, WithPagination;

    public $data = [];
    public $form = false;

    public $paginate = 0,
        $district_id,
        $term,
        $ids,
        $nip,
        $nama_kepala_kua,
        $alamat_kua,
        $logo;

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
        $data = Datakua::find($item['id']);
        $this->ids = $data['id'];
        $this->district_id = $data['district_id'];
        $this->nama_kepala_kua = $data['nama_kepala_kua'];
        $this->alamat_kua = $data['alamat_kua'];
        $this->nip = $data['nip'];
        $this->logo = $data['logo'] ?? '';

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
        $this->data = Datakua::find($id)->delete();
        $this->notification([
            'title' => 'Data KUA Hapus!',
            'description' => ' Data KUA berhasil dihapus',
            'icon' => 'success',
        ]);
        $this->fetching();
    }

    public function edit()
    {
        $validated = $this->validate([
            'nama_kepala_kua' => 'required|min:3',
            'district_id' => 'required',
        ]);
        $location = \Indonesia::findDistrict($this->district_id, ['province', 'city', 'city.province']);
        $data = Datakua::find($this->ids);

        $data->update([...$validated, 'nip' => $this->nip, 'alamat_kua' => $this->alamat_kua, 'nama_kecamatan' => $location->name, 'city_id' => $location->city->code, 'province_id' => $location->city->province->code]);

        $this->reset('ids', 'nama_kepala_kua', 'alamat_kua', 'nip', 'logo', 'district_id');

        $this->fetching();
        $this->handleForm();
        $this->notification([
            'title' => ' Data KUA simpan!',
            'description' => ' Data KUA berhasil disimpan',
            'icon' => 'success',
        ]);
    }

    public function store()
    {
        $validated = $this->validate([
            'nama_kepala_kua' => 'required|min:3',
            'district_id' => 'required',
        ]);
        $location = \Indonesia::findDistrict($this->district_id, ['province', 'city', 'city.province']);

        $this->data = Datakua::create([...$validated, 'nip' => $this->nip, 'alamat_kua' => $this->alamat_kua, 'nama_kecamatan' => $location->name, 'city_id' => $location->city->code, 'province_id' => $location->city->province->code]);
        $this->reset('ids', 'nama_kepala_kua', 'alamat_kua', 'nip', 'logo', 'district_id');

        $this->fetching();
        $this->handleForm();
        $this->notification([
            'title' => 'Data KUA simpan!',
            'description' => ' Data KUA berhasil disimpan',
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
                Data KUA
            </div>
        </x-slot>
        <x-slot name="action">
            <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <x-button.circle wire:click="handleForm()" positive icon="plus" />
            </button>
        </x-slot>
        <div>

            <livewire:datatables.datakua-table />


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


                <x-select label="Kecamatan" wire:model="district_id" placeholder="Kecamatan" :async-data="route('get-district')"
                    option-label="name" option-value="id">
                </x-select>

                <x-input wire:model="nama_kepala_kua" label="Nama Kepala KUA" placeholder="Nama Kepala KUA" />
                <x-input wire:model="nip" label="NIP" placeholder="NIP" />
                <x-textarea wire:model="alamat_kua" label="Alamat KUA" placeholder="Alamat KUA" />

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
