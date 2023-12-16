<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataNikah extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $table = 'data_nikahs';

    protected $casts = [
        'tanggal_akad' => 'datetime',
        'tanggal_diterima_kua' => 'datetime',
        'tanggal_surat_keluar' => 'datetime',
        'tanggal_akad' => 'datetime',
        'tanggal_diterima_kua	' => 'datetime',
        'tanggal_lahir' => 'datetime',
        'i_tanggal_lahir' => 'datetime',
        'sa_tanggal_lahir' => 'datetime',
        'si_tanggal_lahir' => 'datetime',
        'ia_tanggal_lahir' => 'datetime',
        'ii_tanggal_lahir' => 'datetime',

    ];


    // PEKERJAAN


    public function pekerjaans()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }
    public function pekerjaani()
    {
        return $this->belongsTo(Pekerjaan::class, 'i_pekerjaan_id');
    }

    public function pekerjaansuamiayah()
    {
        return $this->belongsTo(Pekerjaan::class, 'sa_pekerjaan_id');
    }

    public function pekerjaansuamiibu()
    {
        return $this->belongsTo(Pekerjaan::class, 'si_pekerjaan_id');
    }


    public function pekerjaanistriayah()
    {
        return $this->belongsTo(Pekerjaan::class, 'ia_pekerjaan_id');
    }

    public function pekerjaanistriibu()
    {
        return $this->belongsTo(Pekerjaan::class, 'ii_pekerjaan_id');
    }


    // PEKERJAAN



    public function ttd_aparat()
    {
        return $this->belongsTo(AparaturDesa::class, 'ttd_aparat_id');
    }



    public function datakua()
    {
        return $this->belongsTo(Datakua::class, 'kua_pencatatan');
    }


    public function n6()
    {
        return $this->belongsTo(DataN6::class, 'n6_id');
    }

    public function i_n6()
    {
        return $this->belongsTo(DataN6::class, 'i_n6_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pencetak_id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
