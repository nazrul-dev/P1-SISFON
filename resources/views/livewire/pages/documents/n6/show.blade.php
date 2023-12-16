<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use WireUi\Traits\Actions;
use App\Models\{DataN6, DataNikah};
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
new #[Layout('layouts.app')] class extends Component {
    use Actions;
    public $data = [];
    public $ids;
    public function mount($id)
    {
        $data = DataN6::with('pekerjaan', 'ttd_aparat', 'desa', 'desa.city', 'desa.province', 'desa.district')->find($id);
        $dataRelated = $this->ids = $id;

        $results = [
            'n6_nomor_surat_keluar' => $data->n6_nomor_surat_keluar,
            'n6_tanggal_surat_keluar' => $data->tanggal_surat_keluar->formatLocalized('%A, %d %B %Y'),
            'n6_nama' => $data->n6_nama,
            'n6_jenis_kelamin' => $data->n6_jenis_kelamin == 'L' ? 'Laki laki' : 'Perempuan',
            'ttd_jabatan_aparat' => $data->ttd_aparat?->jabatan->nama,
            'ttd_nama_aparat' => $data->ttd_aparat?->nama,
            'nama_desa' => $data->desa->nama_desa,
            'nama_kepala_desa' => $data->desa->kepala_desa,
            'nama_kecamatan' => $data->desa->city->name,
            'nama_kabupaten' => $data->desa->district->name ?? '',
            'n6_status_warganegara' => $data->n6_status_warganegara,
            'n6_nik' => $data->n6_nik,
            'n6_alamat_tempat_meninggal' => $data->n6_alamat_tempat_meninggal,
            'n6_tanggal_meninggal' => $data->n6_tanggal_meninggal->formatLocalized('%A, %d %B %Y'),
            'n6_tanggal_lahir' => $data->n6_tanggal_lahir->formatLocalized('%A, %d %B %Y'),
            'n6_alamat' => $data->n6_alamat,
            'n6_agama' => $data->n6_agama,
            'n6_tempat_lahir' => $data->n6_tempat_lahir,
            'n6_binti' => $data->n6_binti,
            'n6_tipe_bin' => $data->n6_tipe_bin ?? '',
            'n6_nama_desa' => $data->desa->nama_desa,
            'n6_nama_kepala_desa' => $data->desa->kepala_desa,
            'n6_nama_kecamatan' => $data->desa->city->name,
            'n6_nama_kabupaten' => $data->desa->district->name ?? '',
            'n6_pekerjaan' => $data->pekerjaan->nama ?? '',
        ];

        if ($data->n6_jenis_kelamin === 'L') {
            $x = DataNikah::with('pekerjaans', 'pekerjaani')
                ->where('n6_id', $id)
                ->first();
            if ($x) {

                $results += [
                    'rel_nama' => $x->i_nama,
                    'rel_binti' => $x->ia_nama,
                    'rel_ttl' => $x->i_tempat_lahir . ', ' . $x->i_tanggal_lahir->formatLocalized('%A, %d %B %Y'),
                    'rel_kewarganegaraan' => $x->i_status_warganegara,
                    'rel_pekerjaan' => $x->pekerjaani->nama,
                    'rel_agama' => $x->i_nama,
                    'rel_alamat' => $x->i_alamat,
                ];
            }
        } else {
            $x = DataNikah::where('n6_id', $id)->first();

            if ($x) {
                $results += [
                    'rel_nama' => $x->nama,
                    'rel_binti' => $x->sa_nama,
                    'rel_ttl' => $x->tempat_lahir . ', ' . $x->tanggal_lahir->formatLocalized('%A, %d %B %Y'),
                    'rel_kewarganegaraan' => $x->status_warganegara,
                    'rel_pekerjaan' => $x->pekerjaans->nama,
                    'rel_agama' => $x->nama,
                    'rel_alamat' => $x->alamat,
                ];
            }
        }

        $this->data = $results;
    }

    public function handlerPrint()
    {
        $url = app('DataN6Printer')->run($this->ids);
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
        $this->data = DataN6::find($id)->delete();
        $this->notification([
            'title' => 'Dokumen Hapus!',
            'description' => ' Dokumen berhasil dihapus, Selanjutnya anda akan di alihkan ke halaman sebelumnya',
            'icon' => 'success',
        ]);
        return $this->redirect(route('document', ['tab' => 'n6']), navigate: false);
    }
}; ?>
<div class="container  mx-auto mb-20">
    <div class="w-1/2 mx-auto">
        <div class="flex mb-2 gap-1">
            <x-button wire:click="handlerPrint()" label="Download Dokumen" positive icon="download" />
            <x-button wire:click="handlerRemove()" label="Hapus Dokumen" negative icon="trash" />


        </div>
        <div class="grid grid-cols-1 ">

            <x-card title="Data N6">

                <x-list title="Nomor Surat Keluar" value="{{ $data['n6_nomor_surat_keluar'] }}" />
                <x-list title="Tanggal Surat Keluar" value="{{ $data['n6_tanggal_surat_keluar'] }}" />
                <x-list title="TTD Aparat Desa" value="{{ $data['ttd_nama_aparat'] }}" />
                <x-list title="Nama" value="{{ $data['n6_nama'] }}" />
                <x-list title="Jenis Kelamin" value="{{ $data['n6_jenis_kelamin'] }}" />
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
        </div>

    </div>


</div>
