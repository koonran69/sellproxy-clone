<?php

namespace App\Admin\DataTables\Blog\Post;

use App\Core\DataTables\DataTables;
use App\Core\Enums\BlogType;
use App\Core\Enums\DefaultStatus;
use App\Models\Post;

class PostDataTable extends DataTables
{
    public string $prefixConfig = 'datatables_columns.blog';

    public function __construct(public Post $model)
    {
    }


    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['title', 'status', 'categories', 'author', 'created_at', 'type_post'];
    }

    protected function setColumnSearchDate(): void
    {
        $this->columnSearchDate = ['created_at'];
    }

    protected function setColumnSearchSelect(): void
    {
        $this->columnSearchSelect = [
            'status' => [
                'data' => DefaultStatus::asSelectArray(),
            ],
            'type_post' => [
                'data' => $this->typeSearchData(),
            ],
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->model->makeQuery(['type' => BlogType::Blog]);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'title' => 'admin.blog.posts.datatable.title',
            'feature_image' => 'admin.blog.posts.datatable.feature-image',
            'status' => 'admin.commons.datatable.status',
            'type_post' => 'admin.blog.posts.datatable.type_post',
            'categories' => fn($item) => $item->categories ? $item->categories->pluck('name')->implode(', ') : 'No Categories',
            'author' => fn($item) => $item->admin->fullname ?? '',
            'created_at' => '{{ format_date($created_at) }}',
        ];
    }
    protected function setFilterColumns(): void
    {
        $this->filterColumns = [
            'categories' => function ($query, $keyword) {
                $query->whereHas('categories', function ($q) use ($keyword) {
                    $q->whereIn('id', explode(',', $keyword));
                });
            },
            'author' => fn($q, $k) => $q->whereRelation('author', 'fullname', 'like', '%' . $k . '%'),
            'type_post' => function ($q, $k) {
                $this->handleFilterTypePost($q, $k);
            },
        ];
    }
    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'languages' => 'admin.blog.posts.datatable.languages',
            'action' => 'admin.blog.posts.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['feature_image', 'status', 'categories', 'action', 'created_at', 'type_post', 'title', 'languages'];
    }

    private function typeSearchData()
    {
        return [
            0 => __('Regular'),
            10 => __('Hot'),
            20 => __('Featured'),
        ];
    }
    private function handleFilterTypePost($q, $k)
    {
        switch ($k) {
            case 10:
                return $q->where('is_hot', 1);
            case 20:
                return $q->where('is_feature', 1);
            default:
                return $q->where('is_hot', 0)->where('is_feature', 0);
        }
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'feature_image' => [
                'title' => 'image',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'title' => [
                'title' => 'title',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'status' => [
                'title' => 'status',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'categories' => [
                'title' => 'category',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'languages' => [
                'title' => '<div class="d-flex gap-3 justify-content-center"><span class="flag-vi"></span> <span class="flag-en"></span></div>',
                'orderable' => false,
            ],
            'created_at' => [
                'title' => 'createdAt',
                'orderable' => false,
                'addClass' => 'align-middle',
                'visible' => false
            ],
            'action' => [
                'title' => 'action',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'text-center align-middle'
            ],
        ];
    }
}
