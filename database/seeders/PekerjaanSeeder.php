<?php

namespace Database\Seeders;

use App\Models\Pekerjaan;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pekerjaans = array(
            "Guru/Dosen",
            "Dokter",
            "Perawat",
            "Programmer",
            "Penjual/Pelayan Toko",
            "Petani",
            "Pengacara",
            "Arsitek",
            "Akuntan",
            "Marketing/Pemasaran",
            "Insinyur",
            "Pilot/Pramugari",
            "Ahli Teknologi Informasi (IT)",
            "Desainer Grafis",
            "Karyawan Kantor/Administratif",
            "Pekerja Konstruksi",
            "Peneliti Ilmiah",
            "Penulis/Editor",
            "Pemandu Wisata",
            "Perawat Gigi",
            "Analyst Big Data",
            "Manajer Proyek Konstruksi",
            "Geoteknik Engineer",
            "Pemeta (Cartographer)",
            "Manajer Pengembangan Properti",
            "Pengawas Konstruksi",
            "Surveyor",
            "Teknisi Konstruksi",
            "Insinyur Transportasi",
            "Manajer Kualitas Konstruksi",
            "Ahli Drainase",
            "Perekayasa Infrastruktur Kota",
            "Kurator Museum",
            "Animator",
            "Pemrogram Game",
            "Manajer Pemasaran Digital",
            "Konsultan Bisnis",
            "Manajer Layanan Pelanggan",
            "Spesialis Kesehatan dan Keselamatan Kerja",
            "Ahli Lingkungan",
            "Konsultan Teknik Sipil",
            "Pustakawan",
            "Desainer Mode",
            "Ahli Keuangan",
            "Penyiar Online/Streamer",
            "Pemadam Kebakaran",
            "Paramedis",
            "Analyst Pasar Modal",
            "Montir Mobil/Motor",
            "Ahli Gizi",
            "Manajer Sumber Daya Manusia (HR)",
            "Pilot Drone",
            "Penyiar Radio/TV",
            "Petugas Layanan Darurat",
            "Manajer Restoran",
            "Manajer Keamanan Proyek",
            "Penjaga Taman Zoologi",
            "Ahli Perencanaan Kota",
            "Editor Video",
            "Konsultan Pernikahan",
            "Manajer Operasional Perusahaan",
            "Konsultan Sistem Informasi",
            "Penyiar Cuaca",
            "Desainer Interior",
            "Petugas Kesehatan Masyarakat",
            "Manajer Logistik",
            "Desainer Perhiasan",
            "Teknisi Medis",
            "Pegawai Negeri Sipil (PNS)",
            "Ahli Kriminologi",
            "Petugas Layanan Pelanggan Online",
            "Pemetaan Drone",
            "Manajer Proyek Lingkungan",
            "Peneliti Perubahan Iklim",
            "Pemrogram Robot",
            "Pengembang Aplikasi Mobile",
            "Asisten Virtual",
            "Manajer Media Sosial",
            "Konsultan Keuangan Pribadi",
            "Ahli Robotic Process Automation (RPA)",
            "Pemandu Wisata Virtual",
            "Asisten Penelitian",
            "Manajer Ekspor-Impor",
            "Spesialis Keamanan Siber",
            "Ahli Bioinformatika",
            "Peneliti Kanker",
            "Manajer Investasi",
            "Konsultan Perlindungan Data",
            "Pengembang Augmented Reality",
            "Pengamat Bencana Alam",
            "Manajer Hubungan Masyarakat",
            "Konsultan Manajemen Risiko",
            "Ahli Pemulihan Data",
            "Pemandu Petualangan Ekstrem",
            "Pemrogram Drone",
            "Desainer Grafis VR/AR",
            "Manajer Keuangan Proyek",
            "Ahli Penelitian Energi Terbarukan",
            "Pengembang Kecerdasan Buatan (AI)",
            "Pemandu Perjalanan Antariksa",
            "Manajer Pengelolaan Risiko",
            "Konsultan Riset Pasar",
            "Ahli Forensik",
            "Manajer Keberlanjutan",
            "Pengembang Aplikasi Blockchain",
            "Pemandu Tur Sejarah",
            "Pemrogram Realitas Virtual",
            "Manajer Inovasi Produk",
            "Konsultan Manajemen Keuangan",
            "Ahli Penelitian Biokimia",
            "Manajer Pengembangan Bisnis",
            "Pengembang Sistem Otomasi Rumah",
            "Manajer Konten Digital",
            "Konsultan Manajemen Supply Chain",
        );
        foreach($pekerjaans as $pekerjaan){
            Pekerjaan::create(
                [
                    'nama' => $pekerjaan,

                ]
            );
        }

    }
}
