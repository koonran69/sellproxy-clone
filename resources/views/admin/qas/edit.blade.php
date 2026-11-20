@extends('admin.layouts.master')


@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.qa.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$qa->id" />
                <div class="row justify-content-center">
                    @include('admin.qas.forms.edit-left')
                    @include('admin.qas.forms.edit-right')
                </div>
                @include('admin.commons.forms.actions-fixed')
            </x-core-form>
        </div>
    </div>
@endsection

@push('libs-js')
<script src="{{ asset('public/core/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/core/libs/ckeditor/adapters/jquery.js') }}"></script>

@endpush
