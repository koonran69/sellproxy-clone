@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@section('content')

{{--    @include('public.layouts.partials.header')--}}
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="position-relative bg-light shadow w-100 p-4 pb-5 rounded rounded-end-0">
                        <div class="border-bottom pb-3">
                            <img alt="trade proxy" loading="lazy" width="100" height="35" decoding="async" src="{{ asset("public/assets/images/logo.svg") }}" class="img-fluid">
                        </div>

                        <div class="pt-4 pb-3 border-bottom d-flex flex-column gap-1">
                            <span class="text-secondary fw-normal">@lang('Ngân hàng')</span>
                            <span class="text-dark fw-bold">{{ $qrCode['bankName'] }}</span>
                        </div>

                        <div class="py-3 border-bottom d-flex flex-column gap-1">
                            <span class="text-secondary fw-normal">@lang('Số tài khoản')</span>
                            <div class="d-flex gap-2">
                                <p class="text-dark fw-bold mb-0">{{ $qrCode['bankAccount'] }}</p>
                            </div>
                        </div>

                        <div class="py-3 border-bottom d-flex flex-column gap-1">
                            <span class="text-secondary fw-normal">@lang('Chủ tài khoản')</span>
                            <span class="text-dark fw-bold">{{ $qrCode['userBankName'] }}</span>
                        </div>

                        <div class="py-3 border-bottom d-flex flex-column gap-1">
                            <span class="text-secondary fw-normal">@lang('Số tiền thanh toán')</span>
                            <span class="text-dark fw-bold">{{ number_format($qrCode['amount']) }}</span>
                        </div>

                        <div class="py-3 border-bottom d-flex flex-column gap-1">
                            <span class="text-secondary fw-normal">@lang('Nội dung chuyển khoản')</span>
                            <div class="d-flex gap-2">
                                <span class="text-dark fw-bold">{{ $qrCode['content'] }}</span>
                            </div>
                        </div>

                        <div class="py-3 d-flex flex-column gap-1">
                            <span class="text-secondary fw-normal">@lang('Trạng thái')</span>
                            <div id="status_payment">
                                @if($transaction->status == \App\Core\Enums\Transaction\TransactionStatus::PendingPayment)
                                    <div class="d-flex gap-2">
                                        <span class="fw-bold text-danger">@lang('Chưa thanh toán')</span>
                                    </div>
                                @elseif($transaction->status == \App\Core\Enums\Transaction\TransactionStatus::Paid)
                                    <div class="d-flex gap-2">
                                        <span class="fw-bold text-success">@lang('Đã thanh toán')</span>
                                    </div>
                                @elseif($transaction->status == \App\Core\Enums\Transaction\TransactionStatus::Canceled)
                                    <div class="d-flex gap-2">
                                        <span class="fw-bold text-danger">@lang('Đã hủy')</span>
                                    </div>
                                @elseif($transaction->status == \App\Core\Enums\Transaction\TransactionStatus::Complete)
                                    <div class="d-flex gap-2">
                                        <span class="fw-bold text-success">@lang('Hoàn thành')</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="position-relative w-100 text-center px-4 bg-white pt-5 rounded rounded-start-0">
{{--                        <div class="text-secondary text-muted fs-4 fw-normal position-absolute top-0 end-0 m-3">--}}
{{--                            @lang('Liên hệ hỗ trợ'): 0708762402--}}
{{--                        </div>--}}

                        @if($transaction->status == \App\Core\Enums\Transaction\TransactionStatus::PendingPayment)
                            <h1 class="fs-4 text-dark fw-bold">@lang('QUÉT MÃ QR ĐỂ THANH TOÁN')</h1>
                            <p class="mb-2 text-dark fs-5 fw-normal">
                                @lang('Sử dụng ứng dụng Internet Banking hoặc ứng dụng camera hỗ trợ QR code để quét mã')
                            </p>
                        <div class="w-100 position-relative mx-auto" style="height: 378px;">
                            <div id="qrcode"></div>
                        </div>
                            <div class="d-flex mt-4 justify-content-center gap-3 align-items-center">
                                <img alt="napas" loading="lazy" width="111" height="32" decoding="async" src="{{ asset("public/assets/images/napas.png") }}">
                                <div class="bg-secondary" style="width: 2px; height: 20px;"></div>
                                <img alt="BIDV" loading="lazy" width="111" height="32" decoding="async" src="{{ asset("public/assets/images/BIDV.png") }}">
                            </div>
                            <div class="countdown mt-3 text-success">
                                <span id="minutes" data-minutes="00">00</span>:<span id="seconds" data-seconds="00">00</span>
                            </div>
                        @elseif($transaction->status == \App\Core\Enums\Transaction\TransactionStatus::Paid
                        || $transaction->status == \App\Core\Enums\Transaction\TransactionStatus::Complete)
                            <div class="w-100 position-relative mx-auto" style="height: 378px;">
                                <h2 class="fw-bold text-success">Thanh toán thành công!</h2>
                                <p>Cảm ơn bạn đã đặt hàng tại <strong>{{ env('APP_NAME') }}</strong>.</p>
                                <p>Vui lòng kiểm tra email của bạn để xem chi tiết đơn hàng.</p>
                                <p>(Nếu không thấy vui lòng check mục Spam (thư rác))</p>
                                <a href="{{ route('home') }}" class="btn btn-sm btn-primary"><i class="ti ti-arrow-narrow-left"></i><span>@lang('Trang chủ')</span></a>
                            </div>
                        @endif

                    </div>
{{--                    <div class="row mt-4">--}}
{{--                        <div class="col-md-12">--}}
{{--                            <div class="text-center">--}}
{{--                                <a href="{{ route('home') }}" class="btn btn-sm btn-primary"><i class="ti--}}
{{--                                ti-arrow-narrow-left"></i>--}}
{{--                                    <span>@lang('Xác nhận thanh toán')</span></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "{{ $qrCode['qrCode']  }}",
            width: 378,
            height: 378,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
    <script>
        function startCountdown(remainingSeconds) {
            const minutesElement = document.getElementById("minutes");
            const secondsElement = document.getElementById("seconds");

            function updateDisplay() {
                let minutes = Math.floor(remainingSeconds / 60);
                let seconds = remainingSeconds % 60;

                minutesElement.textContent = minutes;
                secondsElement.textContent = seconds < 10 ? '0' + seconds : seconds;

                if (remainingSeconds <= 0) {
                    clearInterval(timer);
                    minutesElement.textContent = "0";
                    secondsElement.textContent = "00";
                } else {
                    remainingSeconds--;
                }
            }

            updateDisplay();
            const timer = setInterval(updateDisplay, 1000);
        }

        const remainingSeconds = {{ $remaining_seconds }};
        startCountdown(remainingSeconds);

        let checkInterval = setInterval(() => {
            let code = '{{ $transaction->code }}';
            fetch('{{ route('transaction.checkStatusPayment') }}' + "?code=" + code)
                .then(response => response.json())
                .then(data => {
                    if(data.success && data.status == 20 ) {
                        clearInterval(checkInterval);
                        $("#status_payment").html(`<div class="d-flex gap-2">
                                    <span class="fw-bold text-success">Đã thanh toán</span>
                                </div>`);
                        window.location.reload();
                    }
                })
                .catch(error => console.error("Lỗi khi gọi API:", error));
        }, 5000);
    </script>
@endpush
