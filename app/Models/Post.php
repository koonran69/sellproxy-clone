<?php

namespace App\Models;

use App\Core\Enums\BlogType;
use App\Core\Enums\DefaultStatus;
use App\Core\Supports\CustomTranslations;
use App\Core\Supports\Eloquent\BaseModel;
use App\Core\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Post extends BaseModel
{
    use HasFactory, Sluggable, HasTranslations, CustomTranslations;

    protected $table = 'posts';

    protected $fillable = ['admin_id', 'title', 'slug', 'is_feature', 'is_hot', 'feature_image', 'status', 'excerpt', 'content', 'viewed', 'title_seo', 'desc_seo', 'posted_at', 'type'];

    protected $columnSlug = 'title';

    public $translatable = ['title', 'content', 'excerpt', 'title_seo', 'desc_seo'];

    protected function casts(): array
    {
        return [
            'status' => DefaultStatus::class,
            'posted_at' => 'datetime',
            'type' => BlogType::class
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'posts_to_categories', 'post_id', 'category_id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
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
