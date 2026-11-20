<div class="blog-wrapper">
    <div class="container">
        <div class="blog-title-header text-center">
            <h1 class="display-5 fw-bold mb-4 text-dark lh-13 title-">@lang('Blog của')
                <span class="text-primary">Sellsocks247</span>
            </h1>
        </div>
        <div class="row g-5">
            @foreach ($posts as $post)
                <div class="col-6 col-lg-3">
                    <div class="box-blog-post">
                        <div class="box-image">
                            <a href="{{ route('blog.post.show', $post->slug) }}">
                                <img src="{{ asset($post->feature_image) }}" alt="{{ $post->title }}">
                            </a>
                        </div>
                        <div class="box-text text-left">
                            <h5 class="post-title">
                                <a href="{{ route('blog.post.show', $post->slug) }}">{{ $post->getTranslate('title') }}
                                </a>
                            </h5>
                            <a href="{{ route('blog.post.show', $post->slug) }}" class="btn-more">@lang('Xem thêm')</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
