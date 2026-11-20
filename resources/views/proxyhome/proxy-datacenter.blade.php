@extends("proxyhome.layout")

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h3 class="page-title mb-4">PROXY DATACENTER</h3>

            @foreach($datacenters as $key => $dc)
                <div class="proxy-card p-3 mb-4 border rounded-3 position-relative" data-provider="{{$dc['provider']}}" data-name="{{$key}}" data-price="{{ $dc['price'] }}" data-old-price="{{ $dc['old_price'] ?? $dc['price'] }}" data-tiers="{{ json_encode($dc['tiers']) }}">
                    @if($dc['base_discount_label'])
                        <div class="badge bg-danger position-absolute" style="top:10px; left:10px; z-index:1; font-size: 1rem; border-radius: 15px">{{ $dc['base_discount_label'] }}</div>
                    @endif

                    <div class="row align-items-center g-3">
                        <div class="col-md-2 text-center">
                            <img src="{{ asset('public/proxyhome/assets/images/flags/'.$dc['flag']) }}" class="img-fluid rounded" style="width: 120px;">
                        </div>

                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-muted small">Location</label>
                                    <select class="form-select js-location"><option value="random">Random</option></select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-muted small">Tháng sử dụng</label>
                                    <input type="number" class="form-control js-unit" value="1">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-muted small">Số lượng</label>
                                    <input type="number" class="form-control js-qty" value="1">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-muted small">Đầu Ip</label>
                                    <select class="form-select"><option>Random</option></select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-muted small">Giao thức</label>
                                    <select class="form-select js-protocol">
                                        <option value="HTTP">HTTP</option>
                                        <option value="SOCKS">SOCKS</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-muted small">Tài khoản</label>
                                    <input type="text" class="form-control js-user" value="" placeholder="random">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-muted small">Mật khẩu</label>
                                    <input type="text" class="form-control js-pass" value="" placeholder="random">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 text-center">
                            <div class="mb-2">
                                <div class="fw-bold text-danger fs-5 js-total">{{ number_format($dc['price']) }}đ</div>
                                <small class="text-decoration-line-through text-muted js-old-total d-block">
                                    @if($dc['old_price']) {{ number_format($dc['old_price']) }}đ @endif
                                </small>
                            </div>
                            @if (auth()->check())
                                <button class="btn btn-buy mt-2 prx-buy">Mua hàng</button>
                            @else
                                <a href="{{route('auth.login')}}" class="btn btn-buy mt-2">Đăng nhập</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
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
    <script>
        (function($){
            const csrf = () => $('meta[name="csrf-token"]').attr('content');
            function formatVND(n){ return (Number(n)||0).toLocaleString('vi-VN') + 'đ'; }

            function recalc($card) {
                const basePrice = parseInt($card.data('price')) || 0;
                const oldBasePrice = parseInt($card.data('old-price')) || basePrice;
                const tiers = $card.data('tiers');

                const months = parseInt($card.find('.js-unit').val()) || 1;
                const qty    = parseInt($card.find('.js-qty').val()) || 1;

                let discountRate = 0;
                if (tiers) {
                    $.each(tiers, function(minMonths, rate) {
                        if (months >= parseInt(minMonths)) {
                            discountRate = parseFloat(rate);
                        }
                    });
                }

                const pricePerMonth = basePrice * (1 - discountRate);
                const total = Math.round(pricePerMonth * months * qty);
                const oldTotal = oldBasePrice * months * qty;

                $card.find('.js-total').text(formatVND(total));

                if (oldTotal > total) {
                    $card.find('.js-old-total').text(formatVND(oldTotal)).show();
                } else {
                    $card.find('.js-old-total').hide();
                }

                return total;
            }

            $(document).on('input change', '.js-unit, .js-qty', function(){
                recalc($(this).closest('.proxy-card'));
            });

            $('.proxy-card').each(function(){ recalc($(this)); });

            $(document).on('click', '.prx-buy', function(){
                const $card = $(this).closest('.proxy-card');
                const $modal = $('#psCheckoutModal');
                const totalAmount = recalc($card);

                $modal.data('ctx', {
                    payload: {
                        unit: $card.find('.js-unit').val(),
                        quantity: $card.find('.js-qty').val(),
                        protocol: $card.find('.js-protocol').val(),
                        location: $card.find('.js-location').val(),
                        provider: $card.data('provider'),
                        user: ($card.find('.js-user').val()||'random').trim(),
                        password: ($card.find('.js-pass').val()||'random').trim()
                    },
                    method: 'WALLET'
                });

                $modal.find('.js-grand').text(formatVND(totalAmount));
                new bootstrap.Modal($modal[0]).show();
            });

            $(document).on('click', '#psCheckoutModal .js-confirm', function(){
                const $modal = $('#psCheckoutModal');
                const ctx = $modal.data('ctx');

                if (!ctx || !ctx.payload) return;

                const payload = {
                    ...ctx.payload,
                    payment_method: ctx.method
                };

                const $btn = $(this);
                $btn.prop('disabled', true).text('Đang xử lý...');

                $.ajax({
                    url: '{{ route('proxyhome.submitProxyDatacenterOrder') }}',
                    method: 'POST',
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    headers: { 'X-CSRF-TOKEN': csrf() }
                })
                    .done(function(res){
                        if(res.status) {
                            toastr.success('Tạo đơn thành công!');
                            window.location.href = '{{ route('proxyhome.proxyDatacenterList') }}';
                        } else {
                            alert(res.message);
                        }
                    })
                    .fail(function(xhr){
                        alert(xhr.responseJSON?.message || 'Có lỗi xảy ra.');
                    })
                    .always(function(){
                        $btn.prop('disabled', false).text('Thanh toán');
                    });
            });
        })(jQuery);
    </script>
@stop
