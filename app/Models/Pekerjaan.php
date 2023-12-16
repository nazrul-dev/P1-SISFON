<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pekerjaan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nama'];

    protected $searchableFields = ['*'];



    public function dataNikahSuamis()
    {
        return $this->hasMany(DataNikahSuami::class);
    }

    public function dataNikahN6s()
    {
        return $this->hasMany(DataNikahN6::class);
    }
}
