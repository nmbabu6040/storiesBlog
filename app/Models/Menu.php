<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'name',

        'type',

        'url',

        'category_id',

        'page_slug',

        'menu_location',

        'target',

        'parent_id',

        'sort_order',

        'status'

    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->orderBy('sort_order');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getLinkAttribute()
    {
        switch ($this->type) {

            case 'custom':
                if ($this->url === '#') {
                    return 'javascript:void(0)';
                }
                return $this->url ?: '#';

            case 'page':
                return route('frontend.page', $this->page_slug);

            case 'category':
                return $this->category
                    ? route('frontend.category.show', $this->category->slug)
                    : '#';

            default:
                return '#';
        }
    }
}
