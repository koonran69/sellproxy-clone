@extends('admin.layouts.master')

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/core/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/core/libs/select2/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@push('css')
    <style>
        .quantity-wrapper {
            display: flex;
            align-items: center;
        }

        .quantity-wrapper .btn {
            height: 20px;
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .quantity-wrapper .quantity {
            border: none;
            width: 30px;
            text-align: center;
            padding: 0;
            height: 32px;
            pointer-events: none;
        }
    </style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.order.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.orders.forms.create-left')
                    @include('admin.orders.forms.create-right')
                </div>
                @include('admin.commons.forms.actions-fixed')
            </x-core-form>
        </div>
    </div>
@endsection

@include('admin.orders.partials.modal-add-products')

@push('libs-js')
    <script src="{{ asset('public/core/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/core/libs/ckeditor/adapters/jquery.js') }}"></script>

    <script src="{{ asset('/public/core/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/core/libs/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js') }}"></script>
@endpush

@push('js')
    @include('admin.orders.script.script')
@endpush
