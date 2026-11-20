@extends("vps.layout")
@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3 class="page-title">Gói dịch vụ VPS đã chọn</h3>
            <div class="proxy-static-list proxy-static buying-order">
                <table class="table data-table--custom" cellspacing="0" data-toggle="table">
                    <thead>
                    <tr>
                        <th>CPU</th>
                        <th>Ram</th>
                        <th>SSD</th>
                        <th>IPv4</th>
                        <th>Ethernet port</th>
                        <th>Băng thông</th>
                        <th>Đơn giá (VNĐ)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$package['cpu']}}</td>
                        <td>{{$package['ram']}}</td>
                        <td>{{$package['ssd']}}</td>
                        <td>{{$package['ipv4']}}</td>
                        <td>{{$package['ethernet_port']}}</td>
                        <td>{{$package['bandwidth']}}</td>
                        <td>{{number_format((int) str_replace(',', '', $package['price']) + ((int) str_replace(',', '', $package['price']) * ($feePercent/100)))}}đ</td>
                    </tr>
                    </tbody>
                </table>

                <form id="form-vps-buy" class="order-vps-form mt-2">
                    <input type="hidden" name="plan_id" value="{{$package['id']}}">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="quantity">Số lượng</label>
                                <input type="number" name="quantity" placeholder="Số lượng" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-check">
                                    <input class="form-check-input" id="random-password" name="status_random_password"
                                           type="checkbox" checked>
                                    <span class="form-check-label">Mật khẩu ngẫu nhiên</span>
                                </label>

                                <div class="input-group">
                                    <input type="password" id="password-input" name="password" placeholder="Nhập mật khẩu"
                                           class="form-control d-none mt-2" autocomplete="off" style="z-index: 1">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" tabindex="-1" style="border: none;position: absolute;top: 19%;right: 0;z-index: 2">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback-password"></div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-check">
                                    <input class="form-check-input" id="random-port" name="status_random_port"
                                           type="checkbox" checked>
                                    <span class="form-check-label">Port ngẫu nhiên</span>
                                </label>
                                <input type="number" id="port-input" name="port" placeholder="Nhập port"
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
                                <div class="form-label">Hệ điều hành</div>
                                <select id="os" class="form-select" name="os">
                                    @foreach($dataSupportPlan['os']['option'] as $key=>$spPlan)
                                        <option data-name="{{$spPlan}}" value="{{$key}}">{{$spPlan}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-label">Cài đặt thêm tiện ích</div>
                                <label class="form-check mb-3">
                                    <input class="form-check-input" name="status_chrome" type="checkbox">
                                    <span class="form-check-label">Chrome</span>
                                </label>
                                <label class="form-check">
                                    <input class="form-check-input" name="status_firefox" type="checkbox">
                                    <span class="form-check-label">Firefox</span>
                                </label>
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-label">Dải IP</div>
                                <select class="form-select" id="ip" name="ip">
                                    @foreach($dataSupportPlan['range_ip']['option'] as $key=>$name)
                                        <option value="{{$name}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-label">Thời hạn</div>
                                <select class="form-select" id="duration" name="duration">
                                    @foreach($dataSupportPlan['duration']['option'] as $key=>$name)
                                        <option value="{{$key}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
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
                                    <input class="form-check-input" id="agree-policy" name="status_policy" type="checkbox" required>
                                    <span class="form-check-label">Tôi đã đọc và đồng ý với Chính sách sử dụng</span>
                                </label>
                            </div>
                            <div class="form-group mb-3">
                                <button type="button" id="btn-submit" class="btn btn-danger w-100 js-buy-vps">Thanh toán ngay</button>
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
        const feePercent = @json($feePercent);
        document.addEventListener('DOMContentLoaded', function () {

            $(document).on('click', '#psCheckoutModal .js-confirm', function(){
                const $btn = $(this);
                $btn.prop('disabled', true).text('Đang xử lý...');

                const $modal = $('#psCheckoutModal');
                const ctx = $modal.data('ctx');

                $.ajax({
                    url: "{{ route('vps.makeOrder') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        plan_id: ctx.plan_id,
                        duration: ctx.duration,
                        auto_renew: ctx.status_auto_extend,
                        quantity: Number(ctx.quantity),
                        os_id: ctx.os,
                        os_name: ctx.os_name,
                        random_password: ctx.status_random_password,
                        random_remote_port: ctx.status_random_port,
                        install_chrome: ctx.status_chrome,
                        install_firefox: ctx.status_firefox,
                        coupon: ctx.coupon ?? '',
                        range_ip: ctx.ip,
                        remote_port: ctx.port ?? '',
                        state: ctx.location ?? 'GPU',
                        password: ctx.password ?? '',
                        port: ctx.port ?? '',
                        note: ctx.note ?? '',
                        nation: ctx.nation ?? 'GPU',
                        type: 'gpu'
                    },
                    success: function(res) {
                        // Kiểm tra có message hay không
                        if (res.success) {
                            toastr.options = {
                                "timeOut": 1500,
                                "extendedTimeOut": 1000,
                                "positionClass": "toast-top-right",
                                "onHidden": function() {
                                    window.location.href = '{{ route('vps.listVpsManagement',['by_time'=>'all']) }}';
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

            $(document).on('click', '.js-buy-vps', function(e){
                e.preventDefault();

                const $modal = $('#psCheckoutModal');
                const $form = $('#form-vps-buy');

                // Lấy tất cả dữ liệu trong form
                const formData = {};
                $form.find('input, select, textarea').each(function() {
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

                if (formData.quantity && formData.plan_id) {
                    const baseAmount = parseInt($('#total').text().replace(/\D/g, '')) || 0;
                    $modal.find('.js-grand').text(baseAmount.toLocaleString('vi-VN') + ' VNĐ');
                }

                // Hiển thị modal
                const bsModal = new bootstrap.Modal($modal[0]);
                bsModal.show();
            });

            const locationSelect = document.getElementById('location');
            const osSelect = document.getElementById('os');
            const ipSelect = document.getElementById('ip');
            const durationSelect = document.getElementById('duration');
            const qtyInput = document.querySelector('input[name="quantity"]');
            const couponInput = document.querySelector('input[name="coupon"]');

            let selectedLocation = null;
            let selectedOS = null;
            let selectedIP = null;
            let selectedDuration = null;
            let quantity = 1;
            let coupon = null;

            // --- SET GIÁ TRỊ MẶC ĐỊNH ---
            selectedLocation = locationSelect?.value || null;
            selectedOS = osSelect?.value || null;
            selectedIP = ipSelect?.value || null;
            selectedDuration = durationSelect?.value || 1;

            function debounce(func, delay = 300) {
                let timer;
                return function(...args) {
                    clearTimeout(timer);
                    timer = setTimeout(() => func.apply(this, args), delay);
                };
            }

            locationSelect?.addEventListener('change', function () {
                selectedLocation = this.value;
                updateIPFromLocation(selectedLocation)
            });
            osSelect?.addEventListener('change', function () {
                selectedOS = this.value;
            });
            ipSelect?.addEventListener('change', function () {
                selectedIP = this.value;
            });
            durationSelect?.addEventListener('change', function () {
                selectedDuration = this.value || 1;
                updateOrderSummary(selectedDuration, quantity, coupon)
            });
            qtyInput?.addEventListener('input', debounce(function () {
                quantity = parseInt(this.value) || 0;
                updateOrderSummary(selectedDuration, quantity, coupon)
            }, 500));

            couponInput?.addEventListener('input', debounce(function () {
                coupon = parseInt(this.value) || null;
                updateOrderSummary(selectedDuration, quantity, coupon)
            }, 500));

            function updateIPFromLocation(state) {
                const plan_id = document.querySelector('input[name="plan_id"]');
                $.ajax({
                    url: "{{ route('vps.ajaxSupport') }}",
                    method: "GET",
                    data: {
                        state: state,
                        plan_id: plan_id.value,
                    },
                    success: function (res) {
                        if (res.success) {
                            const ipOptions = res.data.ip.option;
                            // --- xoá option cũ ---
                            ipSelect.innerHTML = "";
                            // --- add vào option mới ---
                            for (const key in ipOptions) {
                                const opt = document.createElement("option");
                                opt.value = ipOptions[key];
                                opt.textContent = ipOptions[key];
                                ipSelect.appendChild(opt);
                            }
                            // --- RESET ip đã chọn về ip option đầu tiên ---
                            ipSelect.value = ipOptions[0];
                            selectedIP = null;
                        } else {
                            alert(res.error || 'Không thể chọn Bang');
                        }
                    },
                    error: function () {
                        alert('Hệ thống quả tải, vui lòng thử lại sau!');
                    }
                });
            }

            function updateOrderSummary(duration = 1, quantity = 0, coupon = '') {
                if (quantity <= 0) {
                    console.log(quantity)
                    document.getElementById("temporarily_calculated").innerText = "0 VNĐ";
                    document.getElementById("reduced_amount").innerText = "0 VNĐ";
                    document.getElementById("discount_amount").innerText = "0 VNĐ";
                    document.getElementById("total").innerText = "0 VNĐ";
                    return;
                }

                const plan_id = document.querySelector('input[name="plan_id"]');

                $.ajax({
                    url: "{{ route('vps.ajaxCalculate') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon: coupon,
                        duration: duration,
                        plan_id: plan_id.value,
                        quantity: quantity,
                    },
                    success: function (res) {
                        if (res.success) {
                            let original_price =  parseFloat(res.data.original_price.replace(/,/g, ''));
                            let fee = original_price*feePercent/100;
                            document.getElementById("temporarily_calculated").innerText =
                                (original_price + fee).toLocaleString('en-US') + ' đ' || '0 đ';

                            document.getElementById("reduced_amount").innerText =
                                res.data.discount || '0 đ';

                            document.getElementById("discount_amount").innerText =
                                res.data.coupon || '0 đ';

                            let must_pay =  parseFloat(res.data.must_pay.replace(/,/g, ''));
                            document.getElementById("total").innerText =
                                (must_pay + fee).toLocaleString('en-US') + ' đ' || '0 đ';

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
        });

    </script>
@stop


