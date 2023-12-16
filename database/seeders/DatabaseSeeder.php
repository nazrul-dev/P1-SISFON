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

        \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'nazrul',
                'nip' => '7423444',
                'telepon' => '08229234262750',
                'email' => 'nazrul.dev@gmail.com',
                'password' => Hash::make('password'),
                'role_user' => 'superadmin',
            ]);


        \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'superadmin',
                'nip' => '749058303458343',
                'telepon' => '082291462750',
                'email' => 'superadmin@demo.com',
                'password' => Hash::make('password'),
                'role_user' => 'superadmin',
            ]);

        \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'admin-kua',
                'nip' => '654334334343',
                'telepon' => '3453453434',
                'email' => 'admin-kua@demo.com',
                'password' => Hash::make('password'),
                'role_user' => 'admin',
                'tipe_user' => 'kua',
                'kua_id' =>  $kua->id,
                'jabatan_id' => 5,
            ]);

        \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'operator-kua',
                'nip' => '654334334332443',
                'telepon' => '34534523423434',
                'email' => 'operator-kua@demo.com',
                'password' => Hash::make('password'),
                'role_user' => 'operator',
                'tipe_user' => 'kua',
                'kua_id' =>  $kua->id,
                'jabatan_id' => 5,
            ]);

        \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'admin-desa',
                'nip' => '55334543534',
                'telepon' => '23443531232',
                'email' => 'admin-desa@demo.com',
                'password' => Hash::make('password'),
                'role_user' => 'admin',
                'tipe_user' => 'desa',
                'desa_id' => $desa->id,
                'jabatan_id' => 5,
            ]);


        \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'operator-desa',
                'nip' => '5533451243534',
                'telepon' => '234435123123',
                'email' => 'operator-desa@demo.com',
                'password' => Hash::make('password'),
                'role_user' => 'operator',
                'tipe_user' => 'desa',
                'desa_id' => $desa->id,
                'jabatan_id' => 5,
            ]);



        // DataNikah::factory(100)->create();
    }
}
