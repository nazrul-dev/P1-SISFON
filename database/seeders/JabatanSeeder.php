<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'Kepala',
            'Plt. Kepala',
            'Plh. Kepala',
            'Pj. Kepala',
            'Sekdes',
            'Kaur Pemerintahan',
        );

        foreach($data as $d){
            Jabatan::
           create([
                'nama' => $d
            ]);
        }


    }
}
