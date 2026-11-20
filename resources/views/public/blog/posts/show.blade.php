@extends('public.blog.layouts.full-width')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle($meta_title) }}
@endsection

@section('blog_content')
    <div class="cat-content blog-single">
        <h3 class="title-post">{{ $post->getTranslate('title') }}</h3>
        <div class="posted-at mb-3">{{ $post->posted_at->diffForHumans() }}</div>
        <div class="feature-image text-center">
            <img src="{{ asset($post->feature_image) }}" alt="">
        </div>
        <div class="post-content">
            {!! $post->getTranslate('content') !!}
        </div>
    </div>
@endsection
