<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Chọn hình thức thanh toán</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body p-0 position-relative overflow-hidden">
                <div class="page-container">
                    <div class="page-modal active-page" id="page1">
                        <div class="d-flex justify-content-md-center justify-content-around gap-md-6 gap-2"
                            id="group-payment-method">
                            <button value="wallet" class="btn flex-column btn-payment-method" id="btn-wallet-payment"
                                data-available-balance="{{ $available_balance }}"
                                data-current-total="{{ $sub_total }}">
                                <img src="{{ asset('public/assets/images/wallet-bold.svg') }}">
                                <span>Ví của tôi</span>
                                <span>{{ number_format($available_balance) }} đ</span>
                            </button>
                            <button value="banking" class="btn flex-column btn-payment-method">
                                <img src="{{ asset('public/assets/images/credit-card.svg') }}"> Ngân hàng
                            </button>
                            {{-- 
                            <button id="btnCrypto" value="coin" class="btn flex-column btn-payment-method">
                                <img src="{{ asset('public/assets/images/tether.png') }}"> Tiền điện tử
                            </button> 
                            --}}
                            <button id="btnHeleket" value="heleket" class="btn flex-column btn-payment-method">
                                <img src="{{ asset('public/assets/images/tether.png') }}"> Tiền điện tử
                            </button>
                        </div>
                        <div class="d-flex justify-content-center gap-2 mt-4" id="wallet-warning"
                            style="display: none !important;">
                            <div class="my-auto">
                                <img width="16" height="16"
                                    src="{{ asset('public/assets/images/warning.png') }}">
                            </div>
                            <span class="text-warning">Số dư ví không đủ.</span>
                        </div>
                    </div>
                    <div class="page-modal" id="page2">
                        <div class="mb-3">
                            <label for="cryptoSelect" class="form-label">Chọn loại tiền điện tử</label>
                            <select class="form-select" id="cryptoSelect" style="width: 100%;">
                                <option value="" disabled selected>Chọn loại tiền điện tử</option>
                                @foreach ($coins as $coin)
                                    <option value="{{ $coin->code }}" data-image="{{ asset($coin->icon) }}">
                                        {{ $coin->coin_name }} ({{ $coin->code }})</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn một đồng tiền.</div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-link mt-2" id="btnBack">← Quay lại</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="d-flex gap-2">
                    <img src="{{ asset('public/assets/images/icon-wrapper.png') }}" alt="">
                    <a href="{{ route('account.wallet') }}">Nạp tiền vào ví</a>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-modal-footer" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-secondary btn-modal-footer btn-next-payment" disabled>Tiếp
                        tục</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modalAjaxConfirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">@lang('Xác nhận thanh toán')</div>
                <div>@lang('Bạn có chắc chắn muốn thanh toán bằng ví tiền không?')</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                    data-bs-dismiss="modal">@lang('Hủy')</button>
                <x-core-form class="ajax-modal-form" action="#" type="put">
                    <button id="btn-confirm-payment-wallet" type="button" class="btn btn-primary">@lang('Thanh toán')
                    </button>
                </x-core-form>
            </div>
        </div>
    </div>
</div>
