<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [

        'site_name',

        'author_name',

        'author_description',

        'hero_title',

        'hero_subtitle',

        'hero_type_text',

        'facebook_url',

        'instagram_url',

        'youtube_url',

        'copyright_text',

        'header_logo',

        'footer_logo',

        'favicon',

        'author_image',

        'hero_image',

        'footer_title_1',

        'footer_title_2',

        'footer_title_3',

        'footer_title_4',

        'phone',
        'email',
        'address',
        'google_map',

    ];
}
