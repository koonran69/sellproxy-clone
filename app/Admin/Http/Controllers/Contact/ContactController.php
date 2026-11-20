<?php

namespace App\Admin\Http\Controllers\Contact;

use App\Admin\DataTables\Contact\ContactDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Core\Repositories\Contact\ContactRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ContactController extends Controller
{

    public function __construct(
        protected ContactRepositoryInterface $repository,
    ) {
    }

    public function index(ContactDataTable $datatable): View|JsonResponse
    {
        return $datatable->render('admin.contacts.index', [
            'breadcrums' => $this->breadcrums()->add(trans('Contact'))
        ]);
    }
}
