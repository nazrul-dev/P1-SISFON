<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDesa extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['desa_id', 'user_id', 'hak_akses'];

    protected $searchableFields = ['*'];

    protected $table = 'user_desas';

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
