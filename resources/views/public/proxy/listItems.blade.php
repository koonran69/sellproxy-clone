@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@push('css')
    <style>
        @media (max-width: 767.98px) {
            .category-arrow {
                transition: transform 0.3s ease;
            }

            [aria-expanded="true"] .category-arrow {
                transform: rotate(180deg);
            }

            .collapse {
                transition: all 0.3s ease;
            }
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')

    <div class="main-content">
        <section class="container px-md-5 px-3 pb-5">
            <div class="row g-4">
                <div class="col-md-2 col-12 d-md-block">
                    <div class="filter-category">
                        <!-- Always visible on desktop, clickable header on mobile -->
                        <div class="d-flex justify-content-between align-items-center flex-row">
                            <p data-bs-toggle="collapse" data-bs-target="#categoryCollapse" class="fs-10 fw-semibold mb-0">@lang('Chọn danh mục')</p>
                            <!-- Arrow only shows on mobile -->
                            <svg width="15" height="15" viewBox="0 0 24 24"
                                 class="category-arrow d-md-none cursor-pointer" data-bs-toggle="collapse"
                                 data-bs-target="#categoryCollapse" aria-expanded="false">
                                <path fill="currentColor" d="M7 10l5 5 5-5z"></path>
                            </svg>
                        </div>

                        <!-- Always visible on desktop, collapsible on mobile -->
                        <div class="d-md-block collapse" id="categoryCollapse">
                            <ul class="ms-2 list-unstyled mt-2">
                                <a href="{{ route('proxy.list') }}" class="gap-2 d-flex align-items-center text-dark">
                                    <li
                                        class="mt-1 d-flex gap-2 @if ($filter['cate_id'] == 'all') text-primary @else text-dark @endif align-items-center">
                                        <svg width="15" height="15" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                  d="M10 2v2.26l2 1.33V4h10v15h-5v2h7V2zM7.5 5L0 10v11h15V10zM14 6v.93L15.61 8H16V6zm4 0v2h2V6zM7.5 7.5L13 11v8h-3v-6H5v6H2v-8zM18 10v2h2v-2zm0 4v2h2v-2z">
                                            </path>
                                        </svg>
                                        <p class="cursor-pointer">Tất cả</p>
                                    </li>
                                </a>
                                @foreach ($categories as $cate)
                                    <li class="mt-1 d-flex gap-2 align-items-center">
                                        <a href="{{ route('proxy.list') }}?cate_id={{ $cate->id }}"
                                           class="gap-2 d-flex align-items-center @if ($filter['cate_id'] == $cate->id) text-primary @else text-dark @endif">
                                            <img width="15" height="15" src="{{ asset($cate->feature_image) }}"
                                                 alt="">
                                            <p class="cursor-pointer">{{ $cate->name }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
    
                    <div class="filter-category mt-5">
                        <!-- Always visible on desktop, clickable header on mobile -->
                        <div class="d-flex justify-content-between align-items-center flex-row">
                            <p data-bs-toggle="collapse" data-bs-target="#sortCollapse" class="fs-10 fw-semibold mb-0">@lang('Sắp xếp theo')</p>
                            <!-- Arrow only shows on mobile -->
                            <svg width="15" height="15" viewBox="0 0 24 24"
                                 class="category-arrow d-md-none cursor-pointer" data-bs-toggle="collapse"
                                 data-bs-target="#sortCollapse" aria-expanded="false">
                                <path fill="currentColor" d="M7 10l5 5 5-5z"></path>
                            </svg>
                        </div>
        
                        <!-- Always visible on desktop, collapsible on mobile -->
                        <div class="d-md-block collapse" id="sortCollapse">
{{--                            <div class="form-check">--}}
{{--                                <input {{ $sort == 'bestSeller' ? 'checked' : '' }} class="form-check-input" type="radio" name="sortOption" id="bestSeller" value="bestSeller">--}}
{{--                                <label class="form-check-label" for="bestSeller">--}}
{{--                                    Bán chạy nhất--}}
{{--                                </label>--}}
{{--                            </div>--}}
                            <div class="form-check">
                                <input {{ $sort == '09' ? 'checked' : '' }} class="form-check-input" type="radio" name="sortOption" id="sort09" value="09">
                                <label class="form-check-label" for="sort09">
                                    Tên từ (0 → 9)
                                </label>
                            </div>
                            <div class="form-check">
                                <input {{ $sort == 'az' ? 'checked' : '' }} class="form-check-input" type="radio" name="sortOption" id="sortAZ" value="az">
                                <label class="form-check-label" for="sortAZ">
                                    Tên từ (A → Z)
                                </label>
                            </div>
                            <div class="form-check">
                                <input {{ $sort == 'za' ? 'checked' : '' }} class="form-check-input" type="radio" name="sortOption" id="sortZA" value="za">
                                <label class="form-check-label" for="sortZA">
                                    Tên từ (Z → A)
                                </label>
                            </div>
                            <div class="form-check">
                                <input {{ $sort == 'latest' ? 'checked' : '' }} class="form-check-input" type="radio" name="sortOption" id="latest" value="latest">
                                <label class="form-check-label" for="latest">
                                    Mới cập nhật
                                </label>
                            </div>
                            <div class="form-check">
                                <input {{ $sort == 'priceLow' ? 'checked' : '' }} class="form-check-input" type="radio" name="sortOption" id="priceLow" value="priceLow">
                                <label class="form-check-label" for="priceLow">
                                    Giá thấp đến cao
                                </label>
                            </div>
                            <div class="form-check">
                                <input {{ $sort == 'priceHigh' ? 'checked' : '' }} class="form-check-input" type="radio" name="sortOption" id="priceHigh" value="priceHigh">
                                <label class="form-check-label" for="priceHigh">
                                    Giá cao đến thấp
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-12 d-md-block">
                    <h1 class="main-title">Danh sách sản phẩm</h1>
                    <div class="list-products row">

                        @if($proxies && !empty($proxies))

                            @foreach($proxies as $proxy)
                                @include("public.partials.product_item_loop", [ "proxy" => $proxy ])
                            @endforeach

                        @else

                        @endif


                    </div>
                </div>
            </div>
        </section>

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
        
        $("#sortCollapse input[type='radio']").on("change", function() {
            var value = $(this).val();
            const url = new URL(window.location.href);
            url.searchParams.set('sort', value);
            window.location.href = url.toString();
        });
    </script>
@endpush
