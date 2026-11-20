<a href="{{ route('admin.customer.edit', $id) }}" class="btn btn-icon btn-warning">
    <i class="ti ti-edit"></i>
</a>
<button class="btn btn-icon btn-danger open-modal-delete" data-route="{{ route('admin.customer.delete', $id) }}" data-bs-toggle="modal" data-bs-target="#modalDelete">
    <i class="ti ti-trash"></i>
</button>