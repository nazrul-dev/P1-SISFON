<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\{Desa, Village, Datakua};
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
new class extends Component {
    use Actions;

    public $data = [];
    public $form = false;

    public $kua_id,
        $village_id,
        $ids,
        $kepala_desa,
        $n1,
        $n6,
        $kode_pos,
        $logo,
        $active = true;
    public function mount()
    {
        $user = auth()->user();
        if ($user->role_user !== 'superadmin' && ($user->role_user !== 'admin' || $user->tipe_user !== 'kua')) {
            return abort('403', 'Tidak Memiliki Akses');
        }
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
        $data = Desa::find($item['id']);
        $this->ids = $data['id'];
        $this->village_id = $data['village_id'];
        $this->kepala_desa = $data['kepala_desa'];
        $this->n1 = $data['n1'];
        $this->n6 = $data['n6'];
        $this->kua_id = $data['kua_id'];
        $this->kode_pos = $data['kode_pos'];
        $this->logo = $data['logo'] ?? '';
        $this->active = $data['active'] == 1 ? true : false;

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
            'title' => 'Desa Hapus!',
            'description' => ' Desa berhasil dihapus',
            'icon' => 'success',
        ]);
        $this->fetching();
    }

    public function edit()
    {
        $validated = $this->validate([
            'kepala_desa' => 'required|min:3',
            'n1' => 'required|min:3',
            'n6' => 'required|min:3',
            'kode_pos' => 'required|min:2',
            'village_id' => ['required', Rule::unique('desas')->ignore($this->ids)],
        ]);
        $desa = Village::where('code', $this->village_id)->first();
        $location = \Indonesia::findVillage($desa->id, ['province', 'city', 'district', 'district.city', 'district.city.province']);
        $kuaFind = Datakua::where('district_id', $location->district->code)->first();
        if ($kuaFind) {
            $data = Desa::find($this->ids);
            $data->update([...$validated, 'nama_desa' => $location->name, 'kua_id' => $kuaFind, 'district_id' => $location->district->code, 'city_id' => $location->district->city->code, 'province_id' => $location->district->city->province->code, 'active' => $this->active]);

            $this->handleFormReset(true);
            $this->fetching();
            $this->handleForm();
            $this->notification([
                'title' => ' Desa simpan!',
                'description' => ' Desa berhasil disimpan',
                'icon' => 'success',
            ]);
        } else {
            return $this->notification([
                'title' => 'Desa simpan!',
                'description' => ' Tidak ditemukan relasi data antara Kantor Urusan Agama (KUA) dengan desa/kelurahan. Mohon untuk menambahkan data KUA pada Menu <br/><strong>Master -> Data KUA</strong> <br/> sesuai dengan input desa atau kelurahan Anda terlebih dahulu.',
                'icon' => 'error',
            ]);
        }
    }

    public function store()
    {
        $validated = $this->validate([
            'kepala_desa' => 'required|min:3',
            'n1' => 'required|min:3',
            'n6' => 'required|min:3',
            'village_id' => ['required', Rule::unique('desas')],
            'kode_pos' => 'required|min:2',
        ]);
        $desa = Village::where('code', $this->village_id)->first();
        $location = \Indonesia::findVillage($desa->id, ['province', 'city', 'district', 'district.city', 'district.city.province']);
        $kuaFind = Datakua::where('district_id', $location->district->code)->first();
        if ($kuaFind) {
            $data = Desa::create([...$validated, 'kua_id' => $kuaFind->id, 'nama_desa' => $location->name, 'district_id' => $location->district->code, 'city_id' => $location->district->city->code, 'province_id' => $location->district->city->province->code, 'active' => $this->active]);

            $this->handleFormReset(true);
            $this->fetching();
            $this->handleForm();
            $this->notification([
                'title' => 'Desa simpan!',
                'description' => ' Desa berhasil disimpan',
                'icon' => 'success',
            ]);
        } else {
            return $this->notification([
                'title' => 'Desa simpan!',
                'description' => ' Tidak ditemukan relasi data antara Kantor Urusan Agama (KUA) dengan desa/kelurahan. Mohon untuk menambahkan data KUA pada Menu <br/><strong>Master -> Data KUA</strong> <br/> sesuai dengan input desa atau kelurahan Anda terlebih dahulu.',
                'icon' => 'error',
            ]);
        }
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
            $this->reset('ids', 'kepala_desa', 'n1', 'n6', 'kode_pos', 'logo', 'active', 'village_id');
        } else {
            if ($this->ids) {
                $this->reset('kepala_desa', 'n1', 'n6', 'kode_pos', 'logo', 'active', 'village_id');
            } else {
                $this->reset('ids', 'kepala_desa', 'n1', 'n6', 'kode_pos', 'logo', 'active', 'village_id');
            }
        }
    }
}; ?>
<div>

    <x-card>
        <x-slot name="title">
            <div class="capitalize">
                Data Desa
            </div>
        </x-slot>
        <x-slot name="action">
            <button class="rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <x-button.circle wire:click="handleForm()" positive icon="plus" />
            </button>
        </x-slot>
        <div>

            <livewire:datatables.desa-table />


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

                <x-select label="Desa/Kelurahan" wire:model="village_id" placeholder="Desa/Kelurahan" :async-data="route('get-village')"
                    option-label="name" option-value="code">
                </x-select>

                <x-input wire:model="kepala_desa" label="Nama Kepala Desa" placeholder="Nama Kepala Desa" />
                <x-input wire:model="n1" label="N1" placeholder="N1" />
                <x-input wire:model="n6" label="N6" placeholder="N6" />

                <x-input wire:model="kode_pos" label="Kode POS" placeholder="Kode POS" />


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
