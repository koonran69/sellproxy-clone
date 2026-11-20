<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Thanh toán</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body p-0 position-relative overflow-hidden">
                <div class="page-container">
                    <div class="page-modal active-page" id="page1">
                        <div class="d-flex justify-content-md-center justify-content-around gap-md-6 gap-2" id="group-payment-method">
                            <button value="wallet" class="btn flex-column btn-payment-method active">
                                <img src="{{ asset("public/assets/images/wallet-bold.svg") }}">
                                <span>Ví của tôi</span>
                                <span>{{ number_format($available_balance) }} đ</span>
                            </button>
                        </div>
{{--                        @if($available_balance < $sub_total)--}}
{{--                            <div class="d-flex justify-content-center gap-2 mt-4">--}}
{{--                                <div class="my-auto">--}}
{{--                                    <img width="16" height="16"   src="{{ asset("public/assets/images/warning.png") }}">--}}
{{--                                </div>--}}
{{--                                <span class="text-warning">Số dư ví không đủ.</span>--}}
{{--                            </div>--}}
{{--                        @endif--}}
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="d-flex gap-2">
                    <img src="{{ asset("public/assets/images/icon-wrapper.png") }}" alt="">
                    <a href="{{ route('account.wallet') }}">Nạp tiền vào ví</a>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-modal-footer" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-secondary btn-modal-footer btn-next-payment">Tiếp tục</button>
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
