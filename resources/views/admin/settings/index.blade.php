@extends('admin.layouts.master')

@push('libs-css')
@endpush
@push('css')
    <style>
        .wrap-loop-input .add-image-ckfinder{
            width: auto !important;
        }
        #site_logo {
            width: 200px !important;
        }

    </style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.setting.update')" type="put" :validate="true">
                <x-input type="hidden" name="input_switch" :value="json_encode($input_switch)" :required="true" />
                <div class="row justify-content-center">
                    <div class="col-12 col-md-9">
                        @include('admin.settings.forms.edit-left')
                    </div>
                    @include('admin.settings.forms.edit-right')
                </div>
            </x-core-form>
        </div>
    </div>
@endsection

@push('libs-js')
@include('ckfinder::setup')
@endpush

@push('js')

@endpush
