<?php

namespace App\Models;

use App\Core\Enums\BlogType;
use App\Core\Enums\DefaultStatus;
use App\Core\Supports\CustomTranslations;
use App\Core\Supports\Eloquent\BaseModel;
use App\Core\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Page extends BaseModel
{
    use HasFactory, Sluggable, HasTranslations, CustomTranslations;

    protected $table = 'pages';

    protected $fillable = ['name', 'slug' , 'content', 'title_seo', 'desc_seo'];

    protected $columnSlug = 'name';


    protected function casts(): array
    {
        return [
            'status' => DefaultStatus::class,
        ];
    }

    public function isPublished()
    {
        return $this->status == DefaultStatus::Published;
    }

    public function author()
    {
        return $this->morphTo('author');
    }

    public function scopePublished($query)
    {
        return $query->where('status', DefaultStatus::Published);
    }

    public function scopeHasCategories($query, array $categoriesId)
    {
        return $query->whereHas('categories', function ($query) use ($categoriesId) {
            $query->whereIn('id', $categoriesId);
        });
    }

    public function scopeWActive($q)
    {
        $q->where('status', DefaultStatus::Published);
    }
}
