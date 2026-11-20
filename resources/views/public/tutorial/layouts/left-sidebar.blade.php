@extends('public.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('/public/assets/css/blog.css') }}">
@endpush

@section('content')

<div class="page-blog">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-3">
                @section('blog_sidebar')
                    @include('public.tutorial.layouts.sidebar')
                @show
            </div>
            <div class="col-md-9">
                <div class="blog-right">
                    @yield('blog_content')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
