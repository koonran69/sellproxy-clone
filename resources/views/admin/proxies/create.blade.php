@extends('admin.layouts.master')

@push('css')
    <style>
        .ck-editor__editable {
            min-height: 150px;
            max-height: 600px;
            resize: vertical;
            overflow-y: auto !important;
        }

        .desc .ck-editor__editable {
            min-height: 200px;
            max-height: 8000px;
        }

        /* Ẩn powered by */
        .ck-powered-by {
            display: none !important;
        }

        .variation-select-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            display: none;
        }

        .variation-select-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .variation-option {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            user-select: none;
        }

        .variation-option:hover {
            border-color: #3498db;
            color: #3498db;
        }

        .variation-option.selected {
            background-color: #3498db;
            color: white;
            border-color: #3498db;
        }

        .variation-data-container {
            display: none;
        }

        .variation-title {
            background-color: #e1f0ff;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.proxy.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.proxies.forms.create-left')
                    @include('admin.proxies.forms.create-right')
                </div>
                @include('admin.commons.forms.actions-fixed')
            </x-core-form>
        </div>
    </div>
@endsection

@push('libs-js')
    <script src="{{ asset('public/core/libs/parsley/comparison.js') }}"></script>
    <script src="{{ asset('public/core/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/core/libs/ckeditor/adapters/jquery.js') }}"></script>
    @include('ckfinder::setup')
@endpush


@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        document.querySelectorAll('.simpleEditor').forEach((editorElement) => {
            ClassicEditor
                .create(editorElement, {
                    ckfinder: {
                        uploadUrl: '{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}'
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

    @include('admin.proxies.script.attribute')
@endpush
