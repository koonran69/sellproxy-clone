@extends("proxyhome.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3  class="page-title">Proxy Xoay</h3>
            <div class="proxy-rotate">
                <div class="row g-3">
                    <!-- Card: Proxy xoay 1 ngày -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="prx-card" data-price="3000" data-type-unit="day">
                            <div class="prx-card__head">
                                <h6 class="mb-0 fw-bold">Proxy xoay 1 ngày</h6>
                            </div>

                            <ul class="prx-features list-unstyled mb-3">
                                <li><span class="i ok"></span> <b>Kiểu mạng:</b> Cáp quang</li>
                                <li><span class="i ok"></span> IPv4 sạch-Unlimited Bandwidth</li>
                                <li><span class="i ok"></span> <b>Nhà mạng:</b>
                                    <span class="prx-logos">
                                      <img src="{{asset('public/proxyhome/assets/images/viettel.png') }}" alt="Viettel">
                                      <img src="{{asset('public/proxyhome/assets/images/fpt.png') }}" alt="FPT">
                                      <img src="{{asset('public/proxyhome/assets/images/vnpt.png') }}" alt="VNPT">
                                    </span>
                                </li>
                                <li><span class="i ok"></span> Thời gian đổi IP tối thiểu <b class="text-danger">60 giây</b> / lần</li>
                                <li><span class="i ok"></span> Giữ IP tối đa <b class="text-danger">30 phút</b></li>
                                <li><span class="i ok"></span> <b>Vị trí:</b> <a href="#" class="link-primary text-decoration-none">Ngẫu nhiên</a></li>
                            </ul>

                            <div class="prx-form">
                                <div class="mb-2">
                                    <label class="form-label">Ngày sử dụng</label>
                                    <input type="number" min="1" value="1" class="form-control js-unit">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" min="1" value="1" class="form-control js-qty">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Tài khoản</label>
                                    <input type="text" value="random" class="form-control js-user" disabled>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Mật khẩu</label>
                                    <input type="text" value="random" class="form-control js-pass">
                                </div>

                                <div class="form-check mb-2">
                                    <input value="1" class="form-check-input js-auto" type="checkbox" id="autoRotateDay">
                                    <label class="form-check-label" for="autoRotateDay">Tự động xoay</label>
                                </div>

                                <div id="isRotate" class="mb-3" style="display: none;">
                                    <label class="form-label">Thời gian xoay (phút)</label>
                                    <input type="number" name="rotateInterval" min="1" value="1" class="form-control js-rotate-time">
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Thành tiền:</span>
                                    <span class="prx-price js-total">0đ</span>
                                </div>

                                @if (auth()->check())
                                    <button class="btn btn-danger w-100 prx-buy js-buy">Mua hàng</button>
                                @else
                                    <a href="{{route('auth.login')}}" class="btn btn-primary w-100">Đăng nhập</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card: Proxy xoay 1 tuần -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="prx-card" data-price="21000" data-type-unit="week">
                            <div class="prx-card__head">
                                <h6 class="mb-0 fw-bold">Proxy xoay 1 tuần</h6>
                            </div>

                            <ul class="prx-features list-unstyled mb-3">
                                <li><span class="i ok"></span> <b>Kiểu mạng:</b> Cáp quang</li>
                                <li><span class="i ok"></span> IPv4 sạch-Unlimited Bandwidth</li>
                                <li><span class="i ok"></span> <b>Nhà mạng:</b>
                                    <span class="prx-logos">
                                        <img src="{{asset('public/proxyhome/assets/images/viettel.png') }}" alt="Viettel">
                                        <img src="{{asset('public/proxyhome/assets/images/fpt.png') }}" alt="FPT">
                                        <img src="{{asset('public/proxyhome/assets/images/vnpt.png') }}" alt="VNPT">
                                    </span>
                                </li>
                                <li><span class="i ok"></span> Thời gian đổi IP tối thiểu <b class="text-danger">60 giây</b> / lần</li>
                                <li><span class="i ok"></span> Giữ IP tối đa <b class="text-danger">30 phút</b></li>
                                <li><span class="i ok"></span> <b>Vị trí:</b> <a href="#" class="link-primary text-decoration-none">Ngẫu nhiên</a></li>
                            </ul>

                            <div class="prx-form">
                                <div class="mb-2">
                                    <label class="form-label">Tuần sử dụng</label>
                                    <input type="number" min="1" value="1" class="form-control js-unit">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" min="1" value="1" class="form-control js-qty">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Tài khoản</label>
                                    <input type="text" value="random" class="form-control js-user" disabled>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Mật khẩu</label>
                                    <input type="text" value="random" class="form-control js-pass">
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input js-auto" type="checkbox" id="autoRotateWeek">
                                    <label class="form-check-label" for="autoRotateWeek">Tự động xoay</label>
                                </div>

                                <div id="isRotate" class="mb-3" style="display: none;">
                                    <label class="form-label">Thời gian xoay (phút)</label>
                                    <input type="number" name="rotateInterval" min="1" value="1" class="form-control js-rotate-time">
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Thành tiền:</span>
                                    <span class="prx-price js-total">0đ</span>
                                </div>
                                @if (auth()->check())
                                    <button class="btn btn-danger w-100 prx-buy js-buy">Mua hàng</button>
                                @else
                                    <a href="{{route('auth.login')}}" class="btn btn-primary w-100">Đăng nhập</a>
                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- Card: Proxy xoay 1 tháng -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="prx-card" data-price="67500" data-type-unit="month">
                            <div class="prx-card__head">
                                <h6 class="mb-0 fw-bold">Proxy xoay 1 tháng</h6>
                            </div>

                            <ul class="prx-features list-unstyled mb-3">
                                <li><span class="i ok"></span> <b>Kiểu mạng:</b> Cáp quang</li>
                                <li><span class="i ok"></span> IPv4 sạch-Unlimited Bandwidth</li>
                                <li><span class="i ok"></span> <b>Nhà mạng:</b>
                                    <span class="prx-logos">
                                        <img src="{{asset('public/proxyhome/assets/images/viettel.png') }}" alt="Viettel">
                                        <img src="{{asset('public/proxyhome/assets/images/fpt.png') }}" alt="FPT">
                                        <img src="{{asset('public/proxyhome/assets/images/vnpt.png') }}" alt="VNPT">
                                    </span>
                                </li>
                                <li><span class="i ok"></span> Thời gian đổi IP tối thiểu <b class="text-danger">60 giây</b> / lần</li>
                                <li><span class="i ok"></span> Giữ IP tối đa <b class="text-danger">30 phút</b></li>
                                <li><span class="i ok"></span> <b>Vị trí:</b> <a href="#" class="link-primary text-decoration-none">Ngẫu nhiên</a></li>
                            </ul>

                            <div class="prx-form">
                                <div class="mb-2">
                                    <label class="form-label">Tháng sử dụng</label>
                                    <input type="number" min="1" value="1" class="form-control js-unit">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Số lượng</label>
                                    <input type="number" min="1" value="1" class="form-control js-qty">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Tài khoản</label>
                                    <input type="text" value="random" class="form-control js-user" disabled>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Mật khẩu</label>
                                    <input type="text" value="random" class="form-control js-pass">
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input js-auto" type="checkbox" id="autoRotateMonth">
                                    <label class="form-check-label" for="autoRotateMonth">Tự động xoay</label>
                                </div>

                                <div id="isRotate" class="mb-3" style="display: none;">
                                    <label class="form-label">Thời gian xoay (phút)</label>
                                    <input type="number" name="rotateInterval" min="1" value="1" class="form-control js-rotate-time">
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Thành tiền:</span>
                                    <span class="prx-price js-total">0đ</span>
                                </div>

                                @if (auth()->check())
                                    <button class="btn btn-danger w-100 prx-buy js-buy">Mua hàng</button>
                                @else
                                    <a href="{{route('auth.login')}}" class="btn btn-primary w-100">Đăng nhập</a>
                                @endif
                            </div>
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
                    @if (auth()->check())
                        <button type="button" class="btn btn-primary w-100 js-confirm">Thanh toán</button>
                    @else
                        <a href="{{route('auth.login')}}" class="btn btn-primary w-100">Đăng nhập</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function() {

            $('#autoRotateDay, #autoRotateWeek, #autoRotateMonth').change(function() {

                if ($(this).is(':checked')) {
                    $(this).parents('.prx-form').find('#isRotate').show();
                }else {
                    $(this).parents('.prx-form').find('#isRotate').hide();
                }
            })
        });

        (function($){

            const ORDER_URL = '{{ route('proxyhome.proxyRotateOrder') }}';
            const csrf   = () => $('meta[name="csrf-token"]').attr('content') || '';
            function formatVND(n){
                n = Number(n) || 0;
                return n.toLocaleString('vi-VN') + 'đ';
            }

            function clampMin1(v){
                v = parseInt(v, 10);
                if (isNaN(v) || v < 1) return 1;
                return v;
            }

            function recalc($card){
                const base   = parseInt($card.data('price'), 10) || 0;
                const unit   = clampMin1($card.find('.js-unit').val());
                const qty    = clampMin1($card.find('.js-qty').val());
                const total  = base * unit * qty;

                $card.find('.js-unit').val(unit);
                $card.find('.js-qty').val(qty);
                $card.find('.js-total').text(formatVND(total));
            }

            $(document).on('input change', '.proxy-rotate .prx-card .js-unit, .proxy-rotate .prx-card .js-qty', function(){
                const $card = $(this).closest('.prx-card');
                recalc($card);
            });

            $(function(){
                $('.proxy-rotate .prx-card').each(function(){ recalc($(this)); });
            });

            function initAutoRotate($card){
                const $auto   = $card.find('.js-auto');
                const $rotate = $card.find('.js-rotate-time');

                // Mặc định disable
                $auto.prop('checked', false);
                $rotate.prop('disabled', true);

                // Khi check thì enable
                $auto.on('change', function(){
                    if($(this).is(':checked')){
                        $rotate.prop('disabled', false);
                    } else {
                        $rotate.prop('disabled', true);
                    }
                });
            }

            $(function(){
                $('.proxy-rotate .prx-card').each(function(){
                    initAutoRotate($(this));
                });
            });

            function baseAmountFromCard($card){
                const unit = parseInt($card.attr('data-price'),10) || 0;
                const days = clampMin1($card.find('.js-unit').val());
                const qty  = clampMin1($card.find('.js-qty').val());
                return unit * days * qty;
            }

            function collectPayload($card){
                const unit     = clampMin1($card.find('.js-unit').val());
                const qty      = clampMin1($card.find('.js-qty').val());
                const user     = ($card.find('.js-user').val()||'').trim();
                const pass     = ($card.find('.js-pass').val()||'').trim();
                const interval     = ($card.find('.js-rotate-time').val()|| 1).trim();
                const auto     = ($card.find('.js-auto').prop('checked'));
                const typeUnit     = $card.attr('data-type-unit');
                const p = {
                    unit: unit,
                    quantity: qty,
                    user: user,
                    password: pass,
                    interval: interval,
                    auto: auto,
                    typeUnit: typeUnit
                };
                console.log(p);
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

            $(document).on('click.psCheckout', '.proxy-rotate .prx-buy', function(){
                const $card   = $(this).closest('.prx-card');
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
                $modal.find('.js-invoice-fee').text(formatVND(Math.round(base*0.10)));
                $modal.find('.js-grand').text(formatVND(base));

                const bsModal = new bootstrap.Modal($modal[0]);
                bsModal.show();
            });

            $(document).on('click.psCheckout', '#psCheckoutModal .js-confirm', function(){
                const $modal = $('#psCheckoutModal');
                const ctx = $modal.data('ctx') || {};
                if (!ctx.$card || !ctx.payload) return;

                const payload = Object.assign({}, ctx.payload, {
                    payment_method: ctx.method,
                    with_invoice: !!ctx.withInvoice
                });

                const $btn = $(this);
                $btn.prop('disabled', true).text('Đang xử lý...');

                submitOrder(payload)
                    .done(function(res){

                        if(res.status)
                        {
                            const inst = bootstrap.Modal.getInstance($modal[0]);
                            inst && inst.hide();
                            const amount = res.amount ? formatVND(res.amount) : formatVND(ctx.baseAmount);
                            toastr.success('Tạo đơn thành công!', 'Thành công');
                            window.location.href = '/proxy-home/proxies/rotate';
                        }else {
                            alert(res.message);
                        }
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
        })(jQuery);


    </script>
@stop
