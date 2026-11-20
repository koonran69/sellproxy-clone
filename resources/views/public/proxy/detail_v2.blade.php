@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@section('content')

    {{--    @include('public.layouts.partials.header')--}}
    <div class="main-content">
        <div class="container">
            <div class="row test">
                <!-- Hình ảnh -->
                <div class="col-md-7 text-center">
                    <div class="feature_image_box">
                        <img src="{{ asset($proxy->feature_image) }}" class="img-fluid">
                    </div>
                    <div class="row mt-5 section-gallery-bottom flex-nowrap w-100 d-none d-md-flex">
                        <div class="col-md-3 text-center item-bottom p-0">
                            <div class="p-3 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="text-primary-700 m-auto iconify iconify--cbi" width="29" height="29" viewBox="0 0 24 24"><path fill="currentColor" d="M10.84.14h2l.36.06A27.3 27.3 0 0 1 21.8 2c.71.27 1.4.59 2.06.88c.32 8.56-3.12 16.09-11.87 21a23.66 23.66 0 0 1-9.1-8.79A22.86 22.86 0 0 1 .15 2.87A26.4 26.4 0 0 1 8.6.38c.75-.1 1.49-.16 2.24-.24m.7 12.59l-.26-.28c-.68-.79-1.35-1.59-2-2.38a1.93 1.93 0 0 0-2.81 0L11.58 16l7.16-9.4c0-.06 0-.09-.07-.1a.92.92 0 0 0-1.24.26c-1 1-1.93 2-2.89 2.93z" class="cls-1"></path></svg>
                                <h4>@lang('Hàng chính hãng')</h4>
                                <p>@lang('Cam kết hàng chính hãng bảo hành đến khi xài hết')</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center item-bottom p-0">
                            <div class="p-3  rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="text-primary-700 m-auto iconify iconify--material-symbols" width="29" height="29" viewBox="0 0 24 24"><path fill="currentColor" d="M10.45 15.5q.6.6 1.55.588t1.4-.688L19 7l-8.4 5.6q-.675.45-.712 1.375t.562 1.525M12 4q1.475 0 2.838.412T17.4 5.65l-1.9 1.2q-.825-.425-1.712-.637T12 6Q8.675 6 6.337 8.338T4 14q0 1.05.288 2.075T5.1 18h13.8q.575-.95.838-1.975T20 13.9q0-.9-.213-1.75t-.637-1.65l1.2-1.9q.75 1.175 1.188 2.5T22 13.85t-.325 2.725t-1.025 2.475q-.275.45-.75.7t-1 .25H5.1q-.525 0-1-.25t-.75-.7q-.65-1.125-1-2.387T2 14q0-2.075.788-3.887t2.15-3.175t3.187-2.15T12 4m.175 7.825"></path></svg>
                                <h4>@lang('Nhận proxy nhanh')</h4>
                                <p>@lang('Hiển thị CDkey trong lịch sử mua hàng và trên email')</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center item-bottom p-0">
                            <div class="p-3  rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="text-primary-700 m-auto iconify iconify--uil" width="29" height="29" viewBox="0 0 24 24"><path fill="currentColor" d="M19.9 12.66a1 1 0 0 1 0-1.32l1.28-1.44a1 1 0 0 0 .12-1.17l-2-3.46a1 1 0 0 0-1.07-.48l-1.88.38a1 1 0 0 1-1.15-.66l-.61-1.83a1 1 0 0 0-.95-.68h-4a1 1 0 0 0-1 .68l-.56 1.83a1 1 0 0 1-1.15.66L5 4.79a1 1 0 0 0-1 .48L2 8.73a1 1 0 0 0 .1 1.17l1.27 1.44a1 1 0 0 1 0 1.32L2.1 14.1a1 1 0 0 0-.1 1.17l2 3.46a1 1 0 0 0 1.07.48l1.88-.38a1 1 0 0 1 1.15.66l.61 1.83a1 1 0 0 0 1 .68h4a1 1 0 0 0 .95-.68l.61-1.83a1 1 0 0 1 1.15-.66l1.88.38a1 1 0 0 0 1.07-.48l2-3.46a1 1 0 0 0-.12-1.17ZM18.41 14l.8.9l-1.28 2.22l-1.18-.24a3 3 0 0 0-3.45 2L12.92 20h-2.56L10 18.86a3 3 0 0 0-3.45-2l-1.18.24l-1.3-2.21l.8-.9a3 3 0 0 0 0-4l-.8-.9l1.28-2.2l1.18.24a3 3 0 0 0 3.45-2L10.36 4h2.56l.38 1.14a3 3 0 0 0 3.45 2l1.18-.24l1.28 2.22l-.8.9a3 3 0 0 0 0 3.98m-6.77-6a4 4 0 1 0 4 4a4 4 0 0 0-4-4m0 6a2 2 0 1 1 2-2a2 2 0 0 1-2 2"></path></svg>
                                <h4>@lang('Hỗ trợ cài đặt')</h4>
                                <p>@lang('Hỗ trợ miễn phí qua Teamvier hoặc Anydesk')</p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center item-bottom p-0">
                            <div class="p-3  rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="text-primary-700 m-auto iconify iconify--mdi" width="29" height="29" viewBox="0 0 24 24"><path fill="currentColor" d="M12.3 8.93L9.88 6.5h5.62V10H17V5H9.88l2.42-2.43l-1.06-1.07L7 5.75L11.24 10zM12 14a3 3 0 1 0 3 3a3 3 0 0 0-3-3m-9-3v12h18V11m-2 8a2 2 0 0 0-2 2H7a2 2 0 0 0-2-2v-4a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2Z"></path></svg>
                                <h4>@lang('Đảm bảo hoàn tiền')</h4>
                                <p>@lang('Hoàn tiền 100% nếu CDkey không hoạt động')</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin sản phẩm -->
                <div class="col-md-5 product-detail ps-4 py-3">
                    <h2 class="text-primary product-title">{{ $proxy->name }}</h2>
                    <p class="rating">★★★★★</p>
                    <div id="wraper-price" class="product_price d-flex align-items-center gap-4">
                        <span class="main-price" id="price_promotion"></span>
                        <del class="text-muted discount" id="price_origin"></del>
                        <span id="percent">
{{--                            <span class="badge"></span>--}}
                        </span>
                        
                    </div>
                    <div class="d-flex mt-4">
                        <div class="d-flex align-items-center fw-bold text-secondary variation-name">@lang('Thời hạn')</div>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-variation active" id="duration"></button>
                        </div>
                    </div>
                    @php
                        $attribute = $proxy->proxyVariations[0]->variation->attribute;
                    @endphp
                    <div class="d-flex mt-4 variation-name-plan">
                        <div class="d-flex fw-bold text-secondary variation-name-plan__title variation-name">{{ $attribute->name }}</div>
                        <div class="d-flex flex-wrap gap-2 row-gap-4 py-2" id="group-plan">
                            @if($proxy->proxyVariations)
                                @foreach($proxy->proxyVariations as $k => $proxyVariation)
                                    @php
                                        $usd = $proxyVariation->has_promotion ? convert_vnd_to_usd($proxyVariation->price_promotion) : convert_vnd_to_usd($proxyVariation->price)
                                    @endphp
                                    <button class="btn btn-variation plan-btn {{ $k == 0 ? "active" : "" }}"
                                            data-price="{{ $proxyVariation->price }}"
                                            data-price-promotion="{{ $proxyVariation->price_promotion }}"
                                            data-has-promotion="{{ $proxyVariation->has_promotion }}"
                                            data-usd="{{ $usd }}"
                                            data-duration="{{ $proxyVariation->duration }}"
                                            data-proxy-variation-id="{{ $proxyVariation->id }}"
                                    >{{ $proxyVariation->variation->name }}</button>
                                @endforeach
                            @endif
                            <div class="w-100">
                                <button class="btn btn-variation plan-btn" data-type="contact">@lang('Lớn hơn vui lòng liên hệ để được giá tốt nhất')</button>
                            </div>
                            <form action="{{ route("cart.addToCart") }}" id="formAddToCart" method="POST">
                                @csrf
                                <input type="hidden" name="proxy_id" id="proxy_id" value="{{ $proxy->id }}">
                                <input type="hidden" name="proxy_variation_id" id="proxy_variation_id" value="0">
                                <input type="hidden" name="type" id="type" value="add_to_cart">
                            </form>
                        </div>
                    </div>

                    <!-- Nút mua hàng -->
                    <div class="mt-4">
                        <button id="buyNow" class="btn btn-buy-now me-4">@lang('Mua ngay')</button>
                        <a id="btnContact" href="https://t.me/nickchatdelamgi" target="_blank" class="btn btn-buy-now me-4" >@lang('Liên hệ')</a>
                        <button id="addToCart" class="btn btn-contact"><img src="{{ asset("public/assets/images/shopping-cart (2) 1.png") }}" alt=""> <span class="ms-2">@lang('Thêm vào giỏ hàng')</span></button>
                    </div>
                </div>
            </div>

            <!-- Thông tin chung -->
            <div class="row mt-5">
                {!! $proxy->short_desc !!}
            </div>

            <div class="row mt-5 mb-5 content-detail-proxy">
                {!! $proxy->desc !!}
            </div>
        </div>
    </div>

