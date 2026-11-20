@extends("proxyhome.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3  class="page-title">Proxy Tĩnh</h3>
            <div class="proxy-static-list proxy-static">
                <div class="proxy-card proxy-viettel p-3 mb-4"
                     data-unit-price="1200"
                     data-provider="VIETTEL"
                >
                    <div class="row g-3 align-items-center">
                        <!-- Logo -->
                        <div class="col-md-2 text-center">
                            <div class="proxy-logo">
                                <img src="{{asset('public/proxyhome/assets/images/viettel.png') }}" alt="Viettel">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="row g-2">
                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Location</label>
                                    <select class="form-select js-location">
                                        @foreach($locations as $code => $location)
                                            <option value="{{ $code }}">{{ $location }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-2">
                                    <label class="form-label">Ngày sử dụng</label>
                                    <input type="number" class="form-control js-days" value="1">
                                </div>

                                <div class="col-sm-6 col-lg-2">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" class="form-control js-qty" value="1">
                                </div>

                                <div class="col-sm-6 col-lg-2">
                                    <label class="form-label">Đầu Ip</label>
                                    <select class="form-select">
                                        <option selected>Random</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Giao thức</label>
                                    <select class="form-select js-protocol">
                                        <option>HTTP</option>
                                        {{-- <option>HTTPS</option> --}}
                                        <option>SOCKS</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Tài khoản</label>
                                    <input type="text" class="form-control js-user" value="random">
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Mật khẩu</label>
                                    <input type="text" class="form-control js-pass" value="random">
                                </div>
                            </div>
                        </div>

                        <!-- Price + Button -->
                        <div class="col-md-2 text-center">
                            <div class="proxy-price js-total">1,200đ</div>
                            @if (auth()->check())
                                <button class="btn btn-buy mt-2 js-buy">Mua hàng</button>
                            @else
                                <a href="{{route('auth.login')}}" class="btn btn-buy mt-2 js-buy">Đăng nhập</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="proxy-card proxy-vnpt p-3 mb-4"
                     data-unit-price="1200"
                     data-provider="VNPT"
                >
                    <div class="row g-3 align-items-center">
                        <!-- Logo -->
                        <div class="col-md-2 text-center">
                            <div class="proxy-logo">
                                <img src="{{asset('public/proxyhome/assets/images/vnpt.png') }}" alt="VNPT">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="row g-2">
                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Location</label>
                                    <select class="form-select js-location">
                                        @foreach($locations as $code => $location)
                                            <option value="{{ $code }}">{{ $location }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-2">
                                    <label class="form-label">Ngày sử dụng</label>
                                    <input type="number" class="form-control js-days" value="1">
                                </div>

                                <div class="col-sm-6 col-lg-2">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" class="form-control js-qty" value="1">
                                </div>

                                <div class="col-sm-6 col-lg-2">
                                    <label class="form-label">Đầu Ip</label>
                                    <select class="form-select">
                                        <option selected>Random</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Giao thức</label>
                                    <select class="form-select js-protocol">
                                        <option>HTTP</option>
                                        {{-- <option>HTTPS</option> --}}
                                        <option>SOCKS</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Tài khoản</label>
                                    <input type="text" class="form-control js-user" value="random">
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Mật khẩu</label>
                                    <input type="text" class="form-control js-pass" value="random">
                                </div>
                            </div>
                        </div>

                        <!-- Price + Button -->
                        <div class="col-md-2 text-center">
                            <div class="proxy-price js-total">1,200đ</div>
                            @if (auth()->check())
                                <button class="btn btn-buy mt-2 js-buy">Mua hàng</button>
                            @else
                                <a href="{{route('auth.login')}}" class="btn btn-buy mt-2 js-buy">Đăng nhập</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="proxy-card proxy-fpt p-3 mb-4"
                     data-unit-price="1200"
                     data-provider="FPT"
                >
                    <div class="row g-3 align-items-center">
                        <!-- Logo -->
                        <div class="col-md-2 text-center">
                            <div class="proxy-logo">
                                <img src="{{asset('public/proxyhome/assets/images/fpt.png') }}" alt="FPT">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="row g-2">
                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Location</label>
                                    <select class="form-select js-location">
                                        @foreach($locations as $code => $location)
                                            <option value="{{ $code }}">{{ $location }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-2">
                                    <label class="form-label">Ngày sử dụng</label>
                                    <input type="number" class="form-control js-days" value="1">
                                </div>

                                <div class="col-sm-6 col-lg-2">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" class="form-control js-qty" value="1">
                                </div>

                                <div class="col-sm-6 col-lg-2">
                                    <label class="form-label">Đầu Ip</label>
                                    <select class="form-select">
                                        <option selected>Random</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Giao thức</label>
                                    <select class="form-select js-protocol">
                                        <option>HTTP</option>
                                        {{-- <option>HTTPS</option> --}}
                                        <option>SOCKS</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Tài khoản</label>
                                    <input type="text" class="form-control js-user" value="random">
                                </div>

                                <div class="col-sm-6 col-lg-3">
                                    <label class="form-label">Mật khẩu</label>
                                    <input type="text" class="form-control js-pass" value="random">
                                </div>
                            </div>
                        </div>

                        <!-- Price + Button -->
                        <div class="col-md-2 text-center">
                            <div class="proxy-price js-total">1,200đ</div>
                            @if (auth()->check())
                                <button class="btn btn-buy mt-2 js-buy">Mua hàng</button>
                            @else
                                <a href="{{route('auth.login')}}" class="btn btn-buy mt-2 js-buy">Đăng nhập</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade ps-checkout" id="psCheckoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Chọn hình thức thanh toán</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body pt-0">
                    <div class="d-flex gap-3 flex-wrap justify-content-center">
                        <!-- Ví của tôi (mặc định chọn) -->
                        <button type="button" class="ps-payopt active" data-method="WALLET">
                            <span class="ps-icon"><img src="{{ asset('public/assets/images/wallet-bold.svg') }}" alt=""></span>
                            <span class="ps-label">Ví của tôi</span>
                        </button>
                    </div>
                </div>

                <div class="modal-footer border-0 d-block">
                    <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                        <span class="text-muted">Tổng thanh toán</span>
                        <span class="fw-bold js-grand">0đ</span>
                    </div>
                    <button type="button" class="btn btn-primary w-100 js-confirm">Thanh toán</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<input type="hidden" id="priceList" value="{{ json_encode($prices) }}" />
    <script>
        const unit_prices = @json($unit_prices);

        function getPricePerDay(day, provider)
        {
            // const arr = JSON.parse($("#priceList").val());
            //
            // if(day > 30)
            // {
            //     var add = day - 30;
            //
            //     return arr[30] + (600 * add);
            // }
            //
            // return arr[day];

            // 1. Lấy giá gốc của nhà mạng (mặc định 1200 nếu không tìm thấy)
            let basePrice = unit_prices[provider] || 1200;
            let discount = 0;

            // 2. Tính toán tỷ lệ giảm giá theo mốc ngày
            if (day >= 1 && day <= 5) {
                discount = 0; // Không giảm
            } else if (day >= 6 && day <= 10) {
                discount = 0.1; // Giảm 10%
            } else if (day >= 11 && day <= 20) {
                discount = 0.2; // Giảm 20%
            } else if (day >= 21 && day <= 25) {
                discount = 0.3; // Giảm 30%
            } else if (day >= 26) {
                discount = 0.4; // Giảm 40%
            }

            // 3. Tính giá sau khi giảm cho 1 ngày
            let discountedPricePerDay = basePrice * (1 - discount);

            // 4. Tổng giá = (Giá 1 ngày đã giảm) * (Số ngày)
            return Math.round(discountedPricePerDay * day);
        }

        (function($){
            function formatVND(n){
                n = Number(n) || 0;
                return n.toLocaleString('vi-VN') + 'đ';
            }
            function min1(v){
                v = parseInt(v, 10);
                return (isNaN(v) || v < 1) ? 1 : v;
            }


            function recalc($card)
            {
                const provider = $card.data('provider'); // Lấy VIETTEL, VNPT hoặc FPT
                const days = min1( $card.find('.js-days').val() );
                const unitPrice = getPricePerDay(days,provider);
                const qty  = min1( $card.find('.js-qty').val() );
                const total = unitPrice * qty;
                $card.find('.js-days').val(days);
                $card.find('.js-qty').val(qty);
                $card.find('.js-total').text( formatVND(total) );
            }

            $(document).on('change input', '.proxy-static .js-days, .proxy-static .js-qty', function(){
                recalc( $(this).closest('.proxy-card') );
            });

            $(function(){
                $('.proxy-static .proxy-card').each(function(){ recalc($(this)); });
            });

        })(jQuery);
    </script>

    <script>
        const ORDER_URL = '{{ route('proxyhome.proxyStaticOrder') }}';

        const csrf   = () => $('meta[name="csrf-token"]').attr('content') || '';
        const vnd    = n => (Number(n)||0).toLocaleString('vi-VN') + 'đ';
        const clamp1 = v => { v=parseInt(v,10); return (isNaN(v)||v<1)?1:v; };

        function baseAmountFromCard($card){
            // const unit = parseInt($card.attr('data-unit-price'),10) || 0;
            const provider = $card.data('provider');
            const days = clamp1($card.find('.js-days').val());
            // const unitPrice = parseInt(getPricePerDay(days));
            const qty  = clamp1($card.find('.js-qty').val());
            return getPricePerDay(days, provider) * qty;
        }

        function collectPayload($card){
            const provider = ($card.data('provider')||'').toString().toUpperCase();
            const days     = clamp1($card.find('.js-days').val());
            const qty      = clamp1($card.find('.js-qty').val());
            const protocol = ($card.find('.js-protocol').val()||'').toString().toLowerCase();
            const location = ($card.find('.js-location').val()||'').trim();
            const user     = ($card.find('.js-user').val()||'').trim();
            const pass     = ($card.find('.js-pass').val()||'').trim();

            const p = {
                provider: provider,
                days: days,
                quantity: qty,
                protocolType: protocol,
                user: user,
                password: pass
            };
            console.log(p);
            if (location) p.location = location;
            return p;
        }

        function submitOrder(payload){
            return $.ajax({
                url: ORDER_URL,
                method: 'POST',
                data: JSON.stringify(payload),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': csrf() }
            });
        }

        $(document).off('click.psBuyWeb');

        $(document).on('click.psCheckout', '.proxy-static .js-buy', function(){
            const $card   = $(this).closest('.proxy-card');
            const $modal  = $('#psCheckoutModal');
            const base    = baseAmountFromCard($card);

            $modal.data('ctx', {
                $card: $card,
                payload: collectPayload($card),
                method: 'WALLET',
                baseAmount: base,
                withInvoice: false
            });

            $modal.find('.ps-payopt').removeClass('active').first().addClass('active');
            $modal.find('.js-invoice').prop('checked', false);
            $modal.find('.js-invoice-fee').text(vnd(Math.round(base*0.10)));
            $modal.find('.js-grand').text(vnd(base));

            const bsModal = new bootstrap.Modal($modal[0]);
            bsModal.show();
        });

        $(document).on('click.psCheckout', '#psCheckoutModal .ps-payopt:not(.disabled)', function(){
            const $modal = $('#psCheckoutModal');
            $modal.find('.ps-payopt').removeClass('active');
            $(this).addClass('active');
            const ctx = $modal.data('ctx') || {};
            ctx.method = $(this).data('method') || 'WALLET';
            $modal.data('ctx', ctx);
        });

        $(document).on('change.psCheckout', '#psCheckoutModal .js-invoice', function(){
            const $modal = $('#psCheckoutModal');
            const ctx = $modal.data('ctx') || {};
            ctx.withInvoice = $(this).is(':checked');
            $modal.data('ctx', ctx);

            const fee   = Math.round((ctx.baseAmount||0) * 0.10);
            const grand = (ctx.baseAmount||0) + (ctx.withInvoice ? fee : 0);

            $modal.find('.js-invoice-fee').text(vnd(fee));
            $modal.find('.js-grand').text(vnd(grand));
        });

        $(document).on('click.psCheckout', '#psCheckoutModal .js-confirm', function(){
            const $modal = $('#psCheckoutModal');
            const ctx = $modal.data('ctx') || {};
            if (!ctx.$card || !ctx.payload) return;

            const payload = Object.assign({}, ctx.payload, {
                payment_method: ctx.method,     // "WALLET"
                with_invoice: !!ctx.withInvoice // true/false
            });

            const $btn = $(this);
            $btn.prop('disabled', true).text('Đang xử lý...');

            submitOrder(payload)
                .done(function(res){
                    // đóng modal + thông báo
                    const inst = bootstrap.Modal.getInstance($modal[0]);
                    inst && inst.hide();
                    const amount = res.amount ? vnd(res.amount) : vnd(ctx.baseAmount);
                    toastr.success('Tạo đơn thành công!', 'Thành công');
                    window.location.href = '{{route('proxyhome.listProxies')}}';
                })
                .fail(function(xhr){
                    let msg = 'Tạo đơn thất bại.';
                    if (xhr.status === 419) msg = 'Hết hạn CSRF, vui lòng tải lại trang.';
                    try { if (xhr.responseJSON?.message) msg = xhr.responseJSON.message; } catch(e){}
                    alert(msg);
                })
                .always(function(){
                    $btn.prop('disabled', false).text('Thanh toán');
                });
        });

    </script>
@stop
