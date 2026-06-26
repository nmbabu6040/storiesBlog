<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'thumbnail',
        'content',
        'meta_title',
        'meta_description',
        'views',
        'featured',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getReadingTimeAttribute()
    {
        return max(
            1,
            ceil(str_word_count(strip_tags($this->content)) / 200)
        );
    }

    public function getFormattedViewsAttribute()
    {
        if ($this->views >= 1000000) {
            return round($this->views / 1000000, 1) . 'M';
        }

        if ($this->views >= 1000) {
            return round($this->views / 1000, 1) . 'K';
        }

        return number_format($this->views);
    }
}
