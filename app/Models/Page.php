<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'title',

        'slug',

        'content',

        'banner_image',

        'meta_title',

        'meta_description',

        'meta_keywords',

        'status',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {

            $page->slug = Str::slug($page->title);
        });

        static::updating(function ($page) {

            $page->slug = Str::slug($page->title);
        });
    }
}
