<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\{DataN6};
new class extends Component {
    public $props;
    public $n6_id;
    public $nama, $alamat, $gelar_depan, $gelar_belakang, $pendidikan_terakhir, $nama_panggilan, $tempat_lahir, $tanggal_lahir, $nik, $status_warganegara, $agama, $pekerjaan_id, $nomor_handphone, $village_id, $status_perkawinan, $istri_ke, $nama_istri_terdahulu;
    public function mount()
    {
        if (isset($this->props['II'])) {
            foreach ($this->props['II'] as $key => $value) {
                $this->$key = $value;
                if ($key == 'n6_id' && isset($value)) {
                    $n6 = DataN6::find($value);
                    $this->nama_istri_terdahulu = $n6->nama;
                }
            }
        }
    }
    public function updatedStatusPerkawinan()
    {
        $this->istri_ke = 0;
        $this->reset(['nama_istri_terdahulu', 'n6_id']);
    }
    public function updatedN6Id()
    {
        if (isset($this->n6_id)) {
            $n6 = DataN6::find($this->n6_id);

            if ($n6) {
                $this->nama_istri_terdahulu = $n6->n6_nama;
            } else {
                $this->reset(['nama_istri_terdahulu']);
            }
        } else {
            $this->reset(['nama_istri_terdahulu']);
        }
    }

    public function back()
    {
        $this->dispatch('back-tab', data: $this->props, tab: 'I');
    }
    public function save()
    {
        $validated = $this->validate([
            'nama' => 'required',
            'pendidikan_terakhir' => 'required',
            'nama_panggilan' => 'required',

            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nik' => 'required',
            'status_warganegara' => 'required',
            'agama' => 'required',
            'pekerjaan_id' => 'required',
            'nomor_handphone' => 'required',
            'village_id' => 'required',
            'status_perkawinan' => 'required',
            'istri_ke' => $this->status_perkawinan && $this->status_perkawinan !== 'Jejaka' ? 'required' : 'nullable',

            'n6_id' => $this->status_perkawinan && $this->status_perkawinan == 'Duda (Cerai Mati) Terdaftar' ? 'required' : 'nullable',
        ]);

        $location = \Indonesia::findVillage($this->village_id, ['province', 'city', 'district', 'district.city', 'district.city.province']);

        $request = [...$validated, 'alamat' => $this->alamat, 'gelar_depan' => $this->gelar_depan, 'gelar_belakang' => $this->gelar_belakang, 'kecamatan_id' => $location->district->code, 'kabupaten_id' => $location->district->city->code, 'provinsi_id' => $location->district->city->province->code];
        $this->dispatch('next-tab', data: $request, tab: 'II', nextTab: 'III');
    }
}; ?>

<x-card title="II. Suami">
    <x-slot name="action">

    </x-slot>

    <div id="top1">

        <div class="grid grid-cols-2 gap-2">
            <x-input label="Nama Suami" wire:model="nama" placeholder="Nama Calon Suami" />
            <x-select label="Gelar Depan" wire:model="gelar_depan" placeholder="Pilih salah satu" :options="['Prof', 'Dr', 'dr', 'Drs', 'Ns', 'Dr.dr']" />
            <x-input label="Gelar Belakang" wire:model="gelar_belakang" placeholder="S,.kom" />
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
                wire:model="pendidikan_terakhir" />
            <x-input label="Nama Panggilan" wire:model="nama_panggilan" />

            <x-input label="Tempat Lahir" wire:model="tempat_lahir" />
            <x-datetime-picker label="Tanggal Lahir" without-time placeholder="Tanggal Lahir"
                wire:model="tanggal_lahir" />
            <x-input type="number" label="NIK" wire:model="nik" placeholder="7504XXXXXXX" />
            <x-select label="Status Kewarganegaraan" placeholder="Pilih salah satu" :options="['WNI', 'WNA']"
                wire:model="status_warganegara" />
            <x-select label="Agama" placeholder="Pilih salah satu" :options="['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Kong Hu Cu', 'Lainnya']" wire:model="agama" />
            <x-select label="Pekerjaan" wire:model="pekerjaan_id" placeholder="pilih salah satu" :async-data="route('select-pekerjaan')"
                option-label="nama" option-value="id">
            </x-select>
            <x-input type="number" label="Nomor Telepon" wire:model="nomor_handphone" placeholder="0852xxxx" />
            <x-select label="Alamat Desa/Kelurahan" wire:model="village_id" placeholder="pilih salah satu"
                :async-data="route('get-village')" option-label="name" option-value="id" />
            <div class="col-span-2">

                <x-textarea label="Alamat Detail" placeholder="Komplex XXX , Block XX" wire:model="alamat" />
            </div>

            <x-select label="Status Perkawinan" placeholder="Pilih salah satu" :options="['Jejaka', 'Duda (Cerai Mati) Terdaftar', 'Duda (Cerai Mati)', 'Duda (Cerai Hidup)', 'Beristri']"
                wire:model.live="status_perkawinan" />
                <x-select :disabled="$status_perkawinan == 'Jejaka'? true : false" label="Istri Ke" placeholder="Pilih salah satu" :options="['1', '2', '3', '4']" wire:model="istri_ke" />
            <div
                class="border p-5 grid grid-cols-2 col-span-2 gap-2 bg-gray-100 rounded-lg {{ $status_perkawinan === 'Duda (Cerai Mati) Terdaftar' ? 'block' : 'hidden' }}">
                <div class=" {{ $status_perkawinan === 'Duda (Cerai Mati) Terdaftar' ? 'block' : 'hidden' }}">
                    <x-select label="N6 Nomor Surat Keluaran" wire:model.live="n6_id" placeholder="pilih salah satu"
                        :async-data="route('select-n6')" option-label="n6_nomor_surat_keluar" option-value="id" />
                </div>
                <div >
                    <x-input label="Nama istri terdahulu" readonly wire:model.live="nama_istri_terdahulu"
                        />
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
