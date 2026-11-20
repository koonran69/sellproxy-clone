@extends('admin.layouts.master')
@push('libs-css')
    <link rel="stylesheet" href="{{ asset('public/core/libs/select2/css/select2.css') }}">
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.voucher.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.vouchers.forms.create-left')
                    @include('admin.vouchers.forms.create-right')
                </div>
                @include('admin.commons.forms.actions-fixed')
            </x-core-form>
        </div>
    </div>
@endsection

@push('libs-js')
<script src="{{ asset('public/core/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/core/libs/ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('public/core/libs/select2/js/select2.js') }}"></script>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('.select2-bs5').select2();
        });
    </script>
@endpush

