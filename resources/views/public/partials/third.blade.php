<section class="py-5 third-section" id="third-section">
    <div class="container">
        <h3 class="display-5 text-white fw-bold text-center mb-6">@lang('Danh sách các loại proxy Tốt nhất')</h3>
        <div class="row align-items-center row-second g-3 mb-4">
            <div class="col-sm-12 col-lg-4">
                <div class="input-icon">
                    <span class="input-icon-addon icon-search">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.8296 17.0208L13.1822 12.4477C14.3992 11.1254 15.1469 9.37677 15.1469 7.45252C15.1464 3.33621 11.7559 -0.000244141 7.57318 -0.000244141C3.39048 -0.000244141 0 3.33621 0 7.45252C0 11.5688 3.39048 14.9053 7.57318 14.9053C9.38039 14.9053 11.0379 14.2802 12.3399 13.241L17.0053 17.8322C17.2327 18.0561 17.6017 18.0561 17.829 17.8322C18.0569 17.6082 18.0569 17.2448 17.8296 17.0208ZM7.57318 13.7586C4.03416 13.7586 1.16524 10.9353 1.16524 7.45252C1.16524 3.96974 4.03416 1.14641 7.57318 1.14641C11.1122 1.14641 13.9811 3.96974 13.9811 7.45252C13.9811 10.9353 11.1122 13.7586 7.57318 13.7586Z"
                                fill="url(#paint0_linear_89_5938)" />
                            <defs>
                                <linearGradient id="paint0_linear_89_5938" x1="0" y1="8.99994" x2="18"
                                    y2="8.99994" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#BE7AD8" />
                                    <stop offset="1" stop-color="#752DF0" />
                                </linearGradient>
                            </defs>
                        </svg>

                    </span>
                    <input id="searchInput" type="text" value="" class="form-control input-search"
                        placeholder="{{ __('Nhập tên dịch vụ') }}">
                </div>
            </div>
            <div class="col-sm-12 col-lg-8 ps-4 proxy-type-wrapper ">
                <a id="prevProxyBtn">
                    <img src="{{ asset('public/assets/images/prev.svg') }}" alt="">
                </a>
                <div class="swiper proxyList">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="?" class="btn-linear-primary text-decoration-none">@lang('Tất cả')</a>
                        </div>
                        @foreach($types as $cate)
                        <div class="swiper-slide">
                            <div class="btn-proxy d-flex gap-2 align-items-center">
                                <img src="{{ asset($cate->feature_image) }}" alt="">
                                <a href="?type_id={{ $cate->id }}" class="text-white">{{ $cate->name }}</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <a id="nextProxyBtn">
                    <img src="{{ asset('public/assets/images/next.svg') }}" alt="">
                </a>

            </div>
        </div>
        <div class="proxy-table table-responsive">
            <table class="table table-vcenter card-table table-striped table-borderless">
                <thead>
                    <tr>
                        <th style="width: 50%">@lang('Tên dịch vụ')</th>
                        <th style="width: 10%">@lang('Số lượng')</th>
                        <th style="width: 10%">@lang('Hiện có')</th>
                        <th style="width: 10%">@lang('Giá')</th>
                        <th style="width: 20%"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($proxies as $proxy)
                    @php
                        $selectedVariationProxy = $proxy->proxyVariations[0] ?? false;
                    @endphp
                    <tr id="proxy_item_{{ $proxy->id }}">
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('proxy.detail', [ 'slug' => $proxy->slug ]) }}">
                                    <img src="{{ asset($proxy->feature_image) }}" class="proxy-logo"
                                         alt="Mobile Hop">
                                </a>
                               
                                <div>
                                    <p class="proxy-title"><a href="{{ route('proxy.detail', [ 'slug' => $proxy->slug ]) }}">{{ $proxy->name }}</a></p>
                                    <p class="proxy-subtitle">{{ $proxy->sub_title }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <select class="form-select variation-select" data-row-id="{{ $proxy->id }}">
                                    @foreach($proxy->proxyVariations as $k => $proxyVariation)
                                        @php
                                            $price = $proxyVariation->has_promotion ? $proxyVariation->price_promotion : $proxyVariation->price;
                                        @endphp
                                    <option @if($k == 0) selected @endif value="{{ $proxyVariation->id }}" data-price="{{ $price }}" data-status="{{ $proxyVariation->status }}" data-proxy-id="{{ $proxy->id }}">
                                        {{ $proxyVariation->variation->name ?? "" }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>

                                @if($selectedVariationProxy)
                                    @if($selectedVariationProxy->status == \App\Core\Enums\ProxyStatus::Available)
                                    <span class="proxy-status available">@lang('Có sẵn')</span>
                                    @else
                                    <span class="proxy-status out-of-stock">@lang('Hết')</span>
                                   @endif
                                @endif

                        </td>
                        <td class="actions-cell">
                            <div class="text-left">
                                <span class="variation-price" data-row-id="2">
                                    @if($selectedVariationProxy)
                                        @php
                                            $price = $selectedVariationProxy->has_promotion ? $selectedVariationProxy->price_promotion : $selectedVariationProxy->price;
                                        @endphp
                                        {{ number_format($price) }}đ
                                    @endif
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end align-items-center">
                                <button class="cart-btn me-2">
                                    <img src="{{ asset('public/assets/images/ic-cart.svg') }}" alt="">
                                </button>
                                <button class="buy-btn">@lang('Mua ngay')</button>
                            </div>
                        </td>
                        <input type="hidden" name="proxy_id" value="{{ $proxy->id }}">
                        <input type="hidden" name="proxy_variation_id" value="{{ $selectedVariationProxy->id ?? 0 }}">
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
