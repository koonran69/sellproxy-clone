@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.blog.post.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$post->id" />
                <div class="row justify-content-center">
                    @include('admin.blog.posts.forms.edit-left')
                    @include('admin.blog.posts.forms.edit-right')
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

