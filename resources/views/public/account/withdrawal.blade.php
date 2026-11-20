@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@section('content')

    <div class="main-content">
        <section class="container px-md-5 px-3 pb-5">
            <div class="row g-4">
                <div class="col-md-3 col-12 d-md-block">
                    @include("public.account.left-sidebar")
                </div>
                <div class="col-md-9 col-12 d-md-block">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <div>
                                    <h5 class="card-title mb-1 fw-bold account-main-title">@lang('Ví tiền')</h5>
                                    <p class="text-muted mb-0 account-sub-title">@lang('Nạp tiền vào ví để thanh toán bất cứ lúc
                                    nào!')</p>
                                </div>
                                <div class="bg-atm p-4 mt-4 rounded-4">
                                    <div class="ballance d-flex justify-content-between align-items-center">
                                        <div class="group-money-left">
                                            <div class="atm-title text-white">Số tiền hiện có</div>
                                            <div class="atm-balance text-white fw-bold">{{ number_format($user->balance ?? 0) }}</div>
                                        </div>
                                        <div class="img-atm">
                                            <img width="46" height="14" src="{{ asset("public/assets/images/ATM.png") }}">
                                        </div>
                                    </div>
                                    <div class="box-available-balance">
                                        <p class="text-availabel atm-title">Số dư khả dụng</p>
                                        <p class="money-availabel atm-balance fw-bold">{{ number_format($user->available_balance ?? 0) }} VNĐ</p>
                                    </div>
                                    <div class="atm-note text-white">*Bạn có thể nạp thêm để sở hữu dịch vụ của chúng tôi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm mt-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('public/assets/images/piggy-bank.png') }}" alt="Ví tiền" width="50" class="me-3">
                                <div>
                                    <h5 class="card-title mb-1 fw-bold account-main-title">Yêu cầu rút tiền</h5>
                                </div>
                            </div>
                            @if ($errors->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                {{ $errors->first('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            <form id="frmAmount" class="mt-3" method="POST" action="{{ route('account.postWithdrawal') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Nhập số tiền bạn cần rút: <span class="error">Tối thiểu 10,000đ</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">VND</span>
                                        <input type="text" class="form-control" id="amount" name="amount" placeholder="100,000">
                                    </div>
                                    <label id="amount-error" class="error" for="amount"></label>
                                </div>
                                <div class="mb-3">
                                    <label for="method" class="form-label">Phương thức: <span class="text-danger">*</span></label>
                                    <select name="method" class="form-control">
                                        <option value="bank" selected>Chuyển khoản</option>
                                    </select>
                                    <label id="method-error" class="error" for="method"></label>
                                </div>
                                <div class="account-field">
                                    <div class="form-group">
                                        <label for="account_name" class="form-label">Tên chủ tài khoản <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Nguyen Van A">
                                        <label id="account_name-error" class="error" for="account_name"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="account_number" class="form-label">Số tài khoản <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="account_number" name="account_number" placeholder="">
                                        <label id="account_number-error" class="error" for="account_number"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_name" class="form-label">Ngân hàng <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="">
                                        <label id="bank_name-error" class="error" for="bank_name"></label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Rút</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection

@push('js')
    @include('public.scripts.swiper')
    <script src="{{ asset("public/assets/js/jquery.validate.min.js") }}"></script>
    <script>
        $('#frmAmount').validate({
            ignore: ".ignore",
            rules: {
                amount: {
                    required: true,
                    number: true,
                    min: 10000,
                    normalizer: function(value) {
                        return value.replace(/,/g, '');
                    }
                },
                method: {
                    required: true
                },
                account_name: {
                    required: true,
                    minlength: 3
                },
                account_number: {
                    required: true,
                    minlength: 5
                },
                bank_name: {
                    required: function (element) {
                        return $('#method').val() === 'bank';
                    }
                }
            },
            messages: {
                amount: {
                    required: "Vui lòng nhập số tiền muốn rút",
                    number: "Phải là số",
                    min: "Tối thiểu là 10,000đ"
                },
                method: {
                    required: "Vui lòng chọn phương thức rút"
                },
                account_name: {
                    required: "Vui lòng nhập tên tài khoản",
                    minlength: "Tối thiểu 3 ký tự"
                },
                account_number: {
                    required: "Vui lòng nhập số tài khoản hoặc SĐT",
                    minlength: "Tối thiểu 5 ký tự"
                },
                bank_name: {
                    required: "Vui lòng nhập tên ngân hàng"
                }
            },
            submitHandler: function (form) {
                let rawValue = $('#amount').val().replace(/,/g, '');
                $('#amount').val(rawValue);
                form.submit();
            }
        });

        $(document).ready(function() {
            $('#amount').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g, ','));
            });
        });
    </script>
@endpush
