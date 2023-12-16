<?php

namespace App\Printers;


use App\Models\{DataNikah};
use ZipArchive;
use Illuminate\Support\Str;

class DataNikahPrinter
{

    public function executionPrint($data, $kelamin, $pemohon, $outputFilePath, $templatePath, $n6)
    {

        try {
            if (!file_exists($templatePath)) {
                return response()->json(['message' => 'File template.docx not found'], 404);
            }
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

            if ($n6) {

                $dataN6FromDB = $kelamin === 'M' ? $data->n6 : $data->i_n6;
                $templateProcessor->setValues([
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
                ]);
            }
            $templateProcessor->setValues([

                'alamat_tempat_akad' => $data->alamat_tempat_akad,
                'pemohon' => $pemohon,
                'nama_kepala_kua' => $data->datakua->nama_kepala_kua,
                'nip_kepala_kua' => $data->datakua->NIP,
                'tanggal_surat_keluar' => $data->tanggal_surat_keluar->formatLocalized('%A, %d %B %Y'),
                'nama_desa' => $data->desa->nama_desa,
                'nama_kepala_desa' => $data->desa->kepala_desa,
                'kua_pencatatan' => $data->datakua->nama_kecamatan,
                'kua_pencatatan_provinsi' => $data->datakua->province->name,
                'nama_kecamatan' => $data->desa->city->name,
                'nama_kabupaten' => $data->desa->district->name ?? '',
                'nomor_surat_keluar' => $kelamin === 'F' ? $data->nomor_surat_keluar_i : $data->nomor_surat_keluar_s,
                'tanggal_diterima_kua' => $data->tanggal_diterima_kua->formatLocalized('%A, %d %B %Y'),
                'nama' => $data->nama,
                'nik' => $data->nik,
                'jenis_kelamin' => $kelamin === 'F' ? 'Perempuan' : 'Laki-laki',
                'tempat_lahir' => $data->tempat_lahir . ', ',
                'tanggal_lahir' => $data->tanggal_lahir->format('d-m-Y'),
                'status_warganegara' => $data->status_warganegara,
                'agama' => $data->agama,
                'pekerjaan' => $data->pekerjaans->nama,

                'alamat' => $data->alamat,
                'istri_ke' => $data->istri_ke ?? '...',
                'status_perkawinan' => $data->status_perkawinan,
                'tempat_akad' => $data->status_tempat_akad,
                'tanggal_akad' => $data->tanggal_akad->formatLocalized('%A, %d %B %Y') . ':' . $data->jam_akad,

                'i_nama' => $data->i_nama,
                'i_nik' => $data->i_nik,
                'i_tempat_lahir' => $data->i_tempat_lahir ? $data->i_tempat_lahir . ', ' : '..................................................................',
                'i_tanggal_lahir' => $data->i_tanggal_lahir->formatLocalized('%A, %d %B %Y'),
                'i_status_warganegara' => $data->i_status_warganegara,
                'i_suami_ke' => $data->i_suami_ke ?? '...',
                'i_agama' => $data->agama,
                'i_pekerjaan' => $data->pekerjaani->nama,
                'i_alamat' => $data->alamat,
                'i_status_perkawinan' => $data->i_status_perkawinan,

                'sa_nama' => $data->sa_nama,
                'sa_nik' => $data->sa_nik ?? '..................................................................',
                'sa_tempat_lahir' => $data->sa_tempat_lahir ? $data->sa_tempat_lahir . ', ' : '..................................................................',
                'sa_tanggal_lahir' => $data->sa_tanggal_lahir ? $data->sa_tanggal_lahir->formatLocalized('%A, %d %B %Y') : '',
                'sa_status_warganegara' => $data->sa_status_warganegara ?? '..................................................................',
                'sa_agama' => $data->sa_agama ?? '..................................................................',
                'sa_pekerjaan' => $data->pekerjaansuamiayah->nama ?? '..................................................................',
                'sa_alamat' => $data->sa_alamat ?? '..................................................................',
                'sa_binti' => $data->sa_binti ?? '..................................................................',

                'si_nama' => $data->si_nama,
                'si_nik' => $data->si_nik ?? '..................................................................',
                'si_tempat_lahir' => $data->si_tempat_lahir ? $data->si_tempat_lahir . ', ' : '..................................................................',
                'si_tanggal_lahir' => $data->si_tanggal_lahir ? $data->si_tanggal_lahir->formatLocalized('%A, %d %B %Y') : '',
                'si_status_warganegara' => $data->si_status_warganegara ?? '..................................................................',
                'si_agama' => $data->si_agama ?? '..................................................................',
                'si_pekerjaan' => $data->pekerjaansuamiibu->nama ?? '..................................................................',
                'si_alamat' => $data->si_alamat ?? '..................................................................',
                'si_binti' => $data->si_binti ?? '..................................................................',

                'ia_nama' => $data->ia_nama,
                'ia_nik' => $data->ia_nik ?? '..................................................................',
                'ia_tempat_lahir' => $data->ia_tempat_lahir ? $data->ia_tempat_lahir . ', ' : '..................................................................',
                'ia_tanggal_lahir' => $data->ia_tanggal_lahir ? $data->ia_tanggal_lahir->formatLocalized('%A, %d %B %Y') : '',
                'ia_status_warganegara' => $data->ia_status_warganegara ?? '..................................................................',
                'ia_agama' => $data->ia_agama ?? '..................................................................',
                'ia_pekerjaan' => $data->pekerjaanistriayah->nama ?? '..................................................................',
                'ia_alamat' => $data->ia_alamat ?? '..................................................................',
                'ia_binti' => $data->ia_binti ?? '..................................................................',

                'ii_nama' => $data->ii_nama,
                'ii_nik' => $data->ii_nik ?? '..................................................................',
                'ii_tempat_lahir' => $data->ii_tempat_lahir ? $data->ii_tempat_lahir . ', ' : '..................................................................',
                'ii_tanggal_lahir' => $data->ii_tanggal_lahir ? $data->ii_tanggal_lahir->formatLocalized('%A, %d %B %Y') : '',
                'ii_status_warganegara' => $data->ii_status_warganegara ?? '..................................................................',
                'ii_agama' => $data->ii_agama ?? '..................................................................',
                'ii_pekerjaan' => $data->pekerjaanistriibu->nama ?? '..................................................................',
                'ii_alamat' => $data->ii_alamat ?? '..................................................................',
                'ii_binti' => $data->ii_binti ?? '..................................................................',

                'ttd_jabatan_aparat' => $data->ttd_aparat->jabatan->nama,
                'ttd_nama_aparat' => $data->ttd_aparat->nama,
                'ttd_nip' => $data->ttd_aparat->nip ?? '..................................................................',



            ]);



            $templateProcessor->saveAs($outputFilePath);

            return $outputFilePath;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function run($id)
    {
        try {
            $data = DataNikah::with('pekerjaans', 'ttd_aparat', 'n6', 'n6.pekerjaan', 'n6.desa', 'n6.desa.city', 'n6.desa.province', 'n6.desa.district', 'n6.ttd_aparat', 'pekerjaani', 'desa', 'desa.city', 'desa.province', 'desa.district')->find($id);

            $pemohon = [];
            if ($data->status_pemohon === 'calon suami') {
                $pemohon[] = [
                    'key' => 'M',
                    'nama' => $data->nama,
                    'nomor' => $data->nomor_surat_keluar_s,
                    'n6' => isset($data->n6) ? true : false,
                    'templates' => isset($data->n6) ? 'templates/template_doc_nikah_suami_n6.docx' : 'templates/template_doc_nikah_suami.docx',
                ];
            } elseif ($data->status_pemohon === 'calon istri') {
                $pemohon[] = [
                    'key' => 'F',
                    'nama' => $data->i_nama,
                    'nomor' => $data->nomor_surat_keluar_i,
                    'n6' => isset($data->i_n6) ? true : false,
                    'templates' => isset($data->i_n6) ? 'templates/template_doc_nikah_istri_n6.docx' : 'templates/template_doc_nikah_istri.docx',
                ];
            } else {
                $pemohon[] = [
                    'key' => 'M',
                    'nama' => $data->nama,
                    'nomor' => $data->nomor_surat_keluar_s,
                    'n6' => isset($data->n6) ? true : false,
                    'templates' => isset($data->n6) ? 'templates/template_doc_nikah_suami_n6.docx' : 'templates/template_doc_nikah_suami.docx',
                ];
                $pemohon[] = [
                    'key' => 'F',
                    'nama' => $data->i_nama,
                    'nomor' => $data->nomor_surat_keluar_i,
                    'n6' => isset($data->i_n6) ? true : false,
                    'templates' => isset($data->i_n6) ? 'templates/template_doc_nikah_istri_n6.docx' : 'templates/template_doc_nikah_istri.docx',
                ];
            }

            if (count($pemohon) > 1) {
                $zipFileName = 'document-nikah-' . date('ymdhis') . '.zip';
                $zipFilePath = public_path($zipFileName);
                $zip = new ZipArchive();
                $docsPath = [];
                if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                    foreach ($pemohon as  $value) {
                        $outputFilePath = public_path($value['key'] . '-' . Str::slug($value['nama']) . '.docx');
                        $templatePath = public_path($value['templates']);
                        $this->executionPrint($data,  $value['key'], $value['nama'], $outputFilePath, $templatePath, $value['n6']);
                        $zip->addFile($outputFilePath,  $value['key'] . '-' . Str::slug($value['nama']) . '.docx');
                        $docsPath[] = $outputFilePath;
                    }

                    $zip->close();

                    foreach ($docsPath as $docs) {
                        unlink($docs);
                    }

                    return $zipFilePath;
                }
            } else {
                $outputFilePath =  public_path('document-nikah-' . date('ymdhis') . '-' . $pemohon[0]['nomor'] . '-.docx');
                $templatePath = public_path($pemohon[0]['templates']);
                $url = $this->executionPrint($data, $pemohon[0]['key'], $pemohon[0]['nama'], $outputFilePath, $templatePath, $pemohon[0]['n6']);
                return $url;
            }
        } catch (\Throwable $th) {
           return $th->getMessage();
        }
    }
}
