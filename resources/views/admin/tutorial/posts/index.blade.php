@extends('admin.layouts.master')

@push('css')
    <style>
        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice{
            font-size: 0.7rem;
        }
        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice .select2-selection__choice__remove{
            width: 0.5rem;
            height: 0.5rem;
        }
        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice{
            align-items: center;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">@lang('list')</h2>
                    @adminaccessroutename('admin.tutorial.post.create')
                    <a href="{{ route('admin.tutorial.post.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus"></i>
                        <span>@lang('add')</span>
                    </a>
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
    </div>
@endsection

@push('libs-js')
<!-- button in datatable -->
<script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('js')

{{ $dataTable->scripts() }}

@include('admin.scripts.datatable-toggle-columns', [
    'id_table' => $dataTable->getTableAttribute('id')
])
@endpush
