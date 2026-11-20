<section class="pricing-section py-5 section-fifth">
    <div class="container">
        <h3 class="display-5 text-white fw-bold text-center mb-6">@lang('Thuê Proxy với giá ưu đãi nhất tại Sellsocks247')</h3>
        <div class="row">
            <!-- Pricing Card -->
            <div class="swiper pricingList">
                <div class="swiper-wrapper">
                    @foreach($proxyFeatures as $proxy)
                    <div class="swiper-slide">
                        <div class="card pricing-card text-white">
                            <h5 class="fs-2 d-flex align-items-center gap-2">{{ $proxy->name }}
                                <div class="discount-badge">
                                    <span>- {{ $proxy->minVariation->discount_percentage }}%</span>
                                </div>
                            </h5>
                            <h3 class="pricing-price">
                                @if ($proxy->minVariation && $proxy->minVariation->has_promotion)
                                    {{ number_format($proxy->minVariation->price_promotion) }}đ
                                @else
                                    {{ number_format($proxy->minVariation->price) }}đ
                                @endif
                            </h3>
                            <p class="pricing-desc mb-4">
                                {{ $proxy->short_title_description }}
                            </p>
                            <a href="{{ route("proxy.detail", [ "slug" => $proxy->slug ]) }}" class="btn
                            btn-linear-primary btn-lg mb-4">@lang('Mua ngay')</a>
                            <ul class="list-unstyled">
{{--                                <li><i class="ti ti-check"></i> Tốc độ kết nối nhanh</li>--}}
{{--                                <li><i class="ti ti-check"></i> Hỗ trợ Http, Socks5...</li>--}}
{{--                                <li><i class="ti ti-check"></i> Windows, Mac, Linux, Android</li>--}}
{{--                                <li class="text-muted"><i class="ti ti-x"></i> Thời gian truy cập lâu hơn</li>--}}
{{--                                <li class="text-muted"><i class="ti ti-x"></i> Mạng luôn được kết nối</li>--}}
                                @foreach($setting_features as $feature)
                                    <li @if(!in_array($feature->setting_key, (array)$proxy->features))
                                            class="text-muted" @endif><i
                                            class="ti  @if(in_array($feature->setting_key, (array)
                                    $proxy->features))
                                    ti-check
                                     @else ti-x @endif"></i> {{$feature->plain_value }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
