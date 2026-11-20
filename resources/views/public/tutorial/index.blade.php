@extends('public.tutorial.layouts.left-sidebar')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@section('blog_content')
    <div class="cat-content">
        @if (isset($category))
            <h3 class="blog-title">{{ $category->getTranslate('name') }}</h3>
        @endif
        <div class="post-list">
            @foreach ($posts as $post)
                <div class="post-item-loop">
                    <a href="{{ route('tutorial.post.show', $post->slug) }}">
                        <div class="feature-image">
                            <img src="{{ asset($post->feature_image) }}" alt="">
                        </div>
                    </a>

                    <div class="info-post">
                        <a href="{{ route('tutorial.post.show', $post->slug) }}">
                            <h4 class="title-post-item">{{ $post->getTranslate('title') }}</h4>
                        </a>
                        <div class="short-desc">
                            {!! $post->getTranslate('excerpt') !!}
                        </div>
                        <div class="posted-at">{{ $post->posted_at->diffForHumans() }}
                        </div>
                        <div class="">
                            <a href="{{ route('tutorial.post.show', $post->slug) }}" class="read-more">@lang('Đọc tiếp')
                                <svg xmlns="http://www.w3.org/2000/svg" width="14.042" height="11"
                                    viewBox="0 0 14.042 11" class="my-auto !ml-1">
                                    <g id="arrow" transform="translate(-2.5 -85.833)">
                                        <g id="Group_192" data-name="Group 192" transform="translate(0 85.333)">
                                            <path id="Path_564" data-name="Path 564"
                                                d="M15.9,91.068l-5-4.625a.308.308,0,0,0-.471,0,.409.409,0,0,0,0,.53l4.431,3.985H3.333a.378.378,0,0,0,0,.75H14.862l-4.431,3.985a.409.409,0,0,0,0,.53.308.308,0,0,0,.471,0l5-4.625A.409.409,0,0,0,15.9,91.068Z"
                                                transform="translate(0 -85.333)" fill="none" stroke="currentColor"
                                                stroke-width="1"></path>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
