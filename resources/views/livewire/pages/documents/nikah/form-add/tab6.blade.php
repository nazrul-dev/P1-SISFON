<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
new class extends Component {
    use Actions;
    public $props,
        $n62 = false;
    public $wajib = false;
    public $n6_alamat, $n6_nomor_surat_keluar, $n6_tanggal_meninggal, $n6_alamat_tempat_meninggal, $n6_nama, $n6_gelar_depan, $n6_gelar_belakang, $n6_pendidikan_terakhir, $n6_nama_panggilan, $n6_binti, $n6_tipe_bin, $n6_tempat_lahir, $n6_tanggal_lahir, $n6_nik, $n6_status_warganegara, $n6_agama, $n6_pekerjaan_id, $n6_village_id;
    public function mount()
    {
        if (isset($this->props['II'])) {
            if (isset($this->props['II']['status_perkawinan']) && $this->props['II']['status_perkawinan'] == 'Duda (Cerai Mati)') {
                $this->wajib = true;
            }
        }

        if (isset($this->props['III'])) {
            if (isset($this->props['III']['i_status_perkawinan'])) {
                if ($this->props['III']['i_status_perkawinan'] === 'Janda (Cerai Mati)') {
                    $this->n62 = true;
                }
            }
        }

        if (isset($this->props['VI'])) {
            foreach ($this->props['VI'] as $key => $value) {
                $this->$key = $value;
            }
        }
    }
    public function back()
    {
        $this->dispatch('back-tab', data: $this->props, tab: 'V');
    }
    public function save()
    {
        $validated = $this->validate([
            'n6_nama' => $this->wajib ? 'required' : 'nullable',
            'n6_pendidikan_terakhir' => $this->wajib ? 'required' : 'nullable',
            'n6_nama_panggilan' => $this->wajib ? 'required' : 'nullable',
            'n6_binti' => $this->wajib ? 'required' : 'nullable',
            'n6_tempat_lahir' => $this->wajib ? 'required' : 'nullable',
            'n6_tanggal_lahir' => $this->wajib ? 'required' : 'nullable',
            'n6_nik' => $this->wajib ? 'required' : 'nullable',
            'n6_status_warganegara' => $this->wajib ? 'required' : 'nullable',
            'n6_agama' => $this->wajib ? 'required' : 'nullable',
            'n6_pekerjaan_id' => $this->wajib ? 'required' : 'nullable',
            'n6_village_id' => $this->wajib ? 'required' : 'nullable',
            'n6_nomor_surat_keluar' => $this->wajib ? 'required' : 'nullable',
            'n6_tanggal_meninggal' => $this->wajib ? 'required' : 'nullable',
            'n6_alamat_tempat_meninggal' => $this->wajib ? 'required' : 'nullable',
        ]);

        $request = [...$validated, 'n6_alamat' => $this->n6_alamat, 'n6_tipe_bin' => $this->n6_tipe_bin, 'n6_gelar_depan' => $this->n6_gelar_depan, 'n6_gelar_belakang' => $this->n6_gelar_belakang];

        if ($this->n62) {
            $this->dispatch('next-tab', data: $request, tab: 'VI', nextTab: 'VII');
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
        $this->dispatch('finish', data: $data, tab: 'VI');
    }
}; ?>

<x-card title="VI. N6">
    <x-slot name="action">

    </x-slot>

    <div>
        <div class="grid grid-cols-2 gap-2">
            <x-input label="Nomor Surat Keluar" wire:model="n6_nomor_surat_keluar" />

            <x-input label="Nama Mantan Istri" wire:model="n6_nama" placeholder="Nama Mantan Istri" />
            <x-select label="Gelar Depan" wire:model="n6_gelar_depan" placeholder="Pilih salah satu" :options="['Prof', 'Dr', 'dr', 'Drs', 'Ns', 'Dr.dr']" />
            <x-input label="Gelar Belakang" wire:model="n6_gelar_belakang" placeholder="S,.kom" />
            <x-select label="Pendidikan Terakhir" placeholder="Pilih salah satu" :options="[
                'Tidak Tamat SD',
                'SD/Sederajat',
                'SMP/Sederajat',
                'SMA/Sederajat',
                'D1',
                'D2',
                'D3',
                'D4',
                'S1',
                'S2',
                'S3',
            ]"
                wire:model="n6_pendidikan_terakhir" />
            <x-input label="Nama Panggilan" wire:model="n6_nama_panggilan" />
            <div class="grid grid-cols-3">
                <div class="col-span-2 mr-1">
                    <x-input label="BIN" wire:model="n6_binti" placeholder="Binti Usman" />
                </div>
                <x-select label="/" :options="['Alm']" wire:model="n6_tipe_bin" />
            </div>
            <x-input label="Tempat Lahir" wire:model="n6_tempat_lahir" />
            <x-datetime-picker label="Tanggal Lahir" without-time placeholder="Tanggal Lahir"
                wire:model="n6_tanggal_lahir" />
            <x-input type="number" label="NIK" wire:model="n6_nik" placeholder="7504XXXXXXX" />
            <x-select label="Status Kewarganegaraan" placeholder="Pilih salah satu" :options="['WNI', 'WNA']"
                wire:model="n6_status_warganegara" />
            <x-select label="Agama" placeholder="Pilih salah satu" :options="['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya']" wire:model="n6_agama" />
            <x-select label="Pekerjaan" wire:model="n6_pekerjaan_id" placeholder="pilih salah satu" :async-data="route('select-pekerjaan')"
                option-label="nama" option-value="id">
            </x-select>

            <x-select label="Alamat Desa/Kelurahan" wire:model="n6_village_id" placeholder="pilih salah satu"
                :async-data="route('get-village')" option-label="name" option-value="code" />

            <div class="col-span-2">

                <x-textarea label="Alamat Detail" placeholder="Komplex XXX , Block XX" wire:model="n6_alamat" />
            </div>
            <x-datetime-picker label="Tanggal Meninggal" without-time placeholder="Tanggal Lahir"
                wire:model="n6_tanggal_meninggal" />
            <x-input label="Alamat Tempat Meninggal" wire:model="n6_alamat_tempat_meninggal" />

        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-between items-center">
            <x-button secondary label="Kembali" wire:click="back()" flat negative />
            <x-button label="{{ $n62 ? 'Lanjutkan' : 'Simpan' }}" wire:click="save()" primary />
        </div>
    </x-slot>
</x-card>
