<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public $props;

    public $i_nama, $i_alamat, $i_gelar_depan, $i_gelar_belakang, $i_pendidikan_terakhir, $i_nama_panggilan,  $i_tempat_lahir, $i_tanggal_lahir, $i_nik, $i_status_warganegara, $i_agama, $i_pekerjaan_id, $i_nomor_handphone, $i_village_id, $i_status_perkawinan;
    public function mount()
    {
        if (isset($this->props['III'])) {
            foreach ($this->props['III'] as $key => $value) {
                $this->$key = $value;
            }
        }
    }
    public function back()
    {
        $this->dispatch('back-tab', data: $this->props, tab: 'II');
    }
    public function save()
    {
        $validated = $this->validate([
            'i_nama' => 'required',
            'i_pendidikan_terakhir' => 'required',
            'i_nama_panggilan' => 'required',

            'i_tempat_lahir' => 'required',
            'i_tanggal_lahir' => 'required',
            'i_nik' => 'required',
            'i_status_warganegara' => 'required',
            'i_agama' => 'required',
            'i_pekerjaan_id' => 'required',
            'i_nomor_handphone' => 'required',
            'i_village_id' => 'required',
            'i_status_perkawinan' => 'required',
        ]);
        $location = \Indonesia::findVillage($this->i_village_id, ['province', 'city', 'district', 'district.city', 'district.city.province']);

        $request = [...$validated, 'i_alamat'=> $this->i_alamat , 'i_gelar_depan' => $this->i_gelar_depan, 'i_gelar_belakang' => $this->i_gelar_belakang, 'i_kecamatan_id' => $location->district->code, 'i_kabupaten_id' => $location->district->city->code, 'i_provinsi_id' => $location->district->city->province->code];
        $this->dispatch('next-tab', data: $request, tab: 'III', nextTab: 'IV');
    }
}; ?>

<x-card title="III. Istri">
    <x-slot name="action">

    </x-slot>

    <div id="top2">
        <div class="grid grid-cols-2 gap-2">
            <x-input label="Nama Istri" wire:model="i_nama" placeholder="Nama Calon Istri" />
            <x-select label="Gelar Depan" wire:model="i_gelar_depan" placeholder="Pilih salah satu" :options="['Prof', 'Dr', 'dr', 'Drs', 'Ns', 'Dr.dr']" />
            <x-input label="Gelar Belakang" wire:model="i_gelar_belakang" placeholder="S,.kom" />
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
                wire:model="i_pendidikan_terakhir" />
            <x-input label="Nama Panggilan" wire:model="i_nama_panggilan" />

            <x-input label="Tempat Lahir" wire:model="i_tempat_lahir" />
            <x-datetime-picker label="Tanggal Lahir" without-time placeholder="Tanggal Lahir"
                wire:model="i_tanggal_lahir" />
            <x-input type="number" label="NIK" wire:model="i_nik" placeholder="7504XXXXXXX" />
            <x-select label="Status Kewarganegaraan" placeholder="Pilih salah satu" :options="['WNI', 'WNA']"
                wire:model="i_status_warganegara" />
            <x-select label="Agama" placeholder="Pilih salah satu" :options="['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya']" wire:model="i_agama" />
            <x-select label="Pekerjaan" wire:model="i_pekerjaan_id" placeholder="pilih salah satu" :async-data="route('select-pekerjaan')"
                option-label="nama" option-value="id">
            </x-select>
            <x-input type="number" label="Nomor Telepon" wire:model="i_nomor_handphone" placeholder="0852xxxx" />
            <x-select label="Status Perkawinan" placeholder="Pilih salah satu" :options="['Perawan', 'Janda (Cerai Mati) Terdaftar','Janda (Cerai Mati)', 'Janda (Cerai Hidup)']"
                wire:model="i_status_perkawinan" />
            <x-select label="Alamat Desa/Kelurahan" wire:model="i_village_id" placeholder="pilih salah satu"
                :async-data="route('get-village')" option-label="name" option-value="id" />
                <div class="col-span-2">

                    <x-textarea label="Alamat Detail" placeholder="Komplex XXX , Block XX" wire:model="i_alamat" />
                </div>


        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-between items-center">
            <x-button secondary label="Kembali" wire:click="back()" flat negative />
            <x-button label="Lanjutkan"  wire:click="save()" primary />
        </div>
    </x-slot>
</x-card>
