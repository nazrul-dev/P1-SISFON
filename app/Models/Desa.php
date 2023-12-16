<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desa extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'logo',
        'n1',
        'n6',
        'active',
        'nama_desa',
        'kode_pos',
        'kepala_desa',
        'village_id',
        'district_id',
        'city_id',
        'province_id'
    ];

    protected $searchableFields = ['*'];
    protected $casts = [
        'active' => 'boolean',
    ];

    public function aparaturDesas()
    {
        return $this->hasMany(AparaturDesa::class);
    }

    public function userDesas()
    {
        return $this->hasMany(UserDesa::class);
    }

    public function dataNikahs()
    {
        return $this->hasMany(DataNikah::class);
    }

    public function datakua()
    {
        return $this->belongsTo(Datakua::class, 'kua_id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'code');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }
}
