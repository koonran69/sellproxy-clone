@extends("proxyhome.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3 class="page-title">KEY XOAY</h3>
            <div class="proxy-rotate">
                <div class="row g-3">
                    @foreach($keys as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="prx-card" data-price="{{ $item['price'] }}" data-old-price="{{ $item['old_price'] }}" data-type-unit="{{ $item['unit'] }}">
                                <div class="prx-card__head text-center">
                                    <h6 class="mb-3 fw-bold">{{ $item['title'] }}</h6>
                                </div>

                                <ul class="prx-features list-unstyled mb-3">
                                    <li><span class="i ok"></span> <b>Kiểu mạng:</b> Cáp quang</li>
                                    <li><span class="i ok"></span> IPv4 dân cư-Unlimited Bandwidth</li>
                                    <li><span class="i ok"></span> <b>Nhà mạng:</b>
                                        <span class="prx-logos">
                                            <img src="{{asset('public/proxyhome/assets/images/viettel.png') }}" alt="Viettel">
                                            <img src="{{asset('public/proxyhome/assets/images/fpt.png') }}" alt="FPT">
                                            <img src="{{asset('public/proxyhome/assets/images/vnpt.png') }}" alt="VNPT">
                                        </span>
                                    </li>
                                    <li><span class="i ok"></span> Thời gian đổi IP tối thiểu 60 giây / lần</li>
                                    <li><span class="i ok"></span> Giữ IP tối đa 30 phút</li>
                                    <li><span class="i ok"></span> <b>Vị trí:</b> Ngẫu nhiên</li>
                                </ul>

                                <div class="prx-form">
                                    <div class="mb-2">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="i ok me-2"></span>
                                            <label class="form-label mb-0 text-nowrap">{{ $item['label'] }}</label>
                                        </div>
                                        <input type="number" min="1" value="1" class="form-control js-unit w-100">
                                    </div>

                                    <div class="mb-2">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="i ok me-2"></span>
                                            <label class="form-label mb-0 text-nowrap">Số lượng</label>
                                        </div>
                                        <input type="number" min="1" value="1" class="form-control js-qty w-100">
                                    </div>

                                    <hr class="my-3">

                                    <div class="d-flex justify-content-between align-items-center my-3">
                                        <span class="text-muted">Thành tiền:</span>
                                        <div>
                                            <span class="fw-bold text-danger js-total" style="font-size: 1.4rem;">{{ number_format($item['price']) }}đ</span>
                                            <small class="text-decoration-line-through text-muted js-old-total" style="font-size: 1.1rem;">{{ number_format($item['old_price']) }}đ</small>
                                        </div>
                                    </div>

                                    @if (auth()->check())
                                        <button class="btn btn-danger w-100 prx-buy">Mua hàng</button>
                                    @else
                                        <a href="{{route('auth.login')}}" class="btn btn-primary w-100">Đăng nhập</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    <script>
        (function($){
            const csrf = () => $('meta[name="csrf-token"]').attr('content');

            function formatVND(n){ return (Number(n)||0).toLocaleString('vi-VN') + 'đ'; }

            function recalc($card){
                const base = parseInt($card.data('price'), 10);
                const oldBase = parseInt($card.data('old-price'), 10); // Lấy giá cũ gốc

                const unit = parseInt($card.find('.js-unit').val()) || 1;
                const qty  = parseInt($card.find('.js-qty').val()) || 1;

                // Tính tổng
                const total = base * unit * qty;
                const oldTotal = oldBase * unit * qty;

                // Cập nhật giao diện
                $card.find('.js-total').text(formatVND(total));
                $card.find('.js-old-total').text(formatVND(oldTotal));
                return total;
            }

            $(document).on('input change', '.js-unit, .js-qty', function(){
                recalc($(this).closest('.prx-card'));
            });


            $(document).on('click', '.prx-buy', function(){
                const $card = $(this).closest('.prx-card');
                const $modal = $('#psCheckoutModal');
                const totalAmount = recalc($card);

                $modal.data('ctx', {
                    payload: {
                        unit: $card.find('.js-unit').val(),
                        quantity: $card.find('.js-qty').val(),
                        typeUnit: $card.data('type-unit'),
                        user: 'random',
                        password: 'random'
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
                    url: '{{ route('proxyhome.submitKeyRotateOrder') }}',
                    method: 'POST',
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    headers: { 'X-CSRF-TOKEN': csrf() }
                })
                    .done(function(res){
                        if(res.status) {
                            toastr.success('Tạo đơn thành công!');
                            window.location.href = '{{ route('proxyhome.keyRotateList') }}';
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
