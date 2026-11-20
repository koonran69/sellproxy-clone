@extends('public.layouts.master')

@section('title')
    New Order
@endsection

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('public/assets/ion.rangeSlider/css/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/proxyline.css') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="main-content">
        <div class="container">
            <div class="page-header mb-3">
                <div class="page-block">
                    <div class="mb-2 ">
                        <h1 class="font-weight-normal mb-0">@lang('Tạo mới Proxy')</h1>
                    </div>
                </div>
            </div>
            
            <form id="frmCheckout" method="post" action="{{ route('proxyline.payProxyLine') }}" class="order-form">
                @csrf
                <select multiple name="ip_list" id="ip_list" style="display: none"></select>
                <div class="row" data-select2-id="10">
                    <div class="col-md-8 col-lg-9" data-select2-id="9">
                        <div class="card shadow-lg" data-select2-id="8">
                            <div class="card-body" data-select2-id="7">
                        
                                <div class="form-group mb-4">
                                    <h3>Loại</h3>
                            
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                
                                        <label class="btn btn-outline-primary active">
                                            <input data-name="Private" data-desc="This type of proxy opens all sites for you and guarantees that you are the only user of this IP address.&lt;br&gt;Maximum protection and stability." type="radio" name="ip_type" value="2" autocomplete="off" checked=""> Private
                                        </label>
                                
                                        <label class="btn btn-outline-primary">
                                            <input data-name="Shared" data-desc="This type of proxy opens all sites for you. EXCEPT: all banking sites QIWI, Webmoney, Sberbank and others, and closes access to the Steam site. These sites are open only on private proxies. SHARED PROXY REPLACEMENT NO WARRANTY." type="radio" name="ip_type" value="1" autocomplete="off"> Shared
                                        </label>
                            
                                    </div>
{{--                                    <div class="btn-group-description mt-2" data-name="ip_type">This type of proxy opens all sites for you and guarantees that you are the only user of this IP address</div>--}}
                                </div>
                        
                                <div class="form-group mb-4">
                                    <h3>IP version</h3>
                            
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                
                                        <label class="btn btn-outline-primary active" data-name="ip_version" data-value="1">
                                            <input data-name="IPv4" data-desc="" type="radio" name="ip_version" value="1" autocomplete="off" checked=""> IPv4
                                        </label>
                                
                                        <label class="btn btn-outline-primary" data-name="ip_version" data-value="2">
                                            <input data-name="IPv6" data-desc="Issuing a proxy in iPv4 format but at the output of iPv6 an address from / 32 subnets (each address will be different / 48 subnets)" type="radio" name="ip_version" value="2" autocomplete="off"> IPv6
                                        </label>
                            
                                    </div>
                                    <div class="btn-group-description mt-2" data-name="ip_version"></div>
                                </div>
                        
                                <div class="form-group mb-4">
                                    <h3>Quốc gia</h3>
                                    <input type="text" placeholder="Search" class="form-control order__country-search">
                                    <div class="row mt-2">
                                        @foreach($proxyCountries as $country)
                                        <div class="col-6 col-md-6 col-lg-4 pb-2 order__country" data-search="ru|russia|россия">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="id_country-{{ $country->code }}" name="country" value="{{ $country->id }}" class="custom-control-input" data-name="{{ $country->name }}" data-flag="{{ asset($country->feature_image) }}" checked="">
                                                <label class="custom-control-label" for="id_country-{{ $country->code }}"><img src="{{ asset($country->feature_image) }}"> <span class="pl-1">{{ $country->name }}</span></label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                        
                                <div class="form-group mb-4">
                                    <h3>
                                        Số lượng
                                        <button type="button" class="btn btn-sm btn-success js-select-ip-button" data-bs-toggle="modal" data-bs-target="#select-ip-modal">Chọn IP thủ công</button>
                                        <small class="js-iplist-selected" style="display: none;">Đã chọn: <span class="js-iplist-selected-count">0</span> <span class="clear-ip-list text-danger">Xóa</span></small>
                                    </h3>
                                    <div class="f-13 mt-2 mb-2">Bạn có thể đặt nhiều đơn hàng khác nhau. Đây là giới hạn cho một đơn hàng.</div>
    
                                    <input type="text" name="quantity" id="quantity-range"
                                           value="1"
                                           data-min="1"
                                           data-max="2000"
                                           data-grid="true">
                            
                            
                                    <div class="row mt-2">
                                        <div class="col-sm-3">
                                            <input style="max-width: 80px" type="number" min="1" class="form-control form-control-sm js-custom-quantity">
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="mt-1 quantity-options text-end">
                                                <div class="badge badge-primary">10</div>
                                                <div class="badge badge-primary">50</div>
                                                <div class="badge badge-primary">100</div>
                                                <div class="badge badge-primary">250</div>
                                                <div class="badge badge-primary">500</div>
                                                <div class="badge badge-primary">1000</div>
                                                <div class="badge badge-primary">2000</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                        
                                <div class="form-group mb-4">
                                    <h3 class="mb-2">Số ngày</h3>
    
                                    <input type="text" name="period" id="period-range"
                                           value="0"
                                           data-values="5,10,20,30,60,90,120,150,180,210,240,270,300,330,360"
                                           data-grid="true">
                                </div>
                        
                                <a style="border-bottom: 2px dashed #0B69FF" class="f-16" data-bs-toggle="collapse" href="#advanced" aria-expanded="true">Lựa chọn nâng cao</a>
                        
                                <div class="collapse" id="advanced" style="">
                                    <div class="mt-4" data-select2-id="22">
                                        <h3>Thêm tags</h3>
                                        <div class="form-group">
                                            <select name="tags" id="" class="w-100" multiple>
                                            </select>
                                        </div>
                                        
                                        <span class="help-block f-12">Tối đa: 5</span>
                                    </div>
                            
