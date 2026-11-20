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
                    <div class="row justify-content-between align-items-center mb-4">
        
                        <!-- Action -->
                        <div class="col-md-3 d-flex gap-3 mt-2 flex-column">
                            <div class="fw-bold text-dark">
                                <i class="bi bi-play-fill"></i> Action
                            </div>
                            <div class="d-flex">
                                <select class="form-select" style="width: auto;">
                                    <option>Gia hạn</option>
                                </select>
                                <button class="btn btn-primary ms-2" id="btn-run-renew">Run</button>
                            </div>
                        </div>
    
                        <div class="col-md-3 d-flex gap-3 mt-2 flex-column">
                            <div class="fw-bold text-dark">
                                Sắp xếp
                            </div>
                            <div class="d-flex">
                                <select id="orderBy" name="order_by" class="form-select" style="width: auto;">
                                    @php $curr = request('order_by', 'date-buy-desc'); @endphp
                                    <option value="date-buy-desc"     {{ $curr==='date-buy-desc' ? 'selected' : '' }}>Ngày mua</option>
                                    <option value="date-buy-asc"      {{ $curr==='date-buy-asc' ? 'selected' : '' }}>Ngày mua (đi xuống)</option>
                                    <option value="date-expired-desc" {{ $curr==='date-expired-desc' ? 'selected' : '' }}>Ngày hết hạn</option>
                                    <option value="date-expired-asc"  {{ $curr==='date-expired-asc' ? 'selected' : '' }}>Ngày hết hạn (đi xuống)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex gap-3 mt-2 flex-column">
                            <div class="fw-bold text-dark">
                                Hiển thị
                            </div>
                            <div class="d-flex">
                                @php $currLimit = (int) request('limit', 50); @endphp
                                <select name="limit" id="limitSelect" class="form-select" style="width:auto;">
                                    <option value="50"  {{ $currLimit===50  ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $currLimit===100 ? 'selected' : '' }}>100</option>
                                    <option value="200" {{ $currLimit===200 ? 'selected' : '' }}>200</option>
                                </select>
                            </div>
                        </div>
                        <!-- Get Proxies -->
                        <div class="col-md-3 d-flex justify-content-end gap-2 mt-2 flex-column">
                            <div class="fw-bold text-dark">
                                <i class="bi bi-download"></i> Get proxies
                            </div>
                            <div class="btn-group" role="group">
                                <button class="btn btn-success" id="exportHttp">HTTP</button>
                                <button class="btn btn-danger" id="exportSock5">SOCKS</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <form action="{{ route('proxyline.renewOrder') }}" method="GET" id="frmReNew">
                    <table class="table align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>@lang('Proxy Id')</th>
                            <th>@lang('Proxy')</th>
                            <th>@lang('Ghi chú')</th>
                            <th>@lang('Loại')</th>
                            <th class="text-center">@lang('Quốc gia')</th>
                            <th class="text-center">@lang('Ngày hết hạn')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($proxies as $proxy)
                            <tr>
                                <td><input data-ip="{{ $proxy->ip }}" data-httpport="{{ $proxy->port_http }}" data-sock5port="{{ $proxy->port_socks5 }}" data-user="{{ $proxy->username }}" data-pass="{{ $proxy->password }}" class="check-item" type="checkbox" name="proxies[]" value="{{ $proxy->id }}"></td>
                                <td>
                                    <span>{{ $proxy->proxyline_id }}</span>
                                    <br>
                                    <span>({{ $proxy->order_id }})</span>
                                </td>
                                <td class="proxy-table-proxy">
                                    <span>{{ $proxy->ip }}</span>
                                    <br>
                                    <small>Username: <b>{{ $proxy->username }}</b> Password: <b>{{ $proxy->password }}</b></small>
                                    <br>
                                    <small>HTTP/SOCKS Port: <span>{{ $proxy->port_http }}</span>/<span>{{ $proxy->port_socks5 }}</span></small>
                                </td>
                                <td>
                                    <span data-comment="" class="proxy-comment" contenteditable="false">{{ !empty($proxy->comment) ? $proxy->comment : "##" }}</span>
                                    <i title="Edit comment" class="ti ti-pencil text-primary cursor-pointer" data-edit-comment="" ></i>
                                    <i
                                            class="ti ti-device-floppy text-danger cursor-pointer"
                                            data-save-comment="" style="display: none;"
                                            data-id="{{ $proxy->id }}"
                                            data-url="{{ route('account.proxyLineList.updateComment', $proxy->id) }}"
                                    >
                                    </i>
                                </td>
                                <td>{{ $order->proxyType->name  }}</td>
                                <td class="text-center"><img src="{{ asset($order->country->feature_image) }}" alt=""> <br>{{ $order->country->name }}</td>
                                <td class="text-center">
                                    <span>{{ $proxy->date_end }}</span>
                                    <br>
                                    <span>({{ $proxy->remaining_days }} ngày)</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        </form>
                    </div>
                    <div class="row mt-2 paginate-custom">
                        {{ $proxies->links('public.pagination') }}
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
        // $('#frmUpdateProfile').validate({
        //     ignore: ".ignore",
        //     rules: {
        //         name: "required",
        //         email: "required",
        //     },
        //     messages: {
        //         email: "Email là bắt buộc",
        //         name: "Họ và tên là bắt buộc",
        //     },
        //     submitHandler: function (form) {
        //         $(form).submit();
        //     }
        // });
    </script>
    <script>
        document.querySelectorAll('.btn-copy').forEach(btn => {
            btn.addEventListener('click', function () {
                const textToCopy = this.getAttribute('data-key');

                // Sao chép vào clipboard
                navigator.clipboard.writeText(textToCopy).then(() => {
                    this.innerText = "Đã copy!";
                    setTimeout(() => this.innerText = "Copy", 1500);
                }).catch(err => {
                    console.error('Lỗi khi copy: ', err);
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#checkAll').on('change', function () {
                $('.check-item').prop('checked', $(this).is(':checked'));
            });
            
            $('.check-item').on('change', function () {
                const allChecked = $('.check-item').length === $('.check-item:checked').length;
                $('#checkAll').prop('checked', allChecked);
            });
        });
        
        $("#btn-run-renew").on("click", function () {
            if ($('.check-item:checked').length === 0) {
                alert('Vui lòng chọn ít nhất một proxy để gia hạn!');
            } else {
                $("#frmReNew").submit();
            }
        });
        
        $("#exportHttp").on("click", function() {
            if ($('.check-item:checked').length === 0) {
                alert('Vui lòng chọn ít nhất một proxy !');
                return;
            }
            const lines = $('.check-item:checked').map(function () {
                const ip = $(this).data('ip');
                const port = $(this).data('httpport');
                const user = $(this).data('user');
                const pass = $(this).data('pass');
                return `${ip}:${port}:${user}:${pass}`;
            }).get();

            const content = lines.join('\n');
            const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });

            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'proxies.txt';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        $("#exportSock5").on("click", function() {
            if ($('.check-item:checked').length === 0) {
                alert('Vui lòng chọn ít nhất một proxy !');
                return;
            }
            const lines = $('.check-item:checked').map(function () {
                const ip = $(this).data('ip');
                const port = $(this).data('sock5port');
                const user = $(this).data('user');
                const pass = $(this).data('pass');
                return `${ip}:${port}:${user}:${pass}`;
            }).get();

            const content = lines.join('\n');
            const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });

            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'proxies.txt';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).ready(function() {
            $(document).on('click', '[data-edit-comment]', function() {
                var $td = $(this).closest('td');
                var $span = $td.find('.proxy-comment');

                $span.attr('contenteditable', 'true').focus();
                $(this).hide();
                $td.find('[data-save-comment]').show();
            });

            $(document).on('click', '[data-save-comment]', function () {
                var $btn = $(this);
                var $td = $btn.closest('td');
                var $span = $td.find('.proxy-comment');

                // Lấy dữ liệu
                var comment = $span.text().trim();
                var url = $btn.data('url');
                var id = $btn.data('id');

                if (!url || !id) {
                    alert('Thiếu URL hoặc ID để lưu comment.');
                    return;
                }
                
                if ($btn.data('loading')) return;
                
                $btn.data('loading', true);
                var originalClass = $btn.attr('class');
                $btn.removeClass().addClass('ti ti-loader spinner-border-sm').css('opacity', .7);
                
                $span.attr('contenteditable', 'false');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        comment: comment,
                    }
                })
                    .done(function (res) {
                        if (res && res.status === 'ok') {
                            if (typeof res.comment === 'string') {
                                $span.text(res.comment);
                            }
                            msgSuccess(res.message);
                        } else {
                            alert((res && res.message) || 'Không thể lưu ghi chú.');
                            $span.attr('contenteditable', 'true').focus();
                        }
                    })
                    .fail(function (xhr) {
                        let msg = 'Lỗi mạng hoặc máy chủ.';
                        if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        alert(msg);
                        $span.attr('contenteditable', 'true').focus();
                    })
                    .always(function () {
                        $btn.data('loading', false);
                        $btn.attr('class', originalClass).css('opacity', 1);
                        $td.find('[data-edit-comment]').show();
                    });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var select = document.getElementById('orderBy');
            if (!select) return;

            select.addEventListener('change', function () {
                const params = new URLSearchParams(window.location.search);
                params.set('order_by', this.value);
                window.location.search = params.toString();
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            var limitSel = document.getElementById('limitSelect');
            if (!limitSel) return;

            limitSel.addEventListener('change', function () {
                const params = new URLSearchParams(window.location.search);
                params.set('limit', this.value);
                params.delete('page');
                window.location.search = params.toString();
            });
        });
    </script>
@endpush
