<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Datakua extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    public function dataNikahs()
    {
        return $this->hasMany(DataNikah::class, 'kua_pencatatan');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }
}
