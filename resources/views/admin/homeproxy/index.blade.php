@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span
                                        class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path
                                                d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2">
                                            </path>
                                            <path d="M12 3v3m0 12v3"></path>
                                        </svg></span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">{{ format_price($merchant->coin) }} Còn lại</div>
                                    <div class="text-secondary">{{ format_price($merchant->totalDeposited) }} Tổng đã nạp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">@lang('list')</h2>
                    <button type="button" data-route="{{ route('admin.homeproxy.charge') }}"
                        class="btn btn-primary open-modal-form">
                        <i class="ti ti-plus icon"></i>
                        <span>@lang('Nạp tiền')</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive position-relative">
                        @include('admin.datatables.toggle-column-datatable')
                        {{ $dataTable->table(['class' => 'table table-bordered'], true) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('js')
    {{ $dataTable->scripts() }}

    @include('admin.scripts.datatable-toggle-columns', [
        'id_table' => $dataTable->getTableAttribute('id'),
    ])
    <script>
        $(document).on('submit', '#formCharge', function(e) {
            e.preventDefault();
            AjaxLibrary.post(
                $(this).attr('action'),
                $(this).serialize(),
                function(res) {
                    if (res.status) {
                        $("#modalChargeContent").html(res.html);
                    } else {
                        msgError(res.msg);
                    }
                }
            )
        })

        $(document).on('click', '.generate-token-btn', function() {
            let $btn = $(this);
            let proxyId = $btn.data('id');
            let $container = $btn.closest('.d-flex');
            let $input = $container.find('.js-token-input');
            let $copyBtn = $container.find('.copy-text');

            if (!proxyId) {
                toastr.error('Không tìm thấy mã định danh proxy.');
                return;
            }

            $btn.prop('disabled', true).find('i').addClass('fa-spin ti-spin');

            $.ajax({
                url: "{{ route('admin.homeproxy.generate_token', ['id' => ':id']) }}".replace(':id', proxyId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status && res.token) {
                        $input.val(res.token);
                        $copyBtn.attr('data-text', res.token).prop('disabled', false);
                        toastr.success(res.message || 'Làm mới token thành công!');
                    } else {
                        toastr.error(res.message || 'Có lỗi xảy ra.');
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Không thể kết nối đến máy chủ.');
                },
                complete: function() {
                    $btn.prop('disabled', false).find('i').removeClass('fa-spin ti-spin');
                }
            });
        });

        $(document).on('click', '.craw-proxy-btn', function() {
            let $btn = $(this);
            let requestUrl = $btn.data('url');

            $btn.prop('disabled', true).find('i').addClass('fa-spin ti-spin');

            $.ajax({
                url: requestUrl,
                method: 'GET',
                success: function(res) {
                    if (res.success || res.status) {
                        toastr.success(res.message);
                    } else {
                        toastr.error(res.message || 'Có lỗi xảy ra.');
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Không thể kết nối đến máy chủ.');
                },
                complete: function() {
                    $btn.prop('disabled', false).find('i').removeClass('fa-spin ti-spin');
                }
            });
        });
    </script>
@endpush
