@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">@lang('Danh sách biến thể') - <span class="fw-bold text-primary">{{ $attribute->name }}</span>
                    </h2>
                    @adminaccessroutename('admin.proxy.variation.create')
                        <button type="button" data-route="{{ route('admin.proxy.variation.create', $attribute->id) }}"
                            class="btn btn-primary open-modal-form">
                            <i class="ti ti-plus"></i>
                            <span>@lang('Thêm')</span>
                        </button>
                    @endadminaccessroutename
                </div>
                <div class="card-body">
                    <div class="table-responsive position-relative">
                        @include('admin.datatables.toggle-column-datatable')
                        {{ $dataTable->table(['class' => 'table table-bordered'], true) }}
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('libs-js')
        <!-- button in datatable -->
        <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>

        @include('ckfinder::setup')
    @endpush

    @push('js')
        {{ $dataTable->scripts() }}

        @include('admin.scripts.datatable-toggle-columns', [
            'id_table' => $dataTable->getTableAttribute('id'),
        ])
    @endpush
