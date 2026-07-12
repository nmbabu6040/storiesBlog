<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'title',
        'position',
        'type',
        'code',
        'image',
        'url',
        'status',
        'sort_order'

    ];

    public function scopeActive($query, $position)
    {
        return $query->where('status', 1)
            ->where('position', $position)
            ->orderBy('sort_order');
    }
}
