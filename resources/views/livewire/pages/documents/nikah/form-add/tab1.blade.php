<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use App\Models\{District, DataKua};
new class extends Component {
    public $props;
    use Actions;
    public $desa_select = true,
        $status_pemohon;
    public $desa_id, $tanggal_surat_keluar, $nomor_surat_keluar_s, $nomor_surat_keluar_i, $tanggal_akad, $jam_akad, $status_tempat_akad, $alamat_tempat_akad, $ttd_aparat_id, $saksi1, $saksi2, $kua_pencatatan, $kecamatan_kl_id, $nama_kepala_kl_kua, $nip_kepala_kl_kua, $alamat_kl_kua, $tanggal_diterima_kua;
    public function mount()
    {
        $user = auth()->user();

        if ($user->tipe_user === 'desa' && $user->role_user !== 'superadmin') {
            $this->desa_id = $user->desa_id;
            $this->desa_select = false;
        }
        if (isset($this->props['I'])) {
            foreach ($this->props['I'] as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function exit()
    {
        $this->dispatch('form-change');
    }

    public function updatedStatusPemohon(){
        $this->reset('nomor_surat_keluar_s', 'nomor_surat_keluar_i');
    }

    public function save()
    {
        $validated = $this->validate([
            'desa_id' => 'required',
            'ttd_aparat_id' => 'required',
            'nomor_surat_keluar_s' => $this->status_pemohon == 'calon suami' || $this->status_pemohon == 'calon suami & istri' ? 'required|min:5' : 'nullable',
            'nomor_surat_keluar_i' => $this->status_pemohon == 'calon istri' || $this->status_pemohon == 'calon suami & istri' ? 'required|min:5' : 'nullable',
            'tanggal_akad' => 'required',
            'jam_akad' => 'required',
            'status_tempat_akad' => 'required',
            'alamat_tempat_akad' => 'required|min:3',
            'saksi1' => 'required|min:2',
            'saksi2' => 'required|min:2',
            'kua_pencatatan' => 'required',
            'kecamatan_kl_id' => $this->kua_pencatatan == 'lainnya' ? 'required|min:3' : 'nullable',
            'nama_kepala_kl_kua' => $this->kua_pencatatan == 'lainnya' ? 'required|min:3' : 'nullable',
            'nip_kepala_kl_kua' => $this->kua_pencatatan == 'lainnya' ? 'required|min:3' : 'nullable',
            'tanggal_diterima_kua' => 'required',
            'tanggal_surat_keluar' => 'required',
            'status_pemohon' => 'required',
        ]);

        if ($this->kua_pencatatan == 'lainnya') {
            $discID = District::where('code', $this->kecamatan_kl_id)->first();
            $location = \Indonesia::findDistrict($discID->id, ['province', 'city', 'city.province']);

            $kua = DataKua::create([
                'nama_kepala_kua' => $this->nama_kepala_kl_kua,
                'district_id' => $this->kecamatan_kl_id,
                'nip' => $this->nip_kepala_kl_kua,
                'alamat_kua' => $this->alamat_kl_kua,
                'nama_kecamatan' => $location->name,
                'city_id' => $location->city->code,
                'province_id' => $location->city->province->code,
            ]);
            $validated['kua_pencatatan'] = $kua->id;
            unset($validated['kecamatan_kl_id']);
            unset($validated['nama_kepala_kl_kua']);
            unset($validated['nip_kepala_kl_kua']);
        }
        $this->dispatch('next-tab', data: [...$validated], tab: 'I', nextTab: 'II');
    }
}; ?>




<x-card title="I. Surat">
    <x-slot name="action">

    </x-slot>
    <div>
        <div class="grid grid-cols-2 gap-2" id="top">

            <x-select :disabled="!$desa_select" label="Pilih Desa Terlebih Dahulu" placeholder="Pilih salah satu desa"
                wire:model.live="desa_id" :async-data="route('select-datadesa')" option-label="nama_desa" option-value="id">
            </x-select>
            <x-select label="Status Pemohon" wire:model.live="status_pemohon" placeholder="Pilih salah satu"
                :options="['Calon Suami & Istri', 'calon suami', 'calon istri']" />

            <x-input :disabled="!in_array($status_pemohon, [
                'calon suami',
                'Calon Suami & Istri',
            ])" label="Nomor Surat Keluar Calon Suami" wire:model.live="nomor_surat_keluar_s"
                placeholder="Nomor Surat Keluar" />
            <x-input :disabled="!in_array($status_pemohon, [
                'calon istri',
                'Calon Suami & Istri',
            ])" label="Nomor Surat Keluar Calon Istri" wire:model="nomor_surat_keluar_i"
                placeholder="Nomor Surat Keluar" />

            <x-select placeholder="Pilih salah satu" :disabled="!$desa_id" label="TTD Aparat Desa" wire:model="ttd_aparat_id"
                :async-data="route('select-aparatur', ['desa_id' => $desa_id])" option-label="nama_lengkap" option-value="id">
            </x-select>
            <x-datetime-picker label="Tanggal Surat Keluar" without-time placeholder="Tanggal Surat Keluar"
                wire:model="tanggal_surat_keluar" />
            <div class="col-span-2">
                <div class="grid grid-cols-4 gap-2">
                    <x-datetime-picker label="Tanggal Akad" without-time placeholder="Tanggal Akad"
                        wire:model="tanggal_akad" />
                    <x-time-picker label="Jam Akad" placeholder="Format 24 JAM" format="24" wire:model="jam_akad" />
                    <div class="col-span-2">
                        <x-select label="Status Tempat Akad" placeholder="Pilih salah satu" :options="[
                            'Balai Nikah',
                            'Kediaman Mempelai Perempuan',
                            'Kediaman Mempelai Laki-laki',
                            'Masjid/Musholla',
                            'Gedung',
                        ]"
                            wire:model="status_tempat_akad" />
                    </div>
                </div>
            </div>
            <div class="col-span-2">
                <x-textarea label="Alamat Tempat Akad" wire:model="alamat_tempat_akad"
                    placeholder="Alamat Tempat Akad" />
            </div>




            <x-datetime-picker without-time label="Tanggal diterima KUA" wire:model="tanggal_diterima_kua" />
            <x-input label="Saksi I" wire:model="saksi1" placeholder="Saksi I" />
            <x-input label="Saksi II" wire:model="saksi2" placeholder="Saksi  II" />

            <x-select label="KUA Pencatatan" wire:model.live="kua_pencatatan" placeholder="KUA Pencatatan"
                :async-data="route('select-datakua')" option-label="nama_kecamatan" option-value="id">
            </x-select>
            <div
                class="border p-5 grid grid-cols-2 col-span-2 gap-2 bg-gray-100 rounded-lg {{ $kua_pencatatan == 'lainnya' ? 'block' : 'hidden' }}">
                <x-input label="Nama KUA Lainnya" placeholder="Nama KUA Lainnya" />

                <x-select label="KEC. KUA Lainnnya" wire:model="kecamatan_kl_id" placeholder="Kecamatan"
                    :async-data="route('get-district')" option-label="name" option-value="code">
                </x-select>
                <x-input label="Nama Kepala KUA" wire:model="nama_kepala_kl_kua" placeholder="Nama Kepala KUA" />
                <x-input label="NIP kepala KUA" wire:model="nip_kepala_kl_kua" placeholder="NIP kepala KUA" />
                <div class="col-span-2">
                    <x-textarea label="Alamat KUA Lainnya" wire:model="alamat_kl_kua" />
                </div>
            </div>


        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-between items-center">
            <x-button href="{{ route('document', ['tab' => 'nikah']) }}" secondary label="Keluar" secondary />
            <x-button label="Lanjutkan"   wire:click.prevent="save()" primary />
        </div>
    </x-slot>
</x-card>
