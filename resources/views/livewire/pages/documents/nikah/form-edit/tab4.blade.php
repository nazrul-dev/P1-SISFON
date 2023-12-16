<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public $props;
    public $s_yatim = false;
    public $s_piatu = false;

    public $sa_nama, $sa_binti, $sa_tempat_lahir, $sa_tanggal_lahir, $sa_nik, $sa_status_warganegara, $sa_agama, $sa_alamat, $sa_tipe_bin, $sa_pekerjaan_id;
    public $si_nama, $si_binti, $si_tempat_lahir, $si_tanggal_lahir, $si_nik, $si_status_warganegara, $si_agama, $si_alamat, $si_tipe_bin, $si_pekerjaan_id;

    public function mount()
    {
        if (isset($this->props)) {
            if (isset($this->props['IV'])) {
                foreach ($this->props['IV'] as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
    }
    public function back()
    {
        $this->dispatch('back-tab', data: $this->props, tab: 'III');
    }

    public function updatedSyatim()
    {
        $this->resetErrorBag();
    }

    public function updatedSpiatu()
    {
        $this->resetErrorBag();
    }
    public function save()
    {
        if (!$this->s_yatim && !$this->s_piatu) {
            $validated = $this->validate([
                's_yatim' => 'required',
                's_piatu' => 'required',

                'sa_nama' => 'required|min:2',
                'sa_binti' => 'required|min:2',
                'sa_tempat_lahir' => 'required|min:3',
                'sa_tanggal_lahir' => 'required',
                'sa_nik' => 'required|min:3',
                'sa_status_warganegara' => 'required',
                'sa_agama' => 'required',
                'sa_pekerjaan_id' => 'required',

                'si_nama' => 'required|min:2',
                'si_binti' => 'required|min:2',
                'si_tempat_lahir' => 'required|min:3',
                'si_tanggal_lahir' => 'required',
                'si_nik' => 'required|min:3',
                'si_status_warganegara' => 'required',
                'si_agama' => 'required',
                'si_pekerjaan_id' => 'required',
            ]);
        } elseif ($this->s_yatim && !$this->s_piatu) {
            $validated = $this->validate([
                's_yatim' => 'required',
                's_piatu' => 'required',

                'si_nama' => 'required|min:2',
                'si_binti' => 'required|min:2',
                'si_tempat_lahir' => 'required|min:3',
                'si_tanggal_lahir' => 'required',
                'si_nik' => 'required|min:3',
                'si_status_warganegara' => 'required',
                'si_agama' => 'required',
                'si_pekerjaan_id' => 'required',
            ]);
        } elseif (!$this->s_yatim && $this->s_piatu) {
            $validated = $this->validate([
                's_yatim' => 'required',
                's_piatu' => 'required',

                'sa_nama' => 'required|min:2',
                'sa_binti' => 'required|min:2',
                'sa_tempat_lahir' => 'required|min:3',
                'sa_tanggal_lahir' => 'required',
                'sa_nik' => 'required|min:3',
                'sa_status_warganegara' => 'required',
                'sa_agama' => 'required',
                'sa_pekerjaan_id' => 'required',
            ]);
        } else {
            $validated = $this->validate([
                's_yatim' => 'required',
                's_piatu' => 'required',
                'sa_nama' => 'required|min:2',
                'si_nama' => 'required|min:2',
            ]);
        }

        $request = [...$validated,  'sa_tipe_bin' => $this->sa_tipe_bin, 'sa_alamat' => $this->sa_alamat, 'si_tipe_bin' => $this->si_tipe_bin, 'si_alamat' => $this->si_alamat];
        $this->dispatch('next-tab', data: $request, tab: 'IV', nextTab: 'V');
    }
}; ?>
<x-card title="IV. Orang Tua ( Suami )">
    <x-slot name="action">

    </x-slot>

    <div id="top3">
        <div class="grid grid-cols-2 gap-2">
            <div class="flex flex-col gap-2 border-r pr-2">
                <div class="col-span-2 pb-2 text-center font-bold">
                    <div class="border p-2 rounded-lg font-black">
                        AYAH
                    </div>
                </div>
                <x-toggle label="Almarhum" wire:model.live="s_yatim" />
                <x-input label="Nama Lengkap Ayah" wire:model="sa_nama" placeholder="Nama Lengkap Ayah" />


                <div class="grid grid-cols-3">
                    <div class="col-span-2 mr-1">
                        <x-input :disabled="$s_yatim" label="BIN" wire:model="sa_binti" placeholder="Binti Usman" />
                    </div>
                    <x-select :disabled="$s_yatim" label="/" :options="['Alm']" wire:model="sa_tipe_bin" />
                </div>
                <x-input :disabled="$s_yatim" label="Tempat Lahir" wire:model="sa_tempat_lahir" />
                <x-datetime-picker :disabled="$s_yatim" label="Tanggal Lahir" without-time placeholder="Tanggal Lahir"
                    wire:model="sa_tanggal_lahir" />
                <x-input :disabled="$s_yatim" label="NIK" wire:model="sa_nik" placeholder="7504XXXXXXX" />
                <x-select :disabled="$s_yatim" label="Status Kewarganegaraan" placeholder="Pilih salah satu"
                    :options="['WNI', 'WNA']" wire:model="sa_status_warganegara" />
                <x-select :disabled="$s_yatim" label="Agama" placeholder="Pilih salah satu" :options="['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya']"
                    wire:model="sa_agama" />
                <x-select :disabled="$s_yatim" label="Pekerjaan" wire:model="sa_pekerjaan_id"
                    placeholder="pilih salah satu" :async-data="route('select-pekerjaan')" option-label="nama" option-value="id">
                </x-select>

                <div class="col-span-2">

                    <x-textarea :disabled="$s_yatim" label="Alamat" wire:model="sa_alamat" />
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <div class="col-span-2 pb-2 text-center font-bold">
                    <div class="border p-2 rounded-lg font-black">
                        IBU
                    </div>
                </div>
                <x-toggle label="Almarhum" wire:model.live="s_piatu" />
                <x-input label="Nama Lengkap Ayah" wire:model="si_nama" placeholder="nama Lengkap Ayah" />


                <div class="grid grid-cols-3">
                    <div class="col-span-2 mr-1">
                        <x-input :disabled="$s_piatu" label="BIN" wire:model="si_binti" placeholder="Binti Usman" />
                    </div>
                    <x-select :disabled="$s_piatu" label="/" :options="['Alm']" wire:model="si_tipe_bin" />
                </div>
                <x-input :disabled="$s_piatu" label="Tempat Lahir" wire:model="si_tempat_lahir" />
                <x-datetime-picker :disabled="$s_piatu" label="Tanggal Lahir" without-time placeholder="Tanggal Lahir"
                    wire:model="si_tanggal_lahir" />
                <x-input type="number" :disabled="$s_piatu" label="NIK" wire:model="si_nik"
                    placeholder="7504XXXXXXX" />
                <x-select :disabled="$s_piatu" label="Status Kewarganegaraan" placeholder="Pilih salah satu"
                    :options="['WNI', 'WNA']" wire:model="si_status_warganegara" />
                <x-select :disabled="$s_piatu" label="Agama" placeholder="Pilih salah satu" :options="['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya']"
                    wire:model="si_agama" />
                <x-select :disabled="$s_piatu" label="Pekerjaan" wire:model="si_pekerjaan_id"
                    placeholder="pilih salah satu" :async-data="route('select-pekerjaan')" option-label="nama" option-value="id">
                </x-select>

                <div class="col-span-2">

                    <x-textarea :disabled="$s_piatu" label="Alamat" wire:model="si_alamat" />
                </div>
            </div>


        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-between items-center">
            <x-button secondary label="Kembali" wire:click="back()" flat negative />
            <x-button label="Lanjutkan" wire:click="save()" primary />
        </div>
    </x-slot>
</x-card>
