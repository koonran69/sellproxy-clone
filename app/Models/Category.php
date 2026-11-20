<?php

namespace App\Models;

use App\Core\Enums\BlogType;
use App\Core\Supports\CustomTranslations;
use Kalnoy\Nestedset\NodeTrait;
use App\Core\Enums\DefaultStatus;
use App\Core\Supports\Eloquent\BaseModel;
use App\Core\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Category extends BaseModel
{
    use HasFactory, NodeTrait, Sluggable, HasTranslations, CustomTranslations;

    protected $table = 'categories';

    protected $fillable = [
        '_lft',
        '_rgt',
        'parent_id',
        'name',
        'slug',
        'feature_image',
        'position',
        'status',
        'description',
        'title_seo',
        'desc_seo',
        'type'
    ];

    public $translatable = ['name', 'description', 'title_seo', 'desc_seo'];


    protected function casts(): array
    {
        return [
            'status' => DefaultStatus::class,
            'type' => BlogType::class
        ];
    }

    public function hasChildren()
    {
        return $this->children->count() > 0;
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_to_categories', 'category_id', 'post_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', DefaultStatus::Published);
    }

    public static function getToTree(array $filter = [], array $relations = [], $sort = ['position', 'ASC'])
    {
        $query = self::applyFilters($filter);
        $query = $query->orderBy(...$sort);
        $instance = $query->withDepth()
            ->get()
            ->toTree();

        return $instance;
    }

    public static function getFlatTree(array $filter = [], array $relations = [], $sort = ['position', 'ASC'])
    {
        $query = self::applyFilters($filter);
        $query = $query->orderBy(...$sort);
        $instance = $query->withDepth()
            ->get()
            ->toFlatTree();

        return $instance;
    }
}
?>

