@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@section('content')

    <div class="main-content">
        <section class="container px-md-5 px-3 pb-5">
            <div class="row g-4">
                <div class="col-md-3 col-12 d-md-block">
                    @include("public.account.left-sidebar")
                </div>
                <div class="col-md-9 col-12 d-md-block">
                    <div class="level-group">
                        <div class="leve-group-inner">
                            <div class="d-flex w-list-level justify-content-between align-items-end">
                                <div class="list-level d-flex">
                                    @foreach($listLevels as $level)
                                    <div class="item-level d-flex flex-column">
                                        <img src="{{ asset($level->feature_image) }}" alt="">
                                        <span>{{ $level->name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="icon-robot">
                                    <img src="{{ asset("public/assets/images/Group 97763.png") }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="show-my-level">
                        <p class="name">{{ $user->name }}</p>
                        <p class="level-name">Thành viên {{ $user->memberLevel->name ?? "Mới" }}</p>
                        <div class="d-flex justify-content-between">
                            <span class="d-none d-lg-block">Tổng giá trị đơn hàng</span>
                            <span>{{ number_format($total_order) }}đ</span>
                        </div>
                        <div class="d-flex justify-content-md-between align-items-md-center flex-md-row flex-column">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <span>{{ number_format($total_order) }}/{{ number_format($memberLevelNext->plain_value) }} đ</span>
                        </div>
                    </div>
                    
                    <div class="section-coupon">
                        <p class="fw-bold fs-3">Mã khuyến mãi dành riêng cho bạn</p>
                        <div class="row g-3">
                            @if($coupons && !$coupons->isEmpty())
                                @foreach($coupons as $coupon)
                                <div class="col-md-4">
                                    <div class="lv-bg">
                                        <div class="inner-group-coupon">
                                            <p>Tặng mã giảm giá @if($coupon->type == \App\Core\Enums\Voucher\VoucherType::Fixed)
                                                    {{ number_format($coupon->value) }}đ
                                                @else
                                                    {{ number_format($coupon->value) }}%
                                                @endif dành cho bạn</p>
                                            <div class="d-flex justify-content-between">
                                                <span class="coupon_code">
                                                    {{ $coupon->code }}
                                                </span>
                                                <div class="coupon_value">
                                                    Giảm
                                                    @if($coupon->type == \App\Core\Enums\Voucher\VoucherType::Fixed)
                                                    {{ number_format($coupon->value) }}đ
                                                    @else
                                                        {{ number_format($coupon->value) }}%
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                           @else
                                <p>Chưa có mã khuyến mãi nào áp dụng cho bạn</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection

@push('js')
    @include('public.scripts.swiper')
    <script src="{{ asset("public/assets/js/jquery.validate.min.js") }}"></script>
@endpush
