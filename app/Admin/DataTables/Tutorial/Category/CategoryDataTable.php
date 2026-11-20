<?php

namespace App\Admin\DataTables\Tutorial\Category;

use App\Core\DataTables\DataTables;
use App\Core\Enums\BlogType;
use App\Core\Enums\DefaultStatus;
use App\Models\Category;

class CategoryDataTable extends DataTables
{
    public function __construct(
        public Category $model
    ) {

    }

    protected function setColumnHasSearch(): void
    {
        $this->columnHasSearch = ['name', 'status'];
    }

    protected function setColumnSearchSelect(): void
    {
        $status = array_values(DefaultStatus::asSelectArray());

        $this->columnSearchSelect = [
            'status' => [
                'data' => array_combine($status, $status)
            ]
        ];
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Category $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function query()
    {
        return $this->model->getFlatTree(['type' => BlogType::Tutorial]);
    }

    protected function makeBuilderDataTable($query): void
    {
        $this->instanceDataTable = datatables()->collection($query);
    }

    protected function setEditColumns(): void
    {
        $this->editColumns = [
            'name' => fn($item) => generate_text_depth_tree($item->depth) . ' ' . __($item->name),
            'status' => 'admin.commons.datatable.status',
            'created_at' => '{{ format_date($created_at) }}'
        ];
    }

    protected function setAddColumns(): void
    {
        $this->addColumns = [
            'languages' => 'admin.tutorial.categories.datatable.languages',
            'action' => 'admin.tutorial.categories.datatable.action',
        ];
    }

    protected function setRawColumns(): void
    {
        $this->rawColumns = ['name','status', 'action', 'languages'];
    }

    protected function setConfigColumns(): void
    {
        $this->configColumns = [
            'name' => [
                'title' => 'name',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'status' => [
                'title' => 'status',
                'orderable' => false,
                'addClass' => 'align-middle'
            ],
            'languages' => [
                'title' => '<div class="d-flex gap-3 justify-content-center"><span class="flag-vi"></span> <span class="flag-en"></span></div>',
                'orderable' => false,
            ],
            'action' => [
                'title' => 'action',
                'orderable' => false,
                'exportable' => false,
                'printable' => false,
                'addClass' => 'text-center'
            ],
        ];
    }
}
