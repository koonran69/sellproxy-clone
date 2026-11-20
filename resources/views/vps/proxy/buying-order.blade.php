@extends("vps.layout")
@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3 class="page-title">Proxy</h3>
            <div class="proxy-static-list proxy-static buying-order">
                <form id="form-proxy-buy" class="order-vps-form mt-2">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="quantity">Số lượng</label>
                                <input type="number" name="quantity" placeholder="Số lượng" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-check">
                                    <input class="form-check-input" name="status_random_username"
                                           type="checkbox" checked>
                                    <span class="form-check-label">Tên đăng nhập ngẫu nhiên</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" name="username" placeholder="Nhập tên đăng nhập"
                                           class="form-control d-none mt-2" autocomplete="off" style="z-index: 1">
                                </div>
                                <div class="invalid-feedback-username"></div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-check">
                                    <input class="form-check-input" name="status_random_password"
                                           type="checkbox" checked>
                                    <span class="form-check-label">Mật khẩu ngẫu nhiên</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password" placeholder="Nhập mật khẩu"
                                           class="form-control d-none mt-2" autocomplete="off" style="z-index: 1">
                                    <button type="button" class="btn btn-outline-secondary toggle-password"
                                            tabindex="-1"
                                            style="border: none;position: absolute;top: 19%;right: 0;z-index: 2">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback-password"></div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-check">
                                    <input class="form-check-input" name="status_random_port"
                                           type="checkbox" checked>
                                    <span class="form-check-label">Port ngẫu nhiên</span>
                                </label>
                                <input type="number" name="port" placeholder="Nhập port"
                                       class="form-control d-none mt-2">
                                <div class="invalid-feedback-port"></div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-label">Ghi chú</div>
                                <textarea name="note"
                                          class="form-control"
                                          maxlength="500"
                                          placeholder="ghi chú (dưới 500 kí tự)"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mb-3">
                                <div class="form-label">Loại</div>
                                <select class="form-select" name="proxyType">
                                    @foreach($proxyType as $key=>$label)
                                        <option value="{{$key}}">{{$label}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <div class="form-label">Quốc gia</div>
                                <select class="form-select" name="nation">
                                    @foreach($support['nation']['option'] as $key=>$label)
                                        <option value="{{$key}}">{{$label}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 {{ empty($support['state']['option']) ? 'd-none': '' }}">
                                <div class="form-label">Bang</div>
                                <select class="form-select" name="state">
                                    @foreach($support['state']['option'] as $key=>$name)
                                        <option value="{{$name}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 {{ empty($support['isp']['option']) ? 'd-none': '' }}">
                                <div class="form-label">Nhà mạng</div>
                                <select class="form-select" name="isp">
                                    @foreach($support['isp']['option'] as $key=>$name)
                                        <option value="{{$name}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <div class="form-label">Dải IP</div>
                                <select class="form-select" name="range_ip">
                                    @foreach($support['range_ip']['option'] as $name)
                                        <option value="{{$name}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group mb-3">
                                <div class="form-label">Thời hạn</div>
                                <select class="form-select" id="duration" name="duration">
                                    @foreach($durations as $key=>$name)
                                        <option value="{{$key}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="coupon">Mã giảm giá</label>
                                <input type="text" name="coupon" placeholder="Mã giảm giá" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="coupon">Tóm tắt đơn hàng</label>
                                <div class="table data-table--custom table-wrapper">
                                    <table class="table table-bordered table-vertical">
                                        <tbody>
                                        <tr>
                                            <th class="fw-bg">Tạm tính</th>
                                            <td id="temporarily_calculated"></td>
                                        </tr>
                                        <tr>
                                            <th class="fw-bg">Số tiền giảm</th>
                                            <td id="reduced_amount"></td>
                                        </tr>
                                        <tr>
                                            <th class="fw-bg">Mã giảm giá</th>
                                            <td id="discount_amount"></td>
                                        </tr>
                                        <tr>
                                            <th class="fw-bg">Thành tiền</th>
                                            <td id="total"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div id="buy-warning" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-check mb-3">
                                    <input class="form-check-input" name="status_auto_extend" type="checkbox">
                                    <span class="form-check-label">Tự động gia hạn</span>
                                </label>
                                <label class="form-check">
                                    <input class="form-check-input" id="agree-policy" name="status_policy"
                                           type="checkbox" required>
                                    <span class="form-check-label">Tôi đã đọc và đồng ý với Chính sách sử dụng</span>
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                @if (auth()->check())
                                    <button type="button" id="btn-submit" class="btn btn-danger w-100 js-buy-proxy">Thanh toán
                                        ngay
                                    </button>
                                @else
                                    <a href="{{ route('auth.login') }}"
                                       class="btn btn-primary-bg w-100 mt-3 py-2 fw-semibold rounded-3">
                                        Đăng nhập
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $(document).on('click', '#psCheckoutModal .js-confirm', function(){
                const $btn = $(this);
                $btn.prop('disabled', true).text('Đang xử lý...');

                const $modal = $('#psCheckoutModal');
                const ctx = $modal.data('ctx');
                $.ajax({
                    url: "{{ route('vps.proxy.makeOrderProxy') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        plan_id: 0,
                        auto_renew: ctx.status_auto_extend,
                        coupon: ctx.coupon ?? '',
                        install_chrome: false,
                        install_firefox: false,
                        os_id: 0,
                        duration: ctx.duration,
                        is_proxy: true,
                        nation: ctx.nation,
                        proxy_type: ctx.proxyType,
                        quantity: Number(ctx.quantity),
                        random_username: ctx.status_random_username,
                        random_password: ctx.status_random_password,
                        random_remote_port: ctx.status_random_port,
                        range_ip: ctx.range_ip ?? "",
                        state: ctx.state ?? '',
                        isp: ctx.isp ?? '',
                        username: ctx.username ?? '',
                        password: ctx.password ?? '',
                        remote_port: ctx.port ?? '',
                        note: ctx.note ?? '',
                    },
                    success: function(res) {
                        // Kiểm tra có message hay không
                        if (res.success) {
                            toastr.options = {
                                "timeOut": 1500,
                                "extendedTimeOut": 1000,
                                "positionClass": "toast-top-right",
                                "onHidden": function() {
                                    window.location.href = '{{ route('vps.proxy.listProxyManagement',['by_time'=>'all']) }}';
                                }
                            };
                            toastr.success(res.message || 'Thanh toán thành công!', 'Thành công');
                        } else {
                            // Có thể trả về từ backend dạng: { success: false, message: "...", error: "..." }
                            toastr.error(res.message || res.error || 'Thanh toán thất bại!', 'Lỗi');
                        }
                    },
                    error: function(xhr) {
                        // Bắt lỗi từ Laravel Validation hoặc Exception
                        let msg = 'Không kết nối được với máy chủ.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        } else if (xhr.status === 422 && xhr.responseJSON.errors) {
                            // Trường hợp Laravel validation
                            msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(msg, 'Lỗi');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Thanh toán');
                    }
                });
            });

            $(document).on('click', '.js-buy-proxy', function (e) {
                e.preventDefault();

                const $modal = $('#psCheckoutModal');
                const $form = $('#form-proxy-buy');

                // Lấy tất cả dữ liệu trong form
                const formData = {};
                $form.find('input, select, textarea').each(function () {
                    const name = $(this).attr('name');
                    if (!name) return; // bỏ qua nếu không có name
                    if ($(this).is(':checkbox')) {
                        formData[name] = $(this).is(':checked'); // checkbox lưu true/false
                    } else if ($(this).is('select')) {
                        const $selected = $(this).find('option:selected');
                        formData[name] = $selected.val(); // giá trị value
                        const dataName = $selected.data('name');
                        if (dataName !== undefined) {
                            formData[name + '_name'] = dataName; // thêm thuộc tính _name nếu có data-name
                        }
                    } else {
                        formData[name] = $(this).val();
                    }
                });

                const qty = Number(formData.quantity);
                if (qty < 1) {
                    alert("Số lượng phải lớn hơn hoặc bằng 1");
                    return;
                }
                // Lưu vào modal data
                $modal.data('ctx', formData);

                if (formData.quantity) {
                    const baseAmount = parseInt($('#total').text().replace(/\D/g, '')) || 0;
                    $modal.find('.js-grand').text(baseAmount.toLocaleString('vi-VN') + ' VNĐ');
                }

                // Hiển thị modal
                const bsModal = new bootstrap.Modal($modal[0]);
                bsModal.show();
            });

            const nationSelect = document.querySelector('select[name="nation"]');
            const stateSelect = document.querySelector('select[name="state"]');
            const ispSelect = document.querySelector('select[name="isp"]');
            const durationSelect = document.querySelector('select[name="duration"]')
            const qtyInput = document.querySelector('input[name="quantity"]');
            const couponInput = document.querySelector('input[name="coupon"]');
            const rangeIpSelect = document.querySelector('select[name="range_ip"]');

            let selectedNation = null;
            let selectedState = null;
            let selectedIsp = null;
            let selectedDuration = null;
            let quantity = 1;
            let coupon = null;
            let selectedRangeIp = rangeIpSelect?.value || null;

            // --- SET GIÁ TRỊ MẶC ĐỊNH ---
            selectedNation = nationSelect?.value || null;
            selectedState = stateSelect?.value || null;
            selectedIsp = ispSelect?.value || null;
            selectedDuration = durationSelect?.value || 1;

            function debounce(func, delay = 300) {
                let timer;
                return function (...args) {
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(this, args), delay);
                };
            }

            rangeIpSelect?.addEventListener('change', function () {
                selectedRangeIp = this.value;
            });

            nationSelect?.addEventListener('change', function () {
                //Gọi cả đổi ip và summary
                selectedNation = this.value;

                resetSelect(stateSelect);
                resetSelect(ispSelect);
                resetSelect(rangeIpSelect);

                updateIPFromProvider(selectedNation, null, null, 'nation')
                updateOrderSummary(selectedNation, quantity, selectedDuration, coupon)
            });

            stateSelect?.addEventListener('change', function () {
                //Gọi cả đổi ip
                selectedState = this.value;

                resetSelect(ispSelect);
                resetSelect(rangeIpSelect);

                updateIPFromProvider(selectedNation, selectedState, null, 'state')
            });

            ispSelect?.addEventListener('change', function () {
                //Gọi cả đổi ip
                selectedIsp = this.value;

                resetSelect(stateSelect);
                resetSelect(rangeIpSelect);

                updateIPFromProvider(selectedNation, null, selectedIsp, 'isp')
            });

            durationSelect?.addEventListener('change', function () {
                //Gọi summary khi đổi tháng
                selectedDuration = this.value || 1;
                updateOrderSummary(selectedNation, quantity, selectedDuration, coupon)
            });

            qtyInput?.addEventListener('input', debounce(function () {
                //Gọi summary nhập số lượng
                quantity = parseInt(this.value) || 0;
                updateOrderSummary(selectedNation, quantity, selectedDuration, coupon)
            }, 500));

            couponInput?.addEventListener('input', debounce(function () {
                //Gọi summary nhập mã giảm giá
                coupon = parseInt(this.value) || null;
                updateOrderSummary(selectedNation, quantity, selectedDuration, coupon)
            }, 500));

            function updateIPFromProvider(nation, state = null, isp = null, updateType = 'nation') {
                $.ajax({
                    url: "{{ route('vps.proxy.ajaxProxySupport') }}",
                    method: "GET",
                    data: {nation, state, isp},
                    success: function (res) {
                        if (!res.success) return alert(res.error || 'Không thể lấy dữ liệu');
                        // --- Nếu cập nhật từ nation, render state và isp ---
                        if (updateType === 'nation') {
                            if (stateSelect) {
                                const stateWrapper = stateSelect.closest('.form-group');
                                const hasState = res.data.state?.option && Object.keys(res.data.state.option).length > 0;
                                if (hasState) {
                                    stateSelect.innerHTML = "";
                                    for (const key in res.data.state.option) {
                                        const opt = document.createElement("option");
                                        opt.value = res.data.state.option[key];
                                        opt.textContent = res.data.state.option[key];
                                        stateSelect.appendChild(opt);
                                    }
                                    stateSelect.value = res.data.state.option[0];
                                    selectedState = null;
                                    if (stateWrapper) stateWrapper.classList.remove("d-none");
                                } else {
                                    if (stateWrapper) stateWrapper.classList.add("d-none");
                                    selectedState = null;
                                }
                            }
                            if (ispSelect) {
                                const ispWrapper = ispSelect?.closest('.form-group');
                                const hasIsp = res.data.isp?.option && Object.keys(res.data.isp.option).length > 0;
                                if (hasIsp) {
                                    ispSelect.innerHTML = "";
                                    for (const key in res.data.isp.option) {
                                        const opt = document.createElement("option");
                                        opt.value = res.data.isp.option[key];
                                        opt.textContent = res.data.isp.option[key];
                                        ispSelect.appendChild(opt);
                                    }
                                    ispSelect.value = res.data.isp.option[0];
                                    selectedIsp = null;
                                    if (ispWrapper) ispWrapper.classList.remove("d-none");
                                } else {
                                    if (ispWrapper) ispWrapper.classList.add("d-none");
                                    selectedIsp = null;
                                }
                            }
                        }
                        if (rangeIpSelect) {
                            const rangeIpWrapper = rangeIpSelect?.closest('.form-group');
                            const hasRangeIp = res.data.range_ip?.option && Object.keys(res.data.range_ip.option).length > 0;
                            if (hasRangeIp) {
                                rangeIpSelect.innerHTML = "";
                                for (const key in res.data.range_ip.option) {
                                    const opt = document.createElement("option");
                                    opt.value = res.data.range_ip.option[key];
                                    opt.textContent = res.data.range_ip.option[key];
                                    rangeIpSelect.appendChild(opt);
                                }
                                rangeIpSelect.value = res.data.range_ip.option[0];
                                selectedRangeIp= null;
                                if (rangeIpWrapper) rangeIpWrapper.classList.remove("d-none");
                            } else {
                                if (rangeIpWrapper) rangeIpWrapper.classList.add("d-none");
                                selectedRangeIp = null;
                            }
                        }
                    },
                    error: function () {
                        alert('Hệ thống quá tải, vui lòng thử lại sau!');
                    }
                });
            }

            function updateOrderSummary(nation, quantity, duration, coupon) {
                if (quantity <= 0) {
                    document.getElementById("temporarily_calculated").innerText = "0 VNĐ";
                    document.getElementById("reduced_amount").innerText = "0 VNĐ";
                    document.getElementById("discount_amount").innerText = "0 VNĐ";
                    document.getElementById("total").innerText = "0 VNĐ";
                    return;
                }
                $.ajax({
                    url: "{{ route('vps.proxy.ajaxProxyCalculate') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon: coupon,
                        duration: duration,
                        is_proxy: true,
                        nation: nation,
                        plan_id: 0,
                        quantity: quantity
                    },
                    success: function (res) {
                        if (res.success) {
                            let original_price = parseFloat(res.data.original_price.replace(/,/g, ''));
                            document.getElementById("temporarily_calculated").innerText =
                                (original_price).toLocaleString('en-US') + ' đ' || '0 đ';

                            document.getElementById("reduced_amount").innerText =
                                res.data.discount || '0 đ';

                            document.getElementById("discount_amount").innerText =
                                res.data.coupon || '0 đ';

                            let must_pay = parseFloat(res.data.must_pay.replace(/,/g, ''));
                            document.getElementById("total").innerText =
                                (must_pay).toLocaleString('en-US') + ' đ' || '0 đ';

                            if (res.data.warning) {
                                const warning = document.getElementById('buy-warning');
                                warning.textContent = res.data.warning;
                                warning.style.display = "block";
                            } else {
                                document.getElementById('buy-warning').style.display = "none";
                            }

                        } else {
                            alert(res.error || 'Không tính được giá');
                        }
                    },
                    error: function () {
                        alert('Hệ thống quả tải, vui lòng thử lại sau!');
                    }
                });
            }

            const agreePolicy = document.getElementById('agree-policy');
            const btnSubmit = document.getElementById('btn-submit');
            const toggleSubmitButton = () => {
                btnSubmit.disabled = !agreePolicy.checked;
            };
            toggleSubmitButton();
            agreePolicy.addEventListener('change', toggleSubmitButton);

            function resetSelect(selectEl, placeholder = "--Chọn--") {
                if (!selectEl) return;
                selectEl.innerHTML = `<option value="">${placeholder}</option>`;
                selectEl.value = "";
            }
        });

    </script>
@stop


