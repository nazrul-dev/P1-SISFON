<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\{Village};
new class extends Component {
    public $props;
    public $i_n6_id;
    public $i_nama, $i_alamat, $i_gelar_depan, $i_gelar_belakang, $i_pendidikan_terakhir, $i_nama_panggilan, $i_tempat_lahir, $i_tanggal_lahir, $i_nik, $i_status_warganegara, $i_agama, $i_pekerjaan_id, $i_nomor_handphone, $i_village_id, $i_status_perkawinan,$i_suami_ke = 0, $i_nama_suami_terdahulu;
    public function mount()
    {
        if (isset($this->props['III'])) {
            foreach ($this->props['III'] as $key => $value) {
                $this->$key = $value;
                if ($key == 'i_n6_id' && isset($value)) {
                    $n6 = DataN6::find($value);
                    $this->i_nama_istri_terdahulu = $n6->nama;
                }
            }
        }
    }

    public function updatedIStatusPerkawinan()
    {
        if($this->i_status_perkawinan === 'Perawan'){
            $this->i_suami_ke = 0;
        }else{
            $this->i_suami_ke = 1;
        }

        $this->reset(['i_nama_suami_terdahulu', 'i_n6_id']);
    }
    public function updatedN6Id()
    {
        if (isset($this->i_n6_id)) {
            $n6 = DataN6::find($this->i_n6_id);

            if ($n6) {
                $this->i_nama_istri_terdahulu = $n6->n6_nama;
            } else {
                $this->reset(['i_nama_istri_terdahulu']);
            }
        } else {
            $this->reset(['i_nama_istri_terdahulu']);
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
            'i_suami_ke' => $this->i_status_perkawinan && $this->i_status_perkawinan !== 'Jejaka' ? 'required' : 'nullable',

            'i_n6_id' => $this->i_status_perkawinan && $this->i_status_perkawinan == 'Duda (Cerai Mati) Terdaftar' ? 'required' : 'nullable',
        ]);

        $vilID = Village::where('code', $this->i_village_id)->first();

        $location = \Indonesia::findVillage($vilID->id, ['province', 'city', 'district', 'district.city', 'district.city.province']);

        $request = [...$validated, 'i_alamat' => $this->i_alamat, 'i_gelar_depan' => $this->i_gelar_depan, 'i_gelar_belakang' => $this->i_gelar_belakang, 'i_kecamatan_id' => $location->district->code, 'i_kabupaten_id' => $location->district->city->code, 'i_provinsi_id' => $location->district->city->province->code];
        $this->dispatch('next-tab', data: $request, tab: 'III', nextTab: 'IV');
    }
}; ?>

<x-card title="III. suami">
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

            <x-select label="Alamat Desa/Kelurahan" wire:model="i_village_id" placeholder="pilih salah satu"
                :async-data="route('get-village')" option-label="name" option-value="code" />
            <div class="col-span-2">

                <x-textarea label="Alamat Detail" placeholder="Komplex XXX , Block XX" wire:model="i_alamat" />
            </div>
            <x-select label="Status Perkawinan" placeholder="Pilih salah satu" :options="['Perawan','Janda (Cerai Mati) Terdaftar', 'Janda (Cerai Mati)', 'Janda (Cerai Hidup)']"
                wire:model.live="i_status_perkawinan" />
                <x-input :disabled="$i_status_perkawinan === 'Perawan'" type="number" label="Suami Ke"  wire:model.live="i_suami_ke"/>
            <div
                class="border p-5 grid grid-cols-2 col-span-2 gap-2 bg-gray-100 rounded-lg {{ $i_status_perkawinan === 'Janda (Cerai Mati) Terdaftar' ? 'block' : 'hidden' }}">
                <div class=" {{ $i_status_perkawinan === 'Janda (Cerai Mati) Terdaftar' ? 'block' : 'hidden' }}">
                    <x-select label="N6 Nomor Surat Keluaran" wire:model.live="i_n6_id" placeholder="pilih salah satu"
                        :async-data="route('select-n6')" option-label="n6_nomor_surat_keluar" option-value="id" />
                </div>
                <div>
                    <x-input label="Nama suami terdahulu" readonly wire:model.live="i_nama_suami_terdahulu" />
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
