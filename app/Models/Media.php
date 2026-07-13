<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;
    protected $fillable = [

        'user_id',

        'file_name',

        'file_path',

        'file_type',

        'file_size',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
