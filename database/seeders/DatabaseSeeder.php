<?php

namespace Database\Seeders;

use App\Models\Datakua;
use App\Models\DataNikah;
use App\Models\Desa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'nasrul',
                'nip' => '112233344',
                'telepon' => '082291462750',
                'email' => 'nazrul.dev@gmail.com',
                'password' => Hash::make('015999wisna'),
                'role_user' =>'superadmin',
            ]);



        $this->call(ProvincesSeeder::class);
        $this->call(JabatanSeeder::class);
        $this->call(PekerjaanSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(DistrictsSeeder::class);
        $this->call(VillagesSeeder::class);

        Datakua::create([
            'nama_kecamatan' =>  'DENGILO',
            'district_id' => '750408',
            'city_id' => '7504',
            'province_id' => '75',
            'nama_kepala_kua' => 'JASWADI, S.Ag',
            'di_luar_kabupaten' => false
        ]);
        Datakua::create([
            'nama_kecamatan' =>  'PAGUAT',
            'district_id' => '750405',
            'city_id' => '7504',
            'province_id' => '75',
            'nama_kepala_kua' => 'UMAR ARABAA, S.Ag',
            'di_luar_kabupaten' => false
        ]);
        Datakua::create([
            'nama_kecamatan' =>  'MARISA',
            'district_id' => '750404',
            'city_id' => '7504',
            'province_id' => '75',
            'nama_kepala_kua' => 'ABDULLAH HASANUDIN, S.Fil.I',
            'di_luar_kabupaten' => false
        ]);
        Datakua::create([
            'nama_kecamatan' =>  'DUHIADAA',
            'district_id' => '750410',
            'city_id' => '7504',
            'province_id' => '75',
            'nama_kepala_kua' => 'SABRUN HARAS, S.HI',
            'di_luar_kabupaten' => false
        ]);
        $kua = Datakua::create([
            'nama_kecamatan' =>  'BUNTULIA',
            'district_id' => '750409',
            'city_id' => '7504',
            'province_id' => '75',
            'nama_kepala_kua' => 'LALAN JAELANI, S.HI',
            'di_luar_kabupaten' => false
        ]);

        $desa = Desa::create([
            'active' => true,
            'kua_id' => $kua->id,
            'n1' => '800/SN1/DBT-BTLA/',
            'n6' => '800/SN1/DBT-BTLA/',
            'nama_desa' => 'Buntulia Tengah',
            'kode_pos' => '96181',
            'kepala_desa' => 'ABDUL LATIF BIN HOLA, SH',
            'village_id' => '7504092005',
            'district_id' => '750409',
            'city_id' => '7504',
            'province_id' => '75',
        ]);

        User::create([
            'email' => 'demo4@demo.com',
            'name' => 'demo4',
            'nip' => '112233344',
            'telepon' => '082291462750',
            'jabatan_id' => '1',
            'kua_id' => $kua->id,
            'tipe_user' => 'kua',
            'role_user' =>'admin',
            'password' => Hash::make('demo123'),
        ]);
        User::create([
            'email' => 'demo3@demo.com',
            'name' => 'demo3',
            'nip' => '112233344',
            'telepon' => '082291462750',
            'jabatan_id' => '3',
            'kua_id' => $kua->id,
            'tipe_user' => 'kua',
            'role_user' =>'operator',
            'password' => Hash::make('demo123'),
        ]);

        User::create([
            'email' => 'demo1@demo.com',
            'name' => 'demo1',
            'nip' => '112233344',
            'telepon' => '082291462750',
            'jabatan_id' => '2',
            'desa_id' => $desa->id,
            'kua_id' => $kua->id,
            'tipe_user' => 'desa',
            'role_user' =>'admin',
            'password' => Hash::make('demo123'),
        ]);
        User::create([
            'email' => 'demo2@demo.com',
            'name' => 'demo2',
            'nip' => '112233344',
            'telepon' => '082291462750',
            'jabatan_id' => '5',
            'desa_id' => $desa->id,
            'kua_id' => $kua->id,
            'tipe_user' => 'desa',
            'role_user' =>'operator',
            'password' => Hash::make('demo123'),
        ]);
        // DataNikah::factory(100)->create();
    }
}
