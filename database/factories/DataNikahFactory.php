<?php

namespace Database\Factories;

use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravolt\Indonesia\Models\District;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataNikah>
 */
class DataNikahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    function generateRandomTime()
    {
        $hour = str_pad(mt_rand(0, 23), 2, '0', STR_PAD_LEFT); // Menghasilkan angka acak antara 00 dan 23
        $minute = str_pad(mt_rand(0, 59), 2, '0', STR_PAD_LEFT); // Menghasilkan angka acak antara 00 dan 59

        return "$hour:$minute";
    }

    function generateRandomBirthdate()
    {
        $now = Carbon::now();
        $minBirthdate = $now->subYears(32);
        $maxBirthdate = $now->subYears(17);

        $randomBirthdate = Carbon::createFromTimestamp(mt_rand($minBirthdate->timestamp, $maxBirthdate->timestamp));

        return $randomBirthdate->toDateString(); // Format YYYY-MM-DD
    }
    public function definition(): array
    {
        $now = Carbon::now();
        $tanggalLahir = fake()->dateTimeBetween('-54 years', '-18 years');

        $options1 = [
            'Balai Nikah',
            'Kediaman Mempelai Perempuan',
            'Kediaman Mempelai Laki-laki',
            'Masjid/Musholla',
            'Gedung',
        ];

        $option2 = [
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
        ];
        $option3 = [
            'Prof',
            'Dr',
            'dr',
            'Drs',
            'Ns',
            'Dr.dr',
        ];

        $randomS = rand(750404, 750410);
        $villageCodesS = Village::where('district_code', $randomS)->pluck('code')->toArray();
        $randomI = rand(750404, 750410);
        $villageCodesI = Village::where('district_code', $randomS)->pluck('code')->toArray();
        $religions = ['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Kong Hu Cu'];


        $maritalStatuses = ['Jejaka',  'Duda (Cerai Hidup)', 'Beristri'];
        $maritalStatuses1 = ['Janda',  'Perawan'];
        $xx = ['kua',  'desa'];
        // Randomly select a marital status
        $sp = $maritalStatuses[array_rand($maritalStatuses)];


        return [
            'status_pemohon' => 'calon suami',
            'diinput_dari' =>  $xx[array_rand($xx)],
            'desa_id' => 1,
            'nomor_terakhir' => mt_rand(pow(10, 4), pow(10, 5) - 1),
            'nomor_urut' => mt_rand(pow(10, 4), pow(10, 5) - 1),
            'nomor_surat_keluar_s' => mt_rand(pow(10, 4), pow(10, 5) - 1),
            'nomor_surat_keluar_i' => mt_rand(pow(10, 4), pow(10, 5) - 1),
            'tanggal_surat_keluar' => Carbon::now()->subDays(rand(1, 10)),
            'tanggal_akad' => Carbon::now()->subDays(rand(1, 10)),
            'jam_akad' => $tanggalLahir->format('Y-m-d'),
            'status_tempat_akad' => $options1[array_rand($options1)],
            'alamat_tempat_akad' => $options1[array_rand($options1)],
            'saksi1' => fake()->name(),
            'saksi2' => fake()->name(),
            'kua_pencatatan' => rand(1, 5),
            'ttd_aparat_id' =>  1,
            'tanggal_diterima_kua' => Carbon::now(),


            // SUAMI

            'nama' => fake()->name(),
            'gelar_belakang' => $option3[array_rand($option3)],
            'pendidikan_terakhir' => $option2[array_rand($option2)],
            'nama_panggilan' => fake()->name(),
            's_yatim' => true,
            's_piatu' => true,
            'tempat_lahir' => fake()->address(),
            'tanggal_lahir' =>  $now->subYears(rand(18, 54))->format('Y-m-d'),
            'nik' => mt_rand(pow(10, 4), pow(10, 5) - 1),
            'agama' =>  $religions[array_rand($religions)],
            'alamat' => fake()->address(),
            'village_id' => $villageCodesS[array_rand($villageCodesS)],
            'kecamatan_id' => $randomS,
            'kabupaten_id' => '7504',
            'provinsi_id' => '75',
            'status_perkawinan' => $sp,
            'nomor_handphone' => fake()->phoneNumber(),
            'status_warganegara' => 'WNI',
            'pekerjaan_id' => rand(1, 70),
            'istri_ke' => $sp != 'Jejaka' ?  rand(1, 4) : null,

            // ISTRI

            'i_nama' => fake()->name(),
            'i_gelar_belakang' => $option3[array_rand($option3)],
            'i_pendidikan_terakhir' => $option2[array_rand($option2)],
            'i_nama_panggilan' => fake()->name(),
            'i_yatim' => true,
            'i_piatu' => true,
            'i_tempat_lahir' => fake()->address(),
            'i_nik' => mt_rand(pow(10, 4), pow(10, 5) - 1),
            'i_agama' =>  $religions[array_rand($religions)],
            'i_alamat' => fake()->address(),
            'i_village_id' => $villageCodesI[array_rand($villageCodesI)],
            'i_kecamatan_id' => $randomI,
            'i_kabupaten_id' => '7504',
            'i_provinsi_id' => '75',
            'i_status_perkawinan' => $maritalStatuses1[array_rand($maritalStatuses1)],
            'i_nomor_handphone' => fake()->phoneNumber(),
            'i_status_warganegara' => 'WNI',
            'i_tanggal_lahir' =>  $now->subYears(rand(18, 54))->format('Y-m-d'),
            'i_pekerjaan_id' => rand(1, 70),

            // ORTU SUAMI

            'sa_nama' => fake()->name(),


            // --

            'si_nama' => fake()->name(),



            // ORTU ISTRI

            'ia_nama' => fake()->name(),

            // --
            'ii_nama' => fake()->name(),

        ];
    }
}
