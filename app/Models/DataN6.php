<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataN6 extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $table = 'data_n6';

    protected $casts = [
        'n6_tanggal_meninggal' => 'datetime',
        'n6_tanggal_lahir' => 'datetime',
        'tanggal_surat_keluar' => 'datetime',

    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'pencetak_id');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }


    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'n6_pekerjaan_id');
    }

    public function ttd_aparat()
    {
        return $this->belongsTo(AparaturDesa::class, 'ttd_aparat_id');
    }



}
