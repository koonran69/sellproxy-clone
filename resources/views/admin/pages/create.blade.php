@extends('admin.layouts.master')


@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.coin.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.coins.forms.create-left')
                    @include('admin.coins.forms.create-right')
                </div>
                @include('admin.commons.forms.actions-fixed')
            </x-core-form>
        </div>
    </div>
@endsection

@push('libs-js')
<script src="{{ asset('public/core/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/core/libs/ckeditor/adapters/jquery.js') }}"></script>
@include('ckfinder::setup')
@endpush


