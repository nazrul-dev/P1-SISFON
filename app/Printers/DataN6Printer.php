<?php

namespace App\Printers;


use App\Models\{DataN6, DataNikah};


class DataN6Printer
{

    public function executionPrint($data,  $outputFilePath, $templatePath)
    {

        try {
            if (!file_exists($templatePath)) {
                return response()->json(['message' => 'File template.docx not found'], 404);
            }
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
            if ($data->n6_jenis_kelamin === 'L') {
                $x = DataNikah::with('pekerjaans', 'pekerjaani')
                    ->where('n6_id', $data->id)
                    ->first();
                if ($x) {

                    $templateProcessor->setValues([
                        'rel_nama' => $x->i_nama,
                        'rel_nik' => $x->nik,
                        'rel_binti' => $x->ia_nama,
                        'rel_ttl' => $x->i_tempat_lahir . ', ' . $x->i_tanggal_lahir->formatLocalized('%A, %d %B %Y'),
                        'rel_kewarganegaraan' => $x->i_status_warganegara,
                        'rel_pekerjaan' => $x->pekerjaani->nama,
                        'rel_agama' => $x->i_nama,
                        'rel_alamat' => $x->i_alamat,
                    ]);
                }else{
                    $templateProcessor->setValues([
                        'rel_nama' => '..................................................................',
                        'rel_nik' => '..................................................................',
                        'rel_binti' =>'..................................................................',
                        'rel_ttl' => '..................................................................',
                        'rel_kewarganegaraan' => '..................................................................',
                        'rel_pekerjaan' => '..................................................................',
                        'rel_agama' => '..................................................................',
                        'rel_alamat' => '..................................................................',
                    ]);
                }
            } else {
                $x = DataNikah::where('n6_id', $data->id)->first();

                if ($x) {
                    $templateProcessor->setValues([
                        'rel_nama' => $x->nama,
                        'rel_nik' => $x->i_nik,
                        'rel_binti' => $x->sa_nama,
                        'rel_ttl' => $x->tempat_lahir . ', ' . $x->tanggal_lahir->formatLocalized('%A, %d %B %Y'),
                        'rel_kewarganegaraan' => $x->status_warganegara,
                        'rel_pekerjaan' => $x->pekerjaans->nama,
                        'rel_agama' => $x->nama,
                        'rel_alamat' => $x->alamat,
                    ]);
                }else{
                    $templateProcessor->setValues([
                        'rel_nama' => '..................................................................',
                        'rel_nik' => '..................................................................',
                        'rel_binti' =>'..................................................................',
                        'rel_ttl' => '..................................................................',
                        'rel_kewarganegaraan' => '..................................................................',
                        'rel_pekerjaan' => '..................................................................',
                        'rel_agama' => '..................................................................',
                        'rel_alamat' => '..................................................................',
                    ]);
                }
            }

            $templateProcessor->setValues([
                'n6_nomor_surat_keluar' => $data->n6_nomor_surat_keluar,
                'n6_tanggal_surat_keluar' => $data->tanggal_surat_keluar->formatLocalized('%A, %d %B %Y'),
                'n6_nama' => $data->n6_nama,
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
            $data = DataN6::with('pekerjaan', 'ttd_aparat', 'desa', 'desa.city', 'desa.province', 'desa.district')->find($id);
            $outputFilePath =  public_path('document-n6-' . date('ymdhis') . '-' . $data->n6_nomor_surat_keluar . '-.docx');
            $templatePath = public_path('templates/template_doc_n6.docx');
            $url = $this->executionPrint($data,  $outputFilePath, $templatePath);
            return $url;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
