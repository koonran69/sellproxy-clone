@extends('admin.layouts.master')


@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.proxy_country_available.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.proxy_country_available.forms.create-left')
                    @include('admin.proxy_country_available.forms.create-right')
                </div>
                @include('admin.commons.forms.actions-fixed')
            </x-core-form>
        </div>
    </div>
@endsection

@push('libs-js')
<script src="{{ asset('public/core/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/core/libs/ckeditor/adapters/jquery.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#checkAllCountries').on('change', function() {
            $('.country-checkbox').prop('checked', $(this).prop('checked'));
        });
        $('.country-checkbox').on('change', function() {
            if ($('.country-checkbox:checked').length === $('.country-checkbox').length) {
                $('#checkAllCountries').prop('checked', true);
            } else {
                $('#checkAllCountries').prop('checked', false);
            }
        });
    });
</script>
@endpush

