<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\{User, Desa, DataNikah, DataN6};
use WireUi\Traits\Actions;
use Livewire\Attributes\On;
use Livewire\WithPagination;

new class extends Component {
    use Actions;

    public $form = false;
    public $desa_id, $n6_nomor_surat_keluar, $n6_tanggal_meninggal, $n6_alamat_tempat_meninggal, $n6_nama, $n6_gelar_depan, $n6_gelar_belakang, $n6_pendidikan_terakhir, $n6_nama_panggilan, $n6_binti, $n6_tipe_bin, $n6_tempat_lahir, $n6_tanggal_lahir, $n6_nik, $n6_status_warganegara, $n6_agama, $n6_pekerjaan_id, $n6_village_id;

    #[On('form-change')]
    public function updatedFormFromDispatch()
    {
        $this->form = !$this->form;
    }

    public function save()
    {
        $validated = $this->validate([
            'desa_id' => 'required',
            'n6_nama' => 'required',
            'n6_pendidikan_terakhir' => 'required',
            'n6_nama_panggilan' => 'required',
            'n6_binti' => 'required',
            'n6_tempat_lahir' => 'required',
            'n6_tanggal_lahir' => 'required',
            'n6_nik' => 'required',
            'n6_status_warganegara' => 'required',
            'n6_agama' => 'required',
            'n6_pekerjaan_id' => 'required',
            // 'n6_village_id' => 'required',
            'n6_nomor_surat_keluar' => 'required',
            'n6_tanggal_meninggal' => 'required',
            'n6_alamat_tempat_meninggal' => 'required',
        ]);
        // $location = \Indonesia::findVillage($this->n6_village_id, ['province', 'city', 'district', 'district.city', 'district.city.province']);
        $desa = Desa::find($this->desa_id);

        $request = [...$validated, 'n6_nomor_surat_keluar' => $desa->n6 . $this->n6_nomor_surat_keluar, 'n6_tipe_bin' => $this->n6_tipe_bin, 'n6_gelar_depan' => $this->n6_gelar_depan, 'n6_gelar_belakang' => $this->n6_gelar_belakang, 'n6_alamat' => 'asas'];

        $this->dialog()->confirm([
            'title' => 'Apakah Kamu yakin?',
            'description' => 'Sudah menginput data dengan benar ?',
            'acceptLabel' => 'Ya,Saya yakin',
            'method' => 'storeData',
            'params' => $request,
        ]);
    }

    public function storeData($request)
    {
        DB::beginTransaction();

        try {
            $dataN6 = DataN6::create($request);
            DB::commit();
            $this->form = false;
            $this->notification([
                'title' => 'Data N6 simpan!',
                'description' => ' Data N6 berhasil disimpan',
                'icon' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->notification([
                'title' => 'Data N6 simpan!',
                'description' => ' Data N6 gagal disimpan, harap refresh kembali halaman',
                'icon' => 'error',
            ]);
        }
    }
}; ?>
<div>
    <x-modal max-width="2xl" wire:model="form">
        <div class="w-full mx-auto flex items-start gap-2 ">

            <div class="pb-10 flex-1">
                <x-card title=" N6">
                    <x-slot name="action">

                    </x-slot>

                    <div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="col-span-2">

                                <x-select label="Pilih Desa Terlebih Dahulu" placeholder="Pilih salah satu desa"
                                    wire:model="desa_id" :async-data="route('select-datadesa')" option-label="nama_desa" option-value="id">
                                </x-select>
                            </div>
                            <x-input label="Nomor Surat Keluar" wire:model="n6_nomor_surat_keluar" />

                            <x-input label="Nama " wire:model="n6_nama" placeholder="Nama " />
                            <x-select label="Gelar Depan" wire:model="n6_gelar_depan" placeholder="Pilih salah satu"
                                :options="['Prof', 'Dr', 'dr', 'Drs', 'Ns', 'Dr.dr']" />
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
                            <x-select label="Agama" placeholder="Pilih salah satu" :options="[
                                'Islam',
                                'Kristen Protestan',
                                'Katolik',
                                'Hindu',
                                'Buddha',
                                'Kong Hu Cu',
                                'Lainnya',
                            ]"
                                wire:model="n6_agama" />
                            <x-select label="Pekerjaan" wire:model="n6_pekerjaan_id" placeholder="pilih salah satu"
                                :async-data="route('select-pekerjaan')" option-label="nama" option-value="id">
                            </x-select>

                            <x-select label="Alamat Desa/Kelurahan" wire:model="n6_village_id"
                                placeholder="pilih salah satu" :async-data="route('get-village')" option-label="name"
                                option-value="id" />
                            <x-datetime-picker label="Tanggal Meninggal" without-time placeholder="Tanggal Lahir"
                                wire:model="n6_tanggal_meninggal" />
                            <x-input label="Alamat Tempat Meninggal" wire:model="n6_alamat_tempat_meninggal" />

                        </div>

                    </div>

                    <x-slot name="footer">
                        <div class="flex justify-between items-center">
                            <x-button secondary label="Kembali" wire:click="back()" flat negative />
                            <x-button label="Simpan" wire:click="save()" primary />
                        </div>
                    </x-slot>
                </x-card>

            </div>
        </div>
    </x-modal>
</div>