@endsection

@push('js')
    @include('public.scripts.swiper')
    <script src="{{ asset("public/assets/js/jquery.validate.min.js") }}"></script>
    <script>
        $('#formRegister').validate({
            ignore: ".ignore",
            rules: {
                email: "required",
                password: "required",
            },
            messages: {
                email: "Email là bắt buộc",
                password: "Mật khẩu là bắt buộc",
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        function showVariation() {
            var button = $("#group-plan .plan-btn.active");
            var type = button.data("type");
            if(type == "contact") {
                $("#wraper-price").addClass("d-none");
                $("#buyNow").hide();
                $("#btnContact").show();
                $("#addToCart").attr("disabled", true);
            } else {
                $("#wraper-price").removeClass("d-none");
                $("#btnContact").hide();
                $("#buyNow").show();
                $("#addToCart").attr("disabled", false);
                var price = button.data("price");
                var price_promotion = button.data("price-promotion");
                var has_promotion = button.data("has-promotion");
                var usd = button.data("usd");
                var duration = button.data("duration");
                var proxy_variation_id = button.data("proxy-variation-id");
                $("#proxy_variation_id").val(proxy_variation_id);
                if(has_promotion) {
                    $("#price_promotion").text(number_format(price_promotion));
                    $("#price_origin").text(number_format(price));
                    let phanTramGiam = ((price - price_promotion) / price) * 100;
                    phanTramGiam = (phanTramGiam % 1 === 0) ? phanTramGiam : phanTramGiam.toFixed(2);
                    $("#percent").html('<span class="badge">'+phanTramGiam+'%</span>');
                } else {
                    $("#price_promotion").text(number_format(price));
                }

                $("#duration").text(duration);

                $("#wraper-price").show();
            }
        }

        $(document).ready(function() {
            showVariation();
            $(".plan-btn").click(function() {
                $(".plan-btn").removeClass("active");

                $(this).addClass("active");

                showVariation();
            });

            $("#addToCart").on("click", function() {
                $("#formAddToCart").submit();
            });

            $("#buyNow").on("click", function() {
                $("#type").val('buyNow');
                $("#formAddToCart").submit();
            });

            $("#formAddToCart").submit(function(e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                var url = $(this).attr('action');
                $.ajax({
                    method: 'post',
                    url: url,
                    dataType: 'json',
                    data: data
                }).done(function(res) {
                    if(res.status) {
                        $("#cart_count_total").text(res.count);
                        if(res.type && res.type == 'buyNow') {
                            window.location.href = res.redirect_url;
                        } else {
                            msgSuccess(window.__trans("Thêm giỏ hàng thành công"));
                        }
                    }
                }).fail(function(res) {

                });
            });

        });
    </script>
@endpush
