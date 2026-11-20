@extends('public.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('/public/assets/css/blog.css') }}">
@endpush

@section('content')

<div class="page-blog">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-9">
                @yield('blog_content')
            </div>
            <div class="col-md-3">
                <h3 class="border-bottom pb-2">@lang('Bài viết liên quan')</h3>
                @if($relatedPosts)
                    @foreach($relatedPosts as $p)
                        <div class="list-group">
                            <a href="{{ route('blog.post.show', $p->slug) }}" class="list-group-item list-group-item-action d-flex mb-4">
                                <img src="{{ asset($p->feature_image) }}" class="rounded me-2" alt="thumb">
                                <div>
                                    <h3 class="mb-1">{{ $p->getTranslate('title') }}</h3>
                                    <small class="text-muted">{{ $p->posted_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p>@lang('Không có bài viết')</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
