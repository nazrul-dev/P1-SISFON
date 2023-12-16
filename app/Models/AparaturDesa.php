<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AparaturDesa extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    protected $searchableFields = ['*'];

    protected $table = 'aparatur_desas';

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }


    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
