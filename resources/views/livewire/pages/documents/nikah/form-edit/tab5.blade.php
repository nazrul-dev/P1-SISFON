<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
new class extends Component {
    use Actions;
    public $props;
    public $n6 = false;
    public $i_yatim = false;
    public $i_piatu = false;
    public $ia_nama, $ia_binti, $ia_tempat_lahir, $ia_tanggal_lahir, $ia_nik, $ia_status_warganegara, $ia_agama, $ia_alamat, $ia_tipe_bin, $ia_pekerjaan_id;
    public $ii_nama, $ii_binti, $ii_tempat_lahir, $ii_tanggal_lahir, $ii_nik, $ii_status_warganegara, $ii_agama, $ii_alamat, $ii_tipe_binti, $ii_pekerjaan_id;

    public function mount()
    {
        if (isset($this->props)) {
            if (isset($this->props['V'])) {
                foreach ($this->props['V'] as $key => $value) {
                    $this->$key = $value;
                }
            }

            if (isset($this->props['II'])) {
                if (isset($this->props['II']['status_perkawinan'])) {
                    if ($this->props['II']['status_perkawinan'] === 'Duda (Cerai Mati)') {
                        $this->n6 = true;
                    }
                }
            }
        }
    }
    public function back()
    {
        $this->dispatch('back-tab', data: $this->props, tab: 'IV');
    }

    public function updatedIyatim()
    {
        $this->resetErrorBag();
    }

    public function updatedIpiatu()
    {
        $this->resetErrorBag();
    }

    public function save()
    {
        if (!$this->i_yatim && !$this->i_piatu) {
            $validated = $this->validate([
                'i_yatim' => 'required',
                'i_piatu' => 'required',

                'ia_nama' => 'required|min:2',
                'ia_binti' => 'required|min:2',
                'ia_tempat_lahir' => 'required|min:3',
                'ia_tanggal_lahir' => 'required',
                'ia_nik' => 'required|min:3',
                'ia_status_warganegara' => 'required',
                'ia_agama' => 'required',
                'ia_pekerjaan_id' => 'required',

                'ii_nama' => 'required|min:2',
                'ii_binti' => 'required|min:2',
                'ii_tempat_lahir' => 'required|min:3',
                'ii_tanggal_lahir' => 'required',
                'ii_nik' => 'required|min:3',
                'ii_status_warganegara' => 'required',
                'ii_agama' => 'required',
                'ii_pekerjaan_id' => 'required',
            ]);
        } elseif ($this->i_yatim && !$this->i_piatu) {
            $validated = $this->validate([
                'i_yatim' => 'required',
                'i_piatu' => 'required',

                'ii_nama' => 'required|min:2',
                'ii_binti' => 'required|min:2',
                'ii_tempat_lahir' => 'required|min:3',
                'ii_tanggal_lahir' => 'required',
                'ii_nik' => 'required|min:3',
                'ii_status_warganegara' => 'required',
                'ii_agama' => 'required',
                'ii_pekerjaan_id' => 'required',
            ]);
        } elseif (!$this->i_yatim && $this->i_piatu) {
            $validated = $this->validate([
                'i_yatim' => 'required',
                'i_piatu' => 'required',

                'ia_nama' => 'required|min:2',
                'ia_binti' => 'required|min:2',
                'ia_tempat_lahir' => 'required|min:3',
                'ia_tanggal_lahir' => 'required',
                'ia_nik' => 'required|min:3',
                'ia_status_warganegara' => 'required',
                'ia_agama' => 'required',
                'ia_pekerjaan_id' => 'required',
            ]);
        } else {
            $validated = $this->validate([
                'i_yatim' => 'required',
                'i_piatu' => 'required',
                'ia_nama' => 'required|min:2',
                'ii_nama' => 'required|min:2',
            ]);
        }
        $request = [...$validated, 'ia_tipe_bin' => $this->ia_tipe_bin, 'ia_alamat' => $this->ia_alamat, 'ii_tipe_binti' => $this->ii_tipe_binti, 'ii_alamat' => $this->ii_alamat];
        if ($this->n6) {
            $this->dispatch('next-tab', data: $request, tab: 'V', nextTab: 'VI');
        } else {
            $this->dialog()->confirm([
                'title' => 'Apakah Kamu yakin?',
                'description' => 'Sudah menginput data dengan benar ?',
                'acceptLabel' => 'Ya,Saya yakin',
                'method' => 'finish',
                'params' => $request,
            ]);
        }
    }

    public function finish($data)
    {
        $this->dispatch('finish', data: $data);
    }
}; ?>
<x-card title="V. Orang Tua ( Istri )">
    <x-slot name="action">

    </x-slot>

    <div id="top4">
        <div class="grid grid-cols-2 gap-2">
            <div class="flex flex-col gap-2 border-r pr-2">
                <div class="col-span-2 pb-2 text-center font-bold">
                    <div class="border p-2 rounded-lg font-black">
                        AYAH
                    </div>
                </div>
                <x-toggle label="Almarhum" wire:model.live="i_yatim" />
                <x-input label="Nama Lengkap Ayah" wire:model="ia_nama" placeholder="Nama Lengkap Ayah" />


                <div class="grid grid-cols-3">
                    <div class="col-span-2 mr-1">
                        <x-input :disabled="$i_yatim" label="BIN" wire:model="ia_binti" placeholder="Binti Usman" />
                    </div>
                    <x-select :disabled="$i_yatim" label="/" :options="['Alm']" wire:model="ia_tipe_bin" />
                </div>
                <x-input :disabled="$i_yatim" label="Tempat Lahir" wire:model="ia_tempat_lahir" />
                <x-datetime-picker :disabled="$i_yatim" label="Tanggal Lahir" without-time placeholder="Tanggal Lahir"
                    wire:model="ia_tanggal_lahir" />
                <x-input :disabled="$i_yatim" label="NIK" wire:model="ia_nik" placeholder="7504XXXXXXX" />
                <x-select :disabled="$i_yatim" label="Status Kewarganegaraan" placeholder="Pilih salah satu"
                    :options="['WNI', 'WNA']" wire:model="ia_status_warganegara" />
                <x-select :disabled="$i_yatim" label="Agama" placeholder="Pilih salah satu" :options="['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya']"
                    wire:model="ia_agama" />
                <x-select :disabled="$i_yatim" label="Pekerjaan" wire:model="ia_pekerjaan_id"
                    placeholder="pilih salah satu" :async-data="route('select-pekerjaan')" option-label="nama" option-value="id">
                </x-select>

                <div class="col-span-2">

                    <x-textarea :disabled="$i_yatim" label="Alamat" wire:model="ia_alamat" />
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <div class="col-span-2 pb-2 text-center font-bold">
                    <div class="border p-2 rounded-lg font-black">
                        IBU
                    </div>
                </div>
                <x-toggle label="Almarhum" wire:model.live="i_piatu" />
                <x-input label="Nama Lengkap Ayah" wire:model="ii_nama" placeholder="nama Lengkap Ayah" />


                <div class="grid grid-cols-3">
                    <div class="col-span-2 mr-1">
                        <x-input :disabled="$i_piatu" label="BIN" wire:model="ii_binti" placeholder="Binti Usman" />
                    </div>
                    <x-select :disabled="$i_piatu" label="/" :options="['Alm']" wire:model="ii_tipe_binti" />
                </div>
                <x-input :disabled="$i_piatu" label="Tempat Lahir" wire:model="ii_tempat_lahir" />
                <x-datetime-picker :disabled="$i_piatu" label="Tanggal Lahir" without-time placeholder="Tanggal Lahir"
                    wire:model="ii_tanggal_lahir" />
                <x-input type="number" :disabled="$i_piatu" label="NIK" wire:model="ii_nik"
                    placeholder="7504XXXXXXX" />
                <x-select :disabled="$i_piatu" label="Status Kewarganegaraan" placeholder="Pilih salah satu"
                    :options="['WNI', 'WNA']" wire:model="ii_status_warganegara" />
                <x-select :disabled="$i_piatu" label="Agama" placeholder="Pilih salah satu" :options="['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya']"
                    wire:model="ii_agama" />
                <x-select :disabled="$i_piatu" label="Pekerjaan" wire:model="ii_pekerjaan_id"
                    placeholder="pilih salah satu" :async-data="route('select-pekerjaan')" option-label="nama" option-value="id">
                </x-select>

                <div class="col-span-2">

                    <x-textarea label="Alamat" wire:model="ii_alamat" />
                </div>
            </div>


        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-between items-center">
            <x-button secondary label="Kembali" wire:click="back()" flat negative />

            <x-button label="{{ $n6 ? 'Lanjutkan' : 'Simpan' }}" wire:click="save()" primary />


        </div>
    </x-slot>
</x-card>
