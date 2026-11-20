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
                        <h1 class="font-weight-normal mb-0">@lang('Gia hạn')</h1>
                    </div>
                </div>
            </div>
            
            <form id="frmCheckout" method="post" action="{{ route('proxyline.payReNewProxyLine') }}" class="order-form">
                @csrf
                <div class="row" data-select2-id="10">
                    <div class="col-md-8 col-lg-9" data-select2-id="9">
                        <div class="card shadow-lg" data-select2-id="8">
                            <div class="card-body" data-select2-id="7">
                                <div class="form-group mb-4">
                                    <h3 class="mb-2">Số ngày</h3>
    
                                    <input type="text" name="period" id="period-range"
                                           value="0"
                                           data-values="5,10,20,30,60,90,120,150,180,210,240,270,300,330,360"
                                           data-grid="true">
                                </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div id="order-form-side-sticky-wrapper" class="sticky-wrapper" style="height: 400.175px;"><div class="card shadow-lg" id="order-form-side" style="">
                                <div class="card-body pl-0 pr-0">
                                    <div class="f-17 f-w-300 order__info">
                                        <div>Proxies: <span class="text-dark">{{ count($proxies) }}</span> pcs</div>
                                        <div>Period: <span class="text-dark js-renew-period">0</span> ngày</div>
                                    </div>
                            
                                    <hr>
                                    <div class="text-center" data-order-amount="" style="">
                                        <div class="f-20 f-w-400 mt-3 mb-0 text-dark total-amount">
                                            Tổng tiền: <span class="js-order-amount">0</span> đ
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center p-3">
                                    <button id="btnCheckout" type="button" class="btn btn-outline-primary active" data-order-submit="">
                                        <span class="spinner-border spinner-border-sm" style="display: none"></span>
                                        Pay with balance
                                    </button>
                                </div>
                            </div></div>
                    </div>
                </div>
                <input type="hidden" id="is_login" value="{{ Auth::check() }}">
                <input type="hidden" id="payment_method">
                <input type="hidden" id="proxy_ids" value="{{ $proxy_ids }}" name="proxy_ids">
            </form>
            <div class="selected_proxy card shadow-lg">
                <div class="card-body">
                    <h3 class="title_selected_proxy">Danh sách proxy đã chọn: {{ count($proxies) }}</h3>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                            <tr>
                                <th>@lang('Proxy Id')</th>
                                <th>@lang('Proxy')</th>
                                <th>@lang('Loại')</th>
                                <th class="text-center">@lang('Quốc gia')</th>
                                <th class="text-center">@lang('Ngày hết hạn')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($proxies as $proxy)
                                <td>
                                    <span>{{ $proxy->proxyline_id }}</span>
                                    <br>
                                    <span>({{ $proxy->order_id }})</span>
                                </td>
                                <td class="proxy-table-proxy">
                                    <span>{{ $proxy->ip }}</span>
                                    <br>
                                    <small>Username: <b>{{ $proxy->username }}</b> Password: <b>{{ $proxy->password }}</b></small>
                                    <br>
                                    <small>HTTP/SOCKS Port: <span>{{ $proxy->port_http }}</span>/<span>{{ $proxy->port_socks5 }}</span></small>
                                </td>
                                <td>{{ $order->proxyType->name  }}</td>
                                <td class="text-center"><img src="{{ asset($order->country->feature_image) }}" alt=""> <br>{{ $order->country->name }}</td>
                                <td class="text-center">
                                    <span>{{ $proxy->date_end }}</span>
                                    <br>
                                    <span>({{ $proxy->remaining_days }} ngày)</span>
                                </td>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(!Auth::check())
        @include("public.partials.modal_not_login")
    @else
        @include("public.partials.modal_payment_wallet")
    @endif
@endsection

@push('js')
    <script src="{{ asset('public/assets/ion.rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
    @include('public.scripts.swiper')
    <script>
        $.getReNewOrderAmount = function(data) {
            data = data || getOrderData();
            return $.ajax({
                url: '{{ route("proxyline.getAmountRenew") }}',
                method: 'get',
                data: data
            })
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
            return {
                period: parseInt($('input[name="period"]').val()),
                ids: $('input[name="proxy_ids"]').val()
            };
        }

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

            $.getReNewOrderAmount(data).done(function (amountData) {
                if (($("[data-order-submit]").data("updated") || 0) > updated) {
                    console.log("already updated");
                    return;
                }
                $("[data-order-submit]").data("updated", updated);

                var amount = amountData.amount;
                $(".js-order-amount").text(amount);
                
                if(amountData.success) {
                    $("[data-order-amount]").css("opacity", "");
                    $("[data-order-submit]").prop("disabled", false);
                }
            });
        }
        
        var updateCounter = 0;
        function updateOrderSummary() {
            updateCounter++;
            var localCounter = updateCounter;
            var data = getOrderData();
            console.log(data);
            $(".js-renew-period").text(data.period);
            
            setTimeout(function () {
                if (localCounter != updateCounter) {
                    return;
                }
                updateOrderAmount();
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
            var data = form.serializeArray();
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
