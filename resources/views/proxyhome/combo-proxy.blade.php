@extends("proxyhome.layout")

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h3 class="page-title mb-4">COMBO PROXY</h3>

            <!-- Tab Navigation -->
            <ul class="nav nav-pills justify-content-center mb-4 bg-white p-3 mx-auto" id="comboTabs" style="border: 1px solid #e9e9ef; border-radius: 15px; font-weight: bold">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab1">Combo Proxy Tĩnh</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab2">Combo Proxy Datacenter VN</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab3">Combo Proxy Datacenter US</button></li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab1">
                    <div class="row g-4 justify-content-center">
                        {{-- Lặp qua các gói Proxy Tĩnh --}}
                        @foreach($comboTinh as $item)
                            @include('proxyhome.component.combo-card', ['item' => $item])
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="tab2">
                    {{-- Lặp qua các gói Proxy datacenter VN --}}
                    <div class="row g-4 justify-content-center">
                        @foreach($comboVN as $item)
                            @include('proxyhome.component.combo-card', ['item' => $item])
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="tab3">
                    {{-- Lặp qua các gói Proxy datacenter US --}}
                    <div class="row g-4 justify-content-center">
                        @foreach($comboUS as $item)
                            @include('proxyhome.component.combo-card', ['item' => $item])
                        @endforeach
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
    <script>
        (function($){
            const csrf = () => $('meta[name="csrf-token"]').attr('content');

            function formatVND(n){ return (Number(n)||0).toLocaleString('vi-VN') + 'đ'; }

            function recalc($card) {
                let rawRules = $card.attr('data-rules');
                let basePrice = parseInt($card.data('price'), 10) || 0;

                let unit = parseInt($card.find('.js-unit').val()) || 1;
                let qty  = parseInt($card.find('.js-qty').val()) || 1;

                let discountPercent = 0;

                if (rawRules) {
                    try {
                        let rules = JSON.parse(rawRules);
                        if (rules.min_unit) {
                            if (unit >= rules.min_unit) discountPercent = rules.percent;
                        } else if (rules.tiers) {
                            rules.tiers.forEach(tier => {
                                if (unit >= tier[0]) discountPercent = tier[1];
                            });
                        }
                    } catch (e) {
                        console.error("Invalid discount rules JSON");
                    }
                }

                let subTotal = basePrice * unit * qty;
                let total = subTotal * (1 - discountPercent / 100);
                let roundedTotal = Math.round(total);

                // Cập nhật giao diện tiền
                $card.find('.js-total').text(formatVND(roundedTotal));

                // Cập nhật badge % giảm giá
                let $badge = $card.find('.js-discount-badge');
                if (discountPercent > 0) {
                    $badge.text('-' + discountPercent + '%').show();
                } else {
                    $badge.hide();
                }

                return roundedTotal;
            }

            // Sự kiện thay đổi số lượng hoặc unit
            $(document).on('input change', '.js-unit, .js-qty', function() {
                recalc($(this).closest('.combo-card'));
            });

            $(document).on('click', '.js-plus, .js-minus', function(e) {
                e.preventDefault();
                let $input = $(this).siblings('input');
                let val = parseInt($input.val()) || 1;

                if($(this).hasClass('js-plus')) {
                    $input.val(val + 1);
                } else if(val > 1) {
                    $input.val(val - 1);
                }

                $input.trigger('change');
            });

            $(document).on('click', '.prx-buy', function(){
                const $card = $(this).closest('.combo-card');
                const $modal = $('#psCheckoutModal');
                const totalAmount = recalc($card);

                $modal.data('ctx', {
                    payload: {
                        id: $(this).data('id'),
                        unit: $card.find('.js-unit').val(),
                        type_unit: $card.data('type-unit'),
                        quantity: $card.find('.js-qty').val(),
                        protocol: $card.find('.js-protocol').val(),
                        provider: $card.data('provider'),
                        user: ($card.find('.js-user').val()||'random').trim(),
                        password: ($card.find('.js-pass').val()||'random').trim()
                    },
                    method: 'WALLET'
                });

                $modal.find('.js-grand').text(formatVND(totalAmount));
                new bootstrap.Modal($modal[0]).show();
            });

            // Xác nhận thanh toán qua Ajax
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
                    url: '{{ route('proxyhome.submitComboOrder') }}', // Đảm bảo route này trùng với route xử lý ở backend của bạn
                    method: 'POST',
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    headers: { 'X-CSRF-TOKEN': csrf() }
                })
                    .done(function(res){
                        if(res.status) {
                            toastr.success('Tạo đơn hàng combo thành công!');
                            window.location.href = res.redirect_url || '{{ route('proxyhome.comboProxyList') }}';
                        } else {
                            toastr.error(res.message || 'Thất bại');
                        }
                    })
                    .fail(function(xhr){
                        toastr.error(xhr.responseJSON?.message || 'Có lỗi xảy ra.');
                    })
                    .always(function(){
                        $btn.prop('disabled', false).text('Thanh toán');
                        bootstrap.Modal.getInstance($modal[0])?.hide();
                    });
            });
        })(jQuery);
    </script>
@stop
