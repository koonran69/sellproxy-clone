@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@section('content')
    <div class="main-content">
        <section class="cart px-md-5 px-3 pb-5">
            <div class="row g-4">
                <div class="col-md-8">
                    <h1 class="text-bold">Giỏ hàng</h1>
                    @if ($cartContent)
                        <div class="p-3 border rounded">
                            <div class="row cart-header p-2 d-none d-sm-flex">
                                <div class="col-5">Tên mặt hàng</div>
                                <div class="col-2 text-center">Số lượng</div>
                                <div class="col-2 text-center">Giá</div>
                                <div class="col-2 text-center">Thành tiền</div>
                                <div class="col-1 text-center">Xóa</div>
                            </div>
                            @foreach ($cartContent as $cartItem)
                                <div data-price="{{ $cartItem->price }}" class="row cart-item d-flex align-items-center"
                                    data-row-id="{{ $cartItem->rowId }}">
                                    <div class="col-8 col-sm-5 d-flex align-items-center cart-item__name">
                                        {{--                                <input class="form-check-input me-2" type="checkbox"> --}}
                                        <img src="{{ asset($cartItem->options->image) }}" class="product-img me-2">
                                        <div>
                                            <strong>{{ $cartItem->name }}</strong>
                                            <div class="text-muted small">({{ $cartItem->options->variation_name }})</div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-4 col-sm-2  text-center d-flex align-items-center justify-content-center">
                                        <button class="btn btn-outline-secondary quantity-btn"
                                            onclick="changeQuantity(-1, this)">-</button>
                                        <span class="mx-2 quantity"
                                            data-quantity="{{ $cartItem->qty }}">{{ $cartItem->qty }}</span>
                                        <button class="btn btn-outline-secondary quantity-btn"
                                            onclick="changeQuantity(1, this)">+</button>
                                    </div>
                                    <div class="col-12 col-sm-2 text-end text-sm-center" data-price><span class="d-sm-none">
                                            Giá:</span> {{ number_format($cartItem->price) }}đ</div>
                                    <div class="col-12 col-sm-2 text-end text-sm-center" id="total-price"><span
                                            class="d-sm-none">Thành tiền:
                                        </span>{{ number_format($cartItem->price * $cartItem->qty) }}đ</div>
                                    <div class="col-12 col-sm-1 text-end text-sm-center">
                                        <button class="btn btn-sm btn-remove" onclick="removeItem(this)">
                                            <img width="16" height="16" class="m-auto cursor-pointer"
                                                src="{{ asset('public/assets/images/trash.svg') }}"
                                                style="color: transparent;">
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-3"><strong>Tổng: <span id="cart-total">0</span></strong></div>
                        </div>
                    @else
                        <div>
                            <p>@lang('Giỏ hàng rỗng')</p>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <p class="my-auto">@lang('Tổng'):</p>
                            <span class="fw-semibold" id="sub_total_bill">{{ number_format($sub_total) }}đ</span>
                        </div>
                        <div id="voucher">
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <p class="my-auto">@lang('Thành tiền'):</p>
                            <span class="fw-bold text-primary text-end"
                                id="total_bill">{{ number_format($sub_total) }}đ</span>
                        </div>
                        <hr class="my-4">

                        @if ($vouchers && !$vouchers->isEmpty())
                            <div class="input-group mb-4">
                                <select class="form-select" id="voucherSelect">
                                    <option selected disabled>@lang('Chọn mã voucher')</option>
                                    @foreach ($vouchers as $voucher)
                                        <option value="{{ $voucher->code }}">Mã: {{ $voucher->code }} - Giảm
                                            {{ $voucher->type == \App\Core\Enums\Voucher\VoucherType::Percentage ? $voucher->value . '%' : number_format((int) $voucher->value) . ' VNĐ' }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Nút áp dụng -->
                                <button class="btn btn-success" type="button" id="applyVoucher">
                                    @lang('Áp dụng')
                                </button>
                            </div>
                        @endif

                        <form id="frmCheckout" action="{{ route('order.place-order') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">@lang('Nhập email để nhận thông báo') <span class="text-danger">*</span>:</label>
                                <input value="{{ auth()->user()->email ?? '' }}" type="email" class="form-control"
                                    placeholder="Email" name="email" id="email">
                            </div>
                            <input type="hidden" name="payment_method" id="payment_method">
                            <input type="hidden" name="voucher_code" id="voucher_code">
                            <input type="hidden" name="crypto" id="crypto">
                        </form>
                        <button class="btn btn-primary w-100" id="btnCheckout"
                            @if ($cartContent->isEmpty()) disabled @endif>@lang('Thanh toán')
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" id="is_login" value="{{ Auth::check() }}">
    </div>
    @if (!Auth::check())
        @include('public.partials.modal_not_login')
    @else
        @include('public.partials.modal_payment_method')
    @endif
@endsection

@push('js')
    @include('public.scripts.swiper')
    <script src="{{ asset('public/assets/js/jquery.validate.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <script>
        document.getElementById('google-login').addEventListener('click', function() {
            google.accounts.oauth2.initTokenClient({
                client_id: "{{ config('services.google.client_id') }}",
                scope: "email profile",
                callback: (response) => {
                    if (response.access_token) {
                        fetch("{{ route('auth.google') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                token: response.access_token
                            })
                        }).then(res => res.json()).then(data => {
                            console.log("Login success:", data);
                            window.location = data.redirect_url;
                        }).catch(err => console.error("Error:", err));
                    }
                }
            }).requestAccessToken();
        });
    </script>

    <script>
        updateCartTotal();
        //updateTotalPrice();

        function changeQuantity(amount, btn) {
            let quantityEl = btn.parentElement.querySelector('.quantity');
            let totalPriceEl = btn.parentElement.parentElement.querySelector('#total-price');
            let quantity = parseInt(quantityEl.innerText);
            let cartItem = btn.closest('.cart-item');
            let pricePerItem = cartItem.getAttribute("data-price");

            let rowId = cartItem.getAttribute('data-row-id');
            if (quantity + amount >= 1) {
                quantity += amount;
                quantityEl.innerText = quantity;
                totalPriceEl.innerText = number_format(pricePerItem * quantity) + 'đ';
                updateCartTotal();
                $(quantityEl).attr("data-quantity", quantity);
                updateTotalPrice();
                var data = {
                    "rowId": rowId,
                    "quantity": quantity
                }
                $.ajax({
                    method: 'post',
                    url: '{{ route('cart.updateCartItem') }}',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data
                }).done(function(res) {
                    // if(res.status) {
                    //     $("#cart_count").text(res.count);
                    // }
                    msgSuccess(window.__trans("Cập nhật giỏ hàng thành công"));
                }).fail(function(res) {
                    window.location.reload();
                });
            }
        }

        function removeItem(t) {
            var rowId = $(t).parents(".cart-item").data("row-id");
            var data = {
                "rowId": rowId
            }
            $(t).parents(".cart-item").remove();

            updateCartTotal();

            $.ajax({
                method: 'post',
                url: '{{ route('cart.removeFromCart') }}',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data
            }).done(function(res) {
                if (res.status) {
                    $("#cart_count_total").text(res.count);
                }
            }).fail(function(res) {
                window.location.reload();
            });
        }

        function updateCartTotal() {
            let items = document.querySelectorAll('.cart-item');
            document.getElementById('cart-total').innerText = items.length;
        }

        function updateTotalPrice() {
            let total = 0;
            $.each($(".cart-item"), function(i, e) {
                var price = $(e).data('price');
                var quantity = $(e).find('.quantity').stop().attr('data-quantity');
                total += price * quantity;
                console.log(quantity);
            });
            $("#sub_total_bill").text(number_format(total) + "đ");
            $("#total_bill").text(number_format(total) + "đ");
        }

        $("#btnCheckout").on("click", function() {
            var is_login = $("#is_login").val();
            if (is_login) {
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
            $("#frmCheckout").submit();
        }
        let is_submit = false;

        $('#frmCheckout').validate({
            ignore: ".ignore",
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Email là bắt buộc",
                    email: "Vui lòng nhập đúng định dạng email"
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                $('#paymentModal').modal('show');
            }
        });

        $('#paymentModal').on('show.bs.modal', function() {
            var totalBillText = $("#total_bill").text().trim();
            var currentTotal = parseFloat(totalBillText.replace(/[,đ]/g, ''));
            if (!isNaN(currentTotal) && currentTotal > 0) {
                updateWalletButtonState(currentTotal);
            }
        });

        $(document).ready(function() {
            initActionPaymentMethod();
            $(".btn-next-payment").on("click", function() {
                processChoosePaymentMethod($("#frmCheckout"));
            });

            $("#btn-confirm-payment-wallet").on("click", function() {
                $(this).attr("disabled", true);
                $("#modalAjaxConfirm").modal('hide');
                requestAjaxSendCheckout($("#frmCheckout"));
            });

            $('#modalAjaxConfirm').on('shown.bs.modal', function() {
                $("#btn-confirm-payment-wallet").attr("disabled", false);
            });

            $("#applyVoucher").on("click", function() {
                var code = $("#voucherSelect").val();
                if (!code) {
                    return;
                }
                $.ajax({
                    method: 'post',
                    url: '{{ route('account.voucher.apply') }}',
                    dataType: 'json',
                    data: {
                        'code': code,
                        '_token': '{{ csrf_token() }}'
                    }
                }).done(function(res) {
                    if (res.success) {
                        msgSuccess(res.message);
                        var html = `<div class="d-flex justify-content-between mb-3">
                                <p class="">Voucher:</p>
                                <span class="fw-bold text-primary text-end d-flex flex-column gap-2" id="total_bill">
                                    <span>` + res.voucher.code + `</span>
                                    <span class="text-success">- ` + res.discount + `đ</span>
                                </span>
                            </div>`;
                        $("#total_bill").html(res.total_after_discount);
                        $("#voucher").html(html);
                        $("#voucher_code").val(res.voucher.code);

                        // Update wallet button state with discounted price
                        var finalAmount = parseFloat(res.total_after_discount.replace(/,/g, ''));
                        updateWalletButtonState(finalAmount);
                    } else {
                        msgError(res.message)
                    }
                }).fail(function(res) {
                    msgError('Có lỗi xảy ra');
                });
            });

            $("#btnCrypto").click(function() {
                $(".page-container").css("transform", "translateX(-50%)");
                // $("#modalTitle").text("Chọn đồng tiền điện tử");
            });

            $("#btnBack").click(function() {
                $(".page-container").css("transform", "translateX(0)");
                // $("#modalTitle").text("Chọn phương thức thanh toán");
            });

            $('#cryptoSelect').select2({
                templateResult: formatOption,
                templateSelection: formatOption,
                dropdownParent: $('#paymentModal'),
                minimumResultsForSearch: 1
            });
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
                if (res.success) {
                    msgSuccess(window.__trans("Đặt hàng thành công"));
                    setTimeout(function () {
                        if (res.payment_method && (res.payment_method == "coin" || res.payment_method == "heleket")) {
                            var newWindow = window.open(res.redirect_url, "_blank");
                            if (!newWindow) {
                                alert("Hãy cho phép mở popup khi thực hiện thanh toán.");
                            }
                            $('#paymentModal').modal('hide');
                        } else {
                            window.location.href = res.redirect_url;
                        }
                    }, 3000);
                } else {
                    msgError(window.__trans(res.message));
                }
            }).fail(function(res) {
                //window.location.reload();
            });
        }

        function processChoosePaymentMethod() {
            var payment_method = $("#payment_method").val();
            if (payment_method == "banking") {
                requestAjaxSendCheckout($("#frmCheckout"));
            } else if (payment_method == "wallet") {
                new bootstrap.Modal(document.getElementById("modalAjaxConfirm")).show();
            } else if (payment_method == "coin" || payment_method == "heleket") {
                requestAjaxSendCheckout($("#frmCheckout"));
            } else {
                alert('Vui lòng chọn phương thức thanh toán');
            }
        }

        function initActionPaymentMethod() {
            $("#group-payment-method button").on("click", function() {
                $("#group-payment-method button").removeClass("active");
                $(this).addClass("active");
                $("#payment_method").val($(this).val());
                checkNextActionPaymentMethod();
            });
        }

        function checkNextActionPaymentMethod() {
            let payment_method = $("#payment_method").val();
            if (payment_method == "banking" || payment_method == "wallet" || payment_method == "coin" || payment_method ==
                "heleket") {
                $("#paymentModal .btn-next-payment").removeClass("btn-secondary");
                $("#paymentModal .btn-next-payment").addClass("btn-primary");
                $("#paymentModal .btn-next-payment").attr("disabled", false);
            }
        }

        function formatOption(option) {
            if (!option.id) return option.text;
            const image = $(option.element).data('image');
            if (image) {
                return $(
                    `<span><img src="${image}" class="me-2" style="width: 20px; height: 20px;"> ${option.text}</span>`
                );
            }
            return $(
                `<span>${option.text}</span>`
            );
        }

        function updateWalletButtonState(currentTotal) {
            var walletBtn = $("#btn-wallet-payment");
            var availableBalance = parseFloat(walletBtn.attr("data-available-balance"));
            var warningDiv = $("#wallet-warning");

            walletBtn.attr("data-current-total", currentTotal);

            if (availableBalance < currentTotal) {
                walletBtn.attr("disabled", true);
                walletBtn.removeClass("active");
                warningDiv.css("display", "flex").show();

                if ($("#payment_method").val() === "wallet") {
                    $("#payment_method").val("");
                    $(".btn-next-payment").attr("disabled", true);
                    $(".btn-next-payment").removeClass("btn-primary").addClass("btn-secondary");
                }
            } else {
                walletBtn.attr("disabled", false);
                warningDiv.hide();
            }
        }
    </script>
@endpush
