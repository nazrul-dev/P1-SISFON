<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use App\Models\{DataNikah};
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component {
    use Actions;
    public $data = [];
    public $ids;
    public function mount($id)
    {
        $data = DataNikah::with('pekerjaans', 'ttd_aparat', 'n6', 'n6.pekerjaan', 'n6.desa', 'n6.desa.city', 'n6.desa.province', 'n6.desa.district', 'n6.ttd_aparat', 'pekerjaani', 'desa', 'desa.city', 'desa.province', 'desa.district')->find($id);
        $this->ids = $id;
        $results = [
            'status_pemohon' => $data->status_pemohon,
            'saksi' => $data->saksi1 . ',' . $data->saksi2,
            'alamat_tempat_akad' => $data->alamat_tempat_akad,
            'nama_kepala_kua' => $data->datakua->nama_kepala_kua,
            'nip_kepala_kua' => $data->datakua->NIP,
            'tanggal_surat_keluar' => $data->tanggal_surat_keluar->formatLocalized('%A, %d %B %Y'),
            'nama_desa' => $data->desa->nama_desa,
            'nama_kepala_desa' => $data->desa->kepala_desa,
            'kua_pencatatan' => $data->datakua->nama_kecamatan,
            'kua_pencatatan_provinsi' => $data->datakua->province->name,
            'nama_kecamatan' => $data->desa->city->name,
            'nama_kabupaten' => $data->desa->district->name ?? '',
            'nomor_surat_keluar_i' => $data->nomor_surat_keluar_i,
            'nomor_surat_keluar_s' => $data->nomor_surat_keluar_s,
            'tanggal_diterima_kua' => $data->tanggal_diterima_kua->formatLocalized('%A, %d %B %Y'),
            'nama' => $data->nama,
            'nik' => $data->nik,
            'tempat_lahir' => $data->tempat_lahir . ', ',
            'tanggal_lahir' => $data->tanggal_lahir->format('d-m-Y'),
            'status_warganegara' => $data->status_warganegara,
            'agama' => $data->agama,
            'pekerjaan' => $data->pekerjaans->nama,
            'alamat' => $data->alamat,
            'istri_ke' => $data->istri_ke ?? '',
            'status_perkawinan' => $data->status_perkawinan,
            'tempat_akad' => $data->status_tempat_akad,
            'tanggal_akad' => $data->tanggal_akad->formatLocalized('%A, %d %B %Y') . ':' . $data->jam_akad,

            'i_nama' => $data->i_nama,
            'i_nik' => $data->i_nik,
            'i_tempat_lahir' => $data->i_tempat_lahir ? $data->i_tempat_lahir . ', ' : '',
            'i_tanggal_lahir' => $data->i_tanggal_lahir->formatLocalized('%A, %d %B %Y'),
            'i_status_warganegara' => $data->i_status_warganegara,
            'i_suami_ke' => $data->i_suami_ke ?? '',
            'i_agama' => $data->agama,
            'i_pekerjaan' => $data->pekerjaani->nama,
            'i_alamat' => $data->alamat,
            'i_status_perkawinan' => $data->i_status_perkawinan,

            'sa_nama' => $data->sa_nama,
            'sa_nik' => $data->sa_nik,
            'sa_tempat_lahir' => $data->sa_tempat_lahir ? $data->sa_tempat_lahir . ', ' : '',
            'sa_tanggal_lahir' => $data->sa_tanggal_lahir ? $data->sa_tanggal_lahir->formatLocalized('%A, %d %B %Y') : '',
            'sa_status_warganegara' => $data->sa_status_warganegara ?? '',
            'sa_agama' => $data->sa_agama ?? '',
            'sa_pekerjaan' => $data->pekerjaansuamiayah->nama ?? '',
            'sa_alamat' => $data->sa_alamat ?? '',
            'sa_binti' => $data->sa_binti ?? '',

            'si_nama' => $data->si_nama,
            'si_nik' => $data->si_nik,
            'si_tempat_lahir' => $data->si_tempat_lahir ? $data->si_tempat_lahir . ', ' : '',
            'si_tanggal_lahir' => $data->si_tanggal_lahir ? $data->si_tanggal_lahir->formatLocalized('%A, %d %B %Y') : '',
            'si_status_warganegara' => $data->si_status_warganegara ?? '',
            'si_agama' => $data->si_agama ?? '',
            'si_pekerjaan' => $data->pekerjaansuamiibu->nama ?? '',
            'si_alamat' => $data->si_alamat ?? '',
            'si_binti' => $data->si_binti ?? '',

            'ia_nama' => $data->ia_nama,
            'ia_nik' => $data->ia_nik,
            'ia_tempat_lahir' => $data->ia_tempat_lahir ? $data->ia_tempat_lahir . ', ' : '',
            'ia_tanggal_lahir' => $data->ia_tanggal_lahir ? $data->ia_tanggal_lahir->formatLocalized('%A, %d %B %Y') : '',
            'ia_status_warganegara' => $data->ia_status_warganegara ?? '',
            'ia_agama' => $data->ia_agama ?? '',
            'ia_pekerjaan' => $data->pekerjaanistriayah->nama ?? '',
            'ia_alamat' => $data->ia_alamat ?? '',
            'ia_binti' => $data->ia_binti ?? '',

            'ii_nama' => $data->ii_nama,
            'ii_nik' => $data->ii_nik,
            'ii_tempat_lahir' => $data->ii_tempat_lahir ? $data->ii_tempat_lahir . ', ' : '',
            'ii_tanggal_lahir' => $data->ii_tanggal_lahir ? $data->ii_tanggal_lahir->formatLocalized('%A, %d %B %Y') : '',
            'ii_status_warganegara' => $data->ii_status_warganegara ?? '',
            'ii_agama' => $data->ii_agama ?? '',
            'ii_pekerjaan' => $data->pekerjaanistriibu->nama ?? '',
            'ii_alamat' => $data->ii_alamat ?? '',
            'ii_binti' => $data->ii_binti ?? '',

            'ttd_jabatan_aparat' => $data->ttd_aparat?->jabatan->nama,
            'ttd_nama_aparat' => $data->ttd_aparat?->nama,
            'ttd_nip' => $data->ttd_aparat->nip ?? '',
            'n6_id' => $data->n6_id ?? null,
            'i_n6_id' => $data->i_n6_id ?? null,
        ];

        if ($data->n6_id) {
            $dataN6FromDB = $data->n6;
            $results += [
                'n6_nomor_surat_keluar' => $dataN6FromDB->n6_nomor_surat_keluar,
                'n6_tanggal_surat_keluar' => $dataN6FromDB->tanggal_surat_keluar->formatLocalized('%A, %d %B %Y'),
                'n6_nama' => $dataN6FromDB->n6_nama,
                'n6_status_warganegara' => $dataN6FromDB->n6_status_warganegara,
                'n6_nik' => $dataN6FromDB->n6_nik,
                'n6_alamat_tempat_meninggal' => $dataN6FromDB->n6_alamat_tempat_meninggal,
                'n6_tanggal_meninggal' => $dataN6FromDB->n6_tanggal_meninggal->formatLocalized('%A, %d %B %Y'),
                'n6_tanggal_lahir' => $dataN6FromDB->n6_tanggal_lahir->formatLocalized('%A, %d %B %Y'),
                'n6_alamat' => $dataN6FromDB->n6_alamat,
                'n6_agama' => $dataN6FromDB->n6_agama,
                'n6_tempat_lahir' => $dataN6FromDB->n6_tempat_lahir,
                'n6_binti' => $dataN6FromDB->n6_binti,
                'n6_tipe_bin' => $dataN6FromDB->n6_tipe_bin ?? '',
                'n6_nama_desa' => $dataN6FromDB->desa->nama_desa,
                'n6_nama_kepala_desa' => $dataN6FromDB->desa->kepala_desa,
                'n6_nama_kecamatan' => $dataN6FromDB->desa->city->name,
                'n6_nama_kabupaten' => $dataN6FromDB->desa->district->name ?? '',
                'n6_pekerjaan' => $dataN6FromDB->pekerjaan->nama ?? '',
            ];
        }
        if ($data->i_n6_id) {
            $dataN6FromDB2 = $data->i_n6;
            $results += [
                'i_n6_nomor_surat_keluar' => $dataN6FromDB2->n6_nomor_surat_keluar,
                'i_n6_tanggal_surat_keluar' => $dataN6FromDB2->tanggal_surat_keluar->formatLocalized('%A, %d %B %Y'),
                'i_n6_nama' => $dataN6FromDB2->n6_nama,
                'i_n6_status_warganegara' => $dataN6FromDB2->n6_status_warganegara,
                'i_n6_nik' => $dataN6FromDB2->n6_nik,
                'i_n6_alamat_tempat_meninggal' => $dataN6FromDB2->n6_alamat_tempat_meninggal,
                'i_n6_tanggal_meninggal' => $dataN6FromDB2->n6_tanggal_meninggal->formatLocalized('%A, %d %B %Y'),
                'i_n6_tanggal_lahir' => $dataN6FromDB2->n6_tanggal_lahir->formatLocalized('%A, %d %B %Y'),
                'i_n6_alamat' => $dataN6FromDB2->n6_alamat,
                'i_n6_agama' => $dataN6FromDB2->n6_agama,
                'i_n6_tempat_lahir' => $dataN6FromDB2->n6_tempat_lahir,
                'i_n6_binti' => $dataN6FromDB2->n6_binti,
                'i_n6_tipe_bin' => $dataN6FromDB2->n6_tipe_bin ?? '',
                'i_n6_nama_desa' => $dataN6FromDB2->desa->nama_desa,
                'i_n6_nama_kepala_desa' => $dataN6FromDB2->desa->kepala_desa,
                'i_n6_nama_kecamatan' => $dataN6FromDB2->desa->city->name,
                'i_n6_nama_kabupaten' => $dataN6FromDB2->desa->district->name ?? '',
                'i_n6_pekerjaan' => $dataN6FromDB2->pekerjaan->nama ?? '',
            ];
        }

        $this->data = $results;
    }

    public function handlerPrint()
    {
        $url = app('DataNikahPrinter')->run($this->ids);
        $filename = pathinfo($url, PATHINFO_FILENAME);
        $filename = basename($url);
        $this->dispatch('downloadZip', url: '/' . $filename);
        $this->notification([
            'title' => 'Download Dokumen!',
            'description' => ' Download Dokumen ' . $filename . ' Berhasil dilakukan',
            'icon' => 'success',
        ]);
    }

    public function handlerRemove(): void
    {
        $this->dialog()->confirm([
            'title' => 'Apakah anda yakin?',
            'description' => 'Menghapus data ini?',
            'acceptLabel' => 'Ya, saya yakin',
            'method' => 'destroy',
            'params' => $this->ids,
        ]);


    }

    public function destroy($id)
    {
        $this->data = DataNikah::find($id)->delete();
        $this->notification([
            'title' => 'Dokumen Hapus!',
            'description' => ' Dokumen berhasil dihapus, Selanjutnya anda akan di alihkan ke halaman sebelumnya',
            'icon' => 'success',
        ]);
        return $this->redirect(route('document'), navigate: false);

    }
}; ?>
<div class="container  mx-auto mb-20">
    <div class="flex mb-2 gap-1">
        <x-button wire:click="handlerPrint()" label="Download Dokumen" positive icon="download" />
        <x-button wire:click="handlerRemove()" label="Hapus Dokumen" negative icon="trash" />
        {{-- <x-button wire:click="handleForm()" label="Audit Trails" secondary /> --}}

    </div>
    <div class="grid grid-cols-3 gap-2">

        <x-card title="Informasi Surat ">
            <x-list title="Status Pemohon" value="{{ $data['status_pemohon'] }}" />
            @isset($data['nomor_surat_keluar_s'])
                <x-list title="Nomor Surat Keluar Calon Suami" value="{{ $data['nomor_surat_keluar_s'] }}" />
            @endisset
            @isset($data['nomor_surat_keluar_i'])
                <x-list title="Nomor Surat Keluar Calon Istri" value="{{ $data['nomor_surat_keluar_i'] }}" />
            @endisset
            <x-list title="TTD Aparat Desa" value="{{ $data['ttd_nama_aparat'] }}" />
            <x-list title="Tanggal Surat Keluar" value="{{ $data['tanggal_surat_keluar'] }}" />
            <x-list title="Tanggal Akad" value="{{ $data['tanggal_akad'] }}" />
            <x-list title="Status Tempat Akad" value="{{ $data['tempat_akad'] }}" />
            <x-list title="Alamat Tempat Akad" value="{{ $data['alamat_tempat_akad'] }}" />
            <x-list title="Tanggal diterima KUA" value="{{ $data['tanggal_diterima_kua'] }}" />
            <x-list title="KUA Pencatatan" value="{{ $data['kua_pencatatan'] }}" />
            <x-list title="Saksi" value="{{ $data['saksi'] }}" />
        </x-card>
        <x-card title="Data Suami ">


            <x-list title="Nama" value="{{ $data['nama'] }}" />
            <x-list title="NIK" value="{{ $data['nik'] }}" />
            <x-list title="Tempat  Dan Tanggal Lahir"
                value="{{ $data['tempat_lahir'] }}, {{ $data['tanggal_lahir'] }}" />
            <x-list title="Status Warganegara" value="{{ $data['status_warganegara'] }}" />
            <x-list title="Agama" value="{{ $data['agama'] }}" />
            <x-list title="Pekerjaan" value="{{ $data['pekerjaan'] }}" />
            <x-list title="Status Perkawinan" value="{{ $data['status_perkawinan'] }}" />
            @if ($data['istri_ke'] > 0)
                <x-list title="Istri Ke" value="{{ $data['istri_ke'] }}" />
            @endif
            <x-list title="Alamat" value="{{ $data['alamat'] }}" />


        </x-card>
        <x-card title="Data Istri ">
            <x-list title="Nama" value="{{ $data['i_nama'] }}" />
            <x-list title="NIK" value="{{ $data['nik'] }}" />
            <x-list title="Tempat  Dan Tanggal Lahir"
                value="{{ $data['i_tempat_lahir'] }}, {{ $data['i_tanggal_lahir'] }}" />
            <x-list title="Status Warganegara" value="{{ $data['i_status_warganegara'] }}" />
            <x-list title="Agama" value="{{ $data['i_agama'] }}" />
            <x-list title="Pekerjaan" value="{{ $data['i_pekerjaan'] }}" />
            <x-list title="Status Perkawinan" value="{{ $data['i_status_perkawinan'] }}" />
            @if ($data['i_suami_ke'] > 0)
                <x-list title="Suami Ke" value="{{ $data['i_suami_ke'] }}" />
            @endif
            <x-list title="Alamat" value="{{ $data['i_alamat'] }}" />
        </x-card>

    </div>

    <div class="grid grid-cols-2 gap-2 mt-3">
        <x-card title="Data Orang Tua Suami ">
            <div class="flex gap-3">
                <div class="border-r pr-2 ">
                    <div class="text-lg font-bold mb-2 border p-2 rounded-lg text-center">
                        AYAH
                    </div>
                    <x-list title="Nama" value="{{ $data['sa_nama'] }}" />
                    <x-list title="Binti" value="{{ $data['sa_binti'] }} " />

                    <x-list title="NIK" value="{{ $data['sa_nik'] }}" />
                    <x-list title="Tempat  Dan Tanggal Lahir"
                        value="{{ $data['sa_tempat_lahir'] }}, {{ $data['sa_tanggal_lahir'] }}" />
                    <x-list title="Status Warganegara" value="{{ $data['sa_status_warganegara'] }}" />
                    <x-list title="Agama" value="{{ $data['sa_agama'] }}" />
                    <x-list title="Pekerjaan" value="{{ $data['sa_pekerjaan'] }}" />

                    <x-list title="Alamat" value="{{ $data['sa_alamat'] }}" />
                </div>
                <div>
                    <div class="text-lg font-bold mb-2 border p-2 rounded-lg text-center">
                        IBU
                    </div>
                    <x-list title="Nama" value="{{ $data['si_nama'] }}" />
                    <x-list title="Binti" value="{{ $data['si_binti'] }} " />

                    <x-list title="NIK" value="{{ $data['si_nik'] }}" />
                    <x-list title="Tempat  Dan Tanggal Lahir"
                        value="{{ $data['si_tempat_lahir'] }}, {{ $data['si_tanggal_lahir'] }}" />
                    <x-list title="Status Warganegara" value="{{ $data['si_status_warganegara'] }}" />
                    <x-list title="Agama" value="{{ $data['si_agama'] }}" />
                    <x-list title="Pekerjaan" value="{{ $data['si_pekerjaan'] }}" />

                    <x-list title="Alamat" value="{{ $data['si_alamat'] }}" />
                </div>
            </div>
        </x-card>
        <x-card title="Data Orang Tua Istri ">
            <div class="grid grid-cols-2 gap-3">
                <div class="border-r pr-2  ">
                    <div class="text-lg font-bold mb-2 border p-2 rounded-lg text-center">
                        AYAH
                    </div>
                    <x-list title="Nama" value="{{ $data['ia_nama'] }}" />
                    <x-list title="Binti" value="{{ $data['ia_binti'] }} " />

                    <x-list title="NIK" value="{{ $data['ia_nik'] }}" />
                    <x-list title="Tempat  Dan Tanggal Lahir"
                        value="{{ $data['ia_tempat_lahir'] }}, {{ $data['ia_tanggal_lahir'] }}" />
                    <x-list title="Status Warganegara" value="{{ $data['ia_status_warganegara'] }}" />
                    <x-list title="Agama" value="{{ $data['ia_agama'] }}" />
                    <x-list title="Pekerjaan" value="{{ $data['ia_pekerjaan'] }}" />

                    <x-list title="Alamat" value="{{ $data['ia_alamat'] }}" />
                </div>
                <div>
                    <div class="text-lg font-bold mb-2 border p-2 rounded-lg text-center">
                        IBU
                    </div>
                    <x-list title="Nama" value="{{ $data['ii_nama'] }}" />
                    <x-list title="Binti" value="{{ $data['ii_binti'] }} " />

                    <x-list title="NIK" value="{{ $data['ii_nik'] }}" />
                    <x-list title="Tempat  Dan Tanggal Lahir"
                        value="{{ $data['ii_tempat_lahir'] }}, {{ $data['ii_tanggal_lahir'] }}" />
                    <x-list title="Status Warganegara" value="{{ $data['ii_status_warganegara'] }}" />
                    <x-list title="Agama" value="{{ $data['ii_agama'] }}" />
                    <x-list title="Pekerjaan" value="{{ $data['ii_pekerjaan'] }}" />

                    <x-list title="Alamat" value="{{ $data['ii_alamat'] }}" />
                </div>
            </div>
        </x-card>
        @if ($data['n6_id'])
            <x-card title="Data Mantan Istri">

                <x-list title="Nomor Surat Keluar" value="{{ $data['n6_nomor_surat_keluar'] }}" />
                <x-list title="Tanggal Surat Keluar" value="{{ $data['n6_tanggal_surat_keluar'] }}" />
                <x-list title="Nama" value="{{ $data['n6_nama'] }}" />
                <x-list title="Status Kewarganegaraan" value="{{ $data['n6_status_warganegara'] }}" />
                <x-list title="NIK" value="{{ $data['n6_nik'] }}" />
                <x-list title="Alamat Tempat Meninggal" value="{{ $data['n6_alamat_tempat_meninggal'] }}" />
                <x-list title="Tanggal Meninggal" value="{{ $data['n6_tanggal_meninggal'] }}" />

                <x-list title="Tempat Tanggal Lahir"
                    value="{{ $data['n6_tempat_lahir'] }}, {{ $data['n6_tanggal_lahir'] }}" />
                <x-list title="Binti" value="{{ $data['n6_binti'] }}" />
                <x-list title="Tipe Binti" value="{{ $data['n6_tipe_bin'] }}" />
                <x-list title="Pekerjaan" value="{{ $data['n6_pekerjaan'] }}" />
            </x-card>
        @endif
        @if ($data['i_n6_id'])
            <x-card title="Data Mantan Suami">
                <x-list title="Nomor Surat Keluar" value="{{ $data['i_n6_nomor_surat_keluar'] }}" />
                <x-list title="Tanggal Surat Keluar" value="{{ $data['i_n6_tanggal_surat_keluar'] }}" />
                <x-list title="Nama" value="{{ $data['i_n6_nama'] }}" />
                <x-list title="Status Kewarganegaraan" value="{{ $data['i_n6_status_warganegara'] }}" />
                <x-list title="NIK" value="{{ $data['i_n6_nik'] }}" />
                <x-list title="Alamat Tempat Meninggal" value="{{ $data['i_n6_alamat_tempat_meninggal'] }}" />
                <x-list title="Tanggal Meninggal" value="{{ $data['i_n6_tanggal_meninggal'] }}" />

                <x-list title="Tempat Tanggal Lahir"
                    value="{{ $data['i_n6_tempat_lahir'] }}, {{ $data['i_n6_tanggal_lahir'] }}" />
                <x-list title="Binti" value="{{ $data['i_n6_binti'] }}" />
                <x-list title="Tipe Binti" value="{{ $data['i_n6_tipe_bin'] }}" />
                <x-list title="Pekerjaan" value="{{ $data['i_n6_pekerjaan'] }}" />
            </x-card>
        @endif
    </div>

</div>