{{--                                    <div class="mt-4" data-select2-id="6">--}}
{{--                                        <h3>Add access IPs to new proxies</h3>--}}
{{--                                        <div class="form-group">--}}
{{--                                            <select name="add_access_ip" id="" class="select2-bs5 d-block w-100">--}}
{{--                                                <option value="">Chọn</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <span class="help-block f-12">Maximum access IPs: 3</span>--}}
{{--                                    </div>--}}
{{--                            --}}
{{--                                    <div class="mt-4">--}}
{{--                                        <h3>Exclude subnets</h3>--}}
{{--                                --}}
{{--                                        <div data-subnets=""></div>--}}
{{--                                --}}
{{--                                        <div class="input-group mt-3" style="max-width: 350px">--}}
{{--                                            <input type="text" class="form-control" placeholder="Subnet to exclude" data-subnet-input="">--}}
{{--                                            <div class="input-group-append">--}}
{{--                                                <button type="button" class="btn btn-primary" data-subnet-add="">Add</button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                --}}
{{--                                        <span class="help-block f-12">Subnets to be excluded from the order. In the format «11.22.33.» or «11.22.33.*». No more than 5 subnets.</span>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div id="order-form-side-sticky-wrapper" class="sticky-wrapper" style="height: 400.175px;"><div class="card shadow-lg" id="order-form-side" style="">
                                <div class="card-body pl-0 pr-0">
                                    <div class="f-17 f-w-300 order__info">
                                        <div class="text-overflow">Loại: <span class="text-dark js-order-type">Private</span></div>
                                        <div class="">IP version: <span class="text-dark js-order-ipv">IPv4</span></div>
                                        <div class="text-overflow order__info__country">
                                            Quốc gia:
                                            <span class="js-order-country-img"><img src="https://static.proxyline.net/media/CACHE/images/flags/ru/16202e2bc1fc5dfa7f5a01caf77f4145.png"></span>
                                            <span class="text-dark js-order-country">Russia</span>
                                        </div>
                                
                                        <div>Proxies: <span class="text-dark js-order-quantity">1</span> pcs <small class="js-order-ip-selected" style="display: none;">(Chọn thủ công)</small></div>
                                        <div>Số ngày: <span class="text-dark js-order-period">30</span> ngày</div>
                                    </div>
                            
                                    <hr>
                                    <div class="text-center" data-order-amount="" style="">
                                        <div class="f-20 f-w-400 mt-3 mb-0 text-dark total-amount">
                                            Tổng tiền: <span class="js-order-amount">0</span> đ
                                        </div>
                                        <div class="f-16 f-w-300 text-dark one-amount">
                                            Giá một proxy:
                                            <span><span class="js-order-one-price">0</span> đ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center p-3">
{{--                                    <div class="input-group input-group-sm mb-3 js-coupon">--}}
{{--                                        <input type="text" name="coupon" class="form-control" placeholder="Coupon" autocomplete="off">--}}
{{--                                        <div class="input-group-append">--}}
{{--                                            <button class="btn btn-secondary js-apply-coupon btn-sm" type="button" data-remove-text="Remove" data-apply-text="Apply">Apply</button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <button id="btnCheckout" type="button" class="btn btn-outline-primary active" data-order-submit="">
                                        <span class="spinner-border spinner-border-sm" style="display: none"></span>
                                        Thanh toán ngay
                                    </button>
{{--                                    <div class="mt-2 f-12 js-balance-quick-pay" style="display: none">--}}
{{--                                --}}
{{--                                        Need <span></span>$ more on your balance to pay. <a target="_blank" href="#" data-url="/balance/?amount=">Top up balance</a>--}}
{{--                                    </div>--}}
                                </div>
                            </div></div>
                    </div>
                </div>
                <input type="hidden" id="is_login" value="{{ Auth::check() }}">
                <input type="hidden" id="payment_method">
            </form>
        </div>
    </div>
    @if(!Auth::check())
        @include("public.partials.modal_not_login")
    @else
        @include("public.partials.modal_payment_wallet")
    @endif

    <div class="modal fade" id="select-ip-modal" tabindex="-1">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chọn IP thủ công</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                
                    <input autocomplete="off" placeholder="Search by IP/subnet" type="text" class="form-control mb-1 js-ip-search">
{{--                    <input autocomplete="off" placeholder='Search by location' type="text" class="form-control js-ip-search-location">--}}
{{--                --}}
                    <h5 class="mt-3">
                        Đã chọn: <span class="js-iplist-selected-count">0</span>
                        <span style="display: none;" class="modal-iplist-clear-selected cursor-pointer text-danger" data-iplist-clear-selected>clear</span>
                    </h5>
                
                    <div class="modal-iplist-buttons cursor-pointer">
                        <span class="badge badge-success badge-primary" data-value="10">+10</span>
                        <span class="badge badge-success badge-primary" data-value="50">+50</span>
                        <span class="badge badge-success badge-primary" data-value="100">+100</span>
                        <span class="badge badge-success badge-primary" data-value="200">+200</span>
                    </div>
                
                    <hr>
                
                    <div class="modal-iplist-selected mb-4">
                
                    </div>
                    <div class="modal-iplist-items"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('public/assets/ion.rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
    @include('public.scripts.swiper')
    <script>
        window.ORDER_LIMITS = JSON.parse('[{"country_id": "kg", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "kg", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "kg", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "kg", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "hr", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "hr", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "hr", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "hr", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "nz", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "nz", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "nz", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "nz", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "sa", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "sa", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "sa", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "sa", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ba", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ba", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ba", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ba", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "lu", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "lu", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "lu", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "lu", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ma", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ma", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ma", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ma", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "tn", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "tn", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "tn", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "tn", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "tz", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "tz", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "tz", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "tz", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "sk", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "sk", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "sk", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "sk", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ly", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ly", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ly", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ly", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cy", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "cy", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "mt", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "mt", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ca", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "mt", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "bs", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "bs", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "bs", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "bs", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "mt", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "me", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "me", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "me", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "me", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "kr", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "kr", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "kr", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "kr", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "iq", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "iq", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "iq", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "mk", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "mk", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "mk", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "mk", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "iq", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ab", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ab", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ab", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ab", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cz", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cy", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "cy", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "sd", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "sd", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "sd", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "sd", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "dk", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "dk", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "dk", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "dk", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "hk", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "hk", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "hk", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "hk", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "tw", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "tw", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "tw", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "tw", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "kz", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "fr", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "cm", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "kh", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "et", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ci", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "cm", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "kh", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ie", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "au", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "fi", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ng", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "jo", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ng", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "et", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ci", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "cm", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ng", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "jo", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "kh", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "et", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ci", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ng", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cm", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "et", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "kh", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "jo", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ci", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "jo", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "id", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "id", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ad", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ad", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ad", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ad", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "bh", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "bh", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "bh", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "bh", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "gt", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "gt", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "gt", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "gt", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ir", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ir", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ir", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ir", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ae", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "de", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ua", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "id", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "id", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "pk", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ch", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "fr", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "pl", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "jp", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "de", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "kz", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "mn", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ch", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "pl", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ua", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "pl", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "in", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "by", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "az", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ee", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "vn", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "no", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ge", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "am", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "md", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "be", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "gr", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "se", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "sg", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "qa", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "us", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "us", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "gb", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "br", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "tr", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "es", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "it", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "bd", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ru", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "lt", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "lv", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ru", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ru", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "mv", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ru", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "bo", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ro", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "bo", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "cl", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "bo", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "pe", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "sc", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ke", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ke", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ke", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "lb", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "lb", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ph", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "lb", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "rs", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "co", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "rs", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "th", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "zm", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "zm", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "dz", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "al", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "al", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "eg", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "is", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "mc", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ve", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "hu", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "at", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "tm", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "uz", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "au", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "fi", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "gb", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "az", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "es", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "it", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "si", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "si", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "no", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "gr", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "qa", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "by", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ar", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ee", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "vn", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ge", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "am", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "md", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "be", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "se", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "sg", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ar", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "br", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ro", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "pe", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "tr", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "bd", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "lt", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "lv", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "sc", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "mv", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "us", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "gb", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cl", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "es", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "it", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "py", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "py", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ie", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ph", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "py", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "rs", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "si", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "cn", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "mn", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "mn", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "my", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "my", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "my", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ua", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "cn", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "pt", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "pt", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "jp", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "in", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "pk", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "pk", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "pk", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cz", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "cz", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ae", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ae", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "nl", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "nl", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "de", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ca", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ca", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "nl", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "zm", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "al", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "si", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "zm", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "al", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "co", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "th", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "dz", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "eg", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "is", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "mc", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "ve", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "hu", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "at", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "tm", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "uz", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "au", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "fi", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "az", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "no", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "gr", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "qa", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "by", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ee", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "vn", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ge", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "am", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "md", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "be", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "se", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "sg", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ar", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "lr", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "br", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "tj", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "ro", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "pe", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "tr", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "bd", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "lt", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "lv", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "sc", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "mv", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cl", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ie", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "us", "ip_type": 2, "ip_version": 4, "limit": 50}, {"country_id": "ph", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "gb", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "co", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "es", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "th", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "it", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "dz", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "eg", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "is", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "mc", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ve", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "hu", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "at", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "tm", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "uz", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "au", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "fi", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "az", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "no", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "gr", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "qa", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "by", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ee", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "vn", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ge", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "am", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "md", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "be", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "se", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "sg", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ar", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "lr", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "br", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ro", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "pe", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "tr", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "bd", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "lt", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "lv", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "sc", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "mv", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "cl", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ie", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ph", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "co", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "th", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "dz", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "eg", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "is", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "mc", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ve", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "hu", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "at", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "tm", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "uz", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "bo", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ke", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "lb", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "py", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "rs", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "jm", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "jm", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "jm", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "jm", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "il", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "il", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "il", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "il", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "mx", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "mx", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "mx", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "mx", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "uy", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "uy", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "uy", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "uy", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "lk", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "lk", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "lk", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "lk", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ch", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "lr", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "in", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "fr", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "pl", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "pt", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "de", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "mg", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "kz", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "fr", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ch", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cn", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "mg", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "mn", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "lr", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "my", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "ua", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "kz", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "cn", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "pt", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "jp", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "jp", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "in", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cz", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ae", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "nl", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "ca", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "np", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "np", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "np", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "np", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cu", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "cu", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "cu", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "cu", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "bg", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "bg", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "bg", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "bg", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "za", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "za", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "za", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "za", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "cr", "ip_type": 1, "ip_version": 4, "limit": 2000}, {"country_id": "cr", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "cr", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "cr", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "mg", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "mg", "ip_type": 2, "ip_version": 6, "limit": 2000}, {"country_id": "tj", "ip_type": 2, "ip_version": 4, "limit": 2000}, {"country_id": "tj", "ip_type": 1, "ip_version": 6, "limit": 2000}, {"country_id": "tj", "ip_type": 2, "ip_version": 6, "limit": 2000}]');
        //window.COUNTRY_AVAILABILITY = JSON.parse('{"ae": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "al": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "am": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ar": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "at": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "au": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "az": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ba": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "bd": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "be": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "bg": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "bo": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "br": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "by": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ca": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ch": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "cl": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "cm": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "cn": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "co": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "cr": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "cy": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "cz": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "de": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "dk": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "dz": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ee": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "eg": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "es": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "fi": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "fr": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "gb": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ge": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "gr": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "hk": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "hr": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "hu": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "id": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ie": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "il": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "in": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "iq": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ir": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "is": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "it": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "jm": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "jo": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "jp": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "ke": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "kg": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "kh": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "kr": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "kz": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "lk": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "lt": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "lu": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "lv": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ma": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "mc": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "md": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "me": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "mn": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "mt": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "mv": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "mx": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "my": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "ng": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "nl": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "no": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "np": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "nz": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "pe": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ph": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "pk": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "pl": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "pt": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "qa": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ro": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "rs": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ru": {"dedicated:4": true, "dedicated:6": true, "shared:4": true, "shared:6": false}, "sa": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "sc": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "se": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "sg": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "si": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "sk": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "th": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "tj": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "tm": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "tn": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "tr": {"dedicated:4": true, "shared:4": true, "dedicated:6": false, "shared:6": false}, "tw": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "tz": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ua": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "us": {"dedicated:4": true, "dedicated:6": true, "shared:4": true, "shared:6": false}, "uy": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "uz": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ve": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "vn": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "za": {"dedicated:4": true, "dedicated:6": false, "shared:4": false, "shared:6": false}, "lb": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "py": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "zm": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "lr": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "mg": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "cu": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "bs": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "mk": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ad": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "gt": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "et": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ci": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "bh": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ly": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "sd": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}, "ab": {"dedicated:4": false, "dedicated:6": false, "shared:4": false, "shared:6": false}}');
        window.COUNTRY_AVAILABILITY = @json($countryAvailability);
        $.getDataKey = function(data) {
            return [data.country, data.ip_type, data.ip_version].join(':');
        }
        $.getOrderAmount = function(data) {
            data = data || getOrderData();
            return $.ajax({
                url: '{{ route("proxyline.orderAmount") }}',
                method: 'get',
                data: data
            })
        }
        function getIPList(data) {
            data = data || getOrderData();
            data.ip_type = data.ip_type === "1" ? "shared" : "dedicated";
            return $.ajax({
                url: "/ip-list/",
                data: data,
            });
        }
        
        var customQttyField = $(".js-custom-quantity");
        
        $("#quantity-range").ionRangeSlider({
            skin: "round",
            onStart: function (data) {
                customQttyField.val(data.from);
            },
            onChange: function (data) {
                customQttyField.val(data.from);
            },
        });

        $(".order-form").on(
            "click",
            ".quantity-options:not(.disabled) .badge",
            function () {
                qttyRange.update({ from: $(this).text() });
                customQttyField.val($(this).text());
            }
        );
        
        var qttyRange = $("#quantity-range").data("ionRangeSlider");

        customQttyField.on("keyup change", function () {
            qttyRange.update({
                from: $(this).val(),
            });
        });
        
        $("#period-range").ionRangeSlider({
            skin: "round",
            postfix: ` days`,
        });

        function setCountryAvailability() {
            var proxyTypeId = $('input[name="ip_type"]:checked').val();
            var ipVersionId = $('input[name="ip_version"]:checked').val();

            var key = proxyTypeId + "_" + ipVersionId;
            if (!window.COUNTRY_AVAILABILITY || !window.COUNTRY_AVAILABILITY[key]) {
                console.warn("No COUNTRY_AVAILABILITY for key:", key);
                $('input[name="country"]').prop("disabled", true).prop("checked", false);
                return;
            }

            var allowedCountries = window.COUNTRY_AVAILABILITY[key];
            $('input[name="country"]').each(function () {
                var countryId = parseInt($(this).val());
                if (allowedCountries.includes(countryId)) {
                    $(this).prop("disabled", false).parent().removeAttr("title");
                } else {
                    $(this).prop("disabled", true).prop("checked", false).parent().attr("title", 'Not available');
                }
            });

            // Nếu không còn quốc gia nào được chọn thì tự chọn quốc gia đầu tiên
            if ($('input[name="country"]:enabled:checked').length === 0) {
                $('input[name="country"]:enabled').first().prop("checked", true);
            }
        }

        setCountryAvailability();

        function getOrderData() {
            var quantity = $('select[name="ip_list"]').val().length,
                ip_list_count = quantity;
            if (quantity === 0) {
                quantity = parseInt($('input[name="quantity"]').val());
            }

            return {
                quantity: quantity,
                ip_list_count: ip_list_count,
                ip_version: $('input[name="ip_version"]:checked').val(),
                ip_type: $('input[name="ip_type"]:checked').val(),
                country: $('input[name="country"]:checked').val(),
                period: parseInt($('input[name="period"]').val()),
            };
        }
        
        function getQuantityLimit(data) {
            data = data || getOrderData();
            return (
                window.ORDER_LIMITS[$.getDataKey(data)] || 2000
            );
        }
        
        function setQuantityLimit(data) {
            var limit = getQuantityLimit(data);
            qttyRange.update({ max: limit });
            customQttyField.prop("max", limit);
        }

        setQuantityLimit();

        $(".order__country-search").on("keyup change", function () {
            var val = $(this).val().trim().toLowerCase(),
                block = $(this).parents(".form-group");
            
            if (val) {
                block.find(".order__country").each(function () {
                    var country = $(this);
                    country.toggle(country.data("search").indexOf(val) != -1);
                });
            } else {
                block.find(".order__country").show();
            }
        });
        
        $("body").on(
            "change",
            'input[name="ip_version"],input[name="ip_type"]',
            function () {
                setCountryAvailability();
            }
        );

        $("body").on(
            "change",
            'input[name="ip_version"],input[name="ip_type"],input[name="country"]',
            function () {
                setQuantityLimit();
            }
        );

        $("body").on(
            "change",
            'input[name="ip_version"],input[name="ip_type"],input[name="country"],input[name="period"],input[name="quantity"]',
            function () {
                $(document).trigger("order:changed");
            }
        );
        
        $(document).on("order:changed coupon:changed", function () {
            updateOrderSummary();
        });

        function updateOrderAmount(data) {
            $("[data-order-amount]").css("opacity", 0.5);
            $("[data-order-submit]").prop("disabled", true);

            var updated = Date.now();

            $.getOrderAmount(data).done(function (amountData) {
                if (($("[data-order-submit]").data("updated") || 0) > updated) {
                    console.log("already updated");
                    return;
                }
                $("[data-order-submit]").data("updated", updated);

                var amount = amountData.amount;
                var price_per_ip = amountData.price_per_ip;
                
                $(".js-order-amount").text(amount);
                $(".js-order-one-price").text(price_per_ip);
                
                if(amountData.success) {
                    $("[data-order-amount]").css("opacity", "");
                    $("[data-order-submit]").prop("disabled", false);
                }
            });
        }
        
        var updateCounter = 0;
        function updateOrderSummary(data) {
            data = data || getOrderData();

            $(".js-order-ip-selected").toggle(data.ip_list_count > 0);

            $(".js-order-quantity").text(data.quantity);
            $(".js-order-period").text(data.period);

            var checkedCountry = $(".order__country input:checked");

            if ($(".js-order-country").data("code") != checkedCountry.val()) {
                var countryImg = $("<img>", { src: checkedCountry.data("flag") });
                $(".js-order-country").text(checkedCountry.data("name"));
                $(".js-order-country-img").html(countryImg);
                $(".js-order-country").data("code", checkedCountry.val());
            }

            $(".js-order-type").text($('input[name="ip_type"]:checked').data("name"));
            $(".js-order-ipv").text($('input[name="ip_version"]:checked').data("name"));

            updateCounter++;
            var localCounter = updateCounter;

            setTimeout(function () {
                if (localCounter != updateCounter) {
                    return;
                }
                updateOrderAmount(data);
            }, 300);
        }

        updateOrderSummary();
        
        $("#btnCheckout").on("click", function(){
            var is_login = $("#is_login").val();
            if(is_login) {
                checkoutLogin();
            } else {
                checkoutNotLogin();
            }
        });

        function checkoutNotLogin() {
            var successModal = new bootstrap.Modal(document.getElementById('notLoginModal'));
            successModal.show();
        }

        function checkoutLogin() {
            $('#paymentModal').modal('show');
        }
        
        initActionPaymentMethod();
        
        function initActionPaymentMethod() {
            // $("#group-payment-method button").on("click", function() {
            //     $("#group-payment-method button").removeClass("active");
            //     $(this).addClass("active");
            //     $("#payment_method").val($(this).val());
            // });
            var v = $(".btn-payment-method.active").val();
            $("#payment_method").val(v);
        }

        $(".btn-next-payment").on("click", function() {
            new bootstrap.Modal(document.getElementById("modalAjaxConfirm")).show();
        });

        $("#btn-confirm-payment-wallet").on("click", function() {
            $(this).attr("disabled", true);
            $("#modalAjaxConfirm").modal('hide');
            requestAjaxSendCheckout($("#frmCheckout"));
        });

        function requestAjaxSendCheckout(form) {
            var rawData = form.serializeArray();
            var data = {};
            
            const arrayFields = ['ip_list'];

            rawData.forEach(function(item) {
                if (arrayFields.includes(item.name)) {
                    if (!data[item.name]) {
                        data[item.name] = [];
                    }
                    data[item.name].push(item.value);
                } else {
                    if (item.name in data) {
                        if (!Array.isArray(data[item.name])) {
                            data[item.name] = [data[item.name]];
                        }
                        data[item.name].push(item.value);
                    } else {
                        data[item.name] = item.value;
                    }
                }
            });
            
            var url = form.attr('action');
            $.ajax({
                method: 'post',
                url: url,
                dataType: 'json',
                data: data
            }).done(function(res) {
                if(res.success) {
                    msgSuccess(window.__trans("Đặt hàng thành công"));
                    window.location = "{{ route('account.proxyLineOrder') }}";
                } else {
                    msgError(window.__trans(res.message));
                }
            }).fail(function(res) {
                //msgError(window.__trans('Có lỗi xảy ra, vui lòng thử lại'));
            });
        }

        function modalIPListUpdateCount() {
            var count = $(".modal-iplist-selected .badge").length;
            $(".js-iplist-selected-count").text(count);
            if (count > 0) {
                $(".js-iplist-selected").show();
                $("[data-iplist-clear-selected]").show();
                qttyRange.update({ disable: true });
                customQttyField.prop("disabled", true);

                $(".quantity-options").addClass("disabled");
            } else {
                $(".js-iplist-selected").hide();
                $("[data-iplist-clear-selected]").hide();
                qttyRange.update({ disable: false });
                customQttyField.prop("disabled", false);
                $(".quantity-options").removeClass("disabled");
            }

            $(document).trigger("order:changed");
        }

        $("#select-ip-modal").on("show.bs.modal", function (e) {
            var modal = $(this);

            // if (modal.data("loaded")) {
            //     return;
            // }
            $(".modal-iplist-items").html("");
            getIPList().done(function (list) {
                //modal.data("loaded", true);

                var items = [],
                    item;
                $.each(list, function (i, ip) {
                    item =
                        '<div class="modal-iplist-item" data-ip="' +
                        ip.ip +
                        '" data-location="' +
                        (ip.location || "").toLowerCase() +
                        '" data-id="' +
                        ip.id +
                        '">' +
                        "<p>" +
                        ip.ip +
                        "</p>" +
                        (ip.location ? "<small>" + ip.location + "</small>" : "") +
                        "</div>";

                    items.push(item);
                });

                $(".modal-iplist-items").html(items.join(""));
            });
        });
        
        function modalIPListItemsToggle(items) {
            $.each(items, function (i, item) {
                if (item.hasClass("bg-primary")) {
                    item.removeClass("bg-primary text-white");
                    $(
                        '.modal-iplist-selected [data-id="' + item.data("id") + '"]'
                    ).remove();
                    $('#ip_list option[value="' + item.data("id") + '"]').remove();
                } else {
                    item.addClass("bg-primary text-white");
                    $(".modal-iplist-selected").append(
                        '<div class="badge badge-secondary" data-id="' +
                        item.data("id") +
                        '">' +
                        item.data("ip") +
                        "</div> "
                    );
                    $("#ip_list").append(
                        '<option value="' + item.data("id") + '">1</option>'
                    );
                    $('#ip_list option[value="' + item.data("id") + '"]').prop(
                        "selected",
                        true
                    );
                }
            });

            modalIPListUpdateCount();
        }
        
        $("#select-ip-modal").on("click", ".modal-iplist-item", function () {
            modalIPListItemsToggle([$(this)]);
        });

        $("#select-ip-modal").on("click", ".modal-iplist-buttons span", function () {
            var count = $(this).data("value"),
                selected = 0,
                items = [];

            $(".modal-iplist-item:not(.bg-primary, .modal-iplist-item--hidden)").each(
                function () {
                    if (count === selected) return;
                    selected++;
                    items.push($(this));
                }
            );

            modalIPListItemsToggle(items);
        });

        $("#select-ip-modal").on(
            "click",
            "[data-iplist-clear-selected]",
            function () {
                $("#select-ip-modal .modal-iplist-item.bg-primary").each(function () {
                    var item = $(this);
                    item.removeClass("bg-primary text-white");
                    $(
                        '.modal-iplist-selected [data-id="' + item.data("id") + '"]'
                    ).remove();
                    $('#ip_list option[value="' + item.data("id") + '"]').remove();
                });

                modalIPListUpdateCount();
            }
        );
        let cachedTags = null;
        $('select[name="tags"]').select2({
            width: '100%',
            placeholder: 'Chọn',
            allowClear: true,
            ajax: {
                transport: function (params, success, failure) {
                    if (cachedTags) {
                        success(cachedTags);
                        return;
                    }

                    $.ajax({
                        url: '/json/tags/',
                        dataType: 'json',
                        success: function (data) {
                            cachedTags = data.map(item => ({
                                id: item.id,
                                text: item.name
                            }));
                            cachedTags.unshift({id: '', text: 'Chọn'});
                            success(cachedTags);
                        },
                        error: failure
                    });
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });

        $(".js-ip-search,.js-ip-search-location").on("keyup change", function () {
            var ip = $(".js-ip-search").val().trim(),
                item;

            $(".modal-iplist-item").each(function () {
                item = $(this);
                item.toggleClass(
                    "modal-iplist-item--hidden",
                    !(
                        item.data("ip").indexOf(ip) !== -1
                    )
                );
            });
        });
    </script>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        document.getElementById('google-login').addEventListener('click', function() {
            google.accounts.oauth2.initTokenClient({
                client_id: "{{ config("services.google.client_id") }}",
                scope: "email profile",
                callback: (response) => {
                    if (response.access_token) {
                        fetch("{{ route('auth.google') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ token: response.access_token })
                        }).then(res => res.json()).then(data => {
                            console.log("Login success:", data);
                            window.location = data.redirect_url;
                        }).catch(err => console.error("Error:", err));
                    }
                }
            }).requestAccessToken();
        });
    </script>
@endpush
