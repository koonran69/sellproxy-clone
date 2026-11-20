@extends("proxy-residential.layout")
@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3 class="page-title">Chọn dịch vụ</h3>
            <div class="proxy-static-list proxy-static">
                <div class="proxy-card p-3 mb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-12">
                            <div class="row g-2">
                                @foreach($data['services'] as $service)
                                    <?php
                                        $price = !empty($metadata[$service['id']]['metadata']['plans']) ? $metadata[$service['id']]['metadata']['plans'][$service['plans'][0]['id']]['price'] : $metadata[$service['id']]['metadata']['price'];
                                        $discount = $metadata[$service['id']]['metadata']['specialOffer']['discount'];
                                    ?>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="card card-item-service" data-id="{{$service['id']}}"
                                             data-service='@json($service)'
                                             data-metadata='@json($metadata[$service['id']]['metadata'])'>
                                            <div class="card-body card-body-item-service p-3">
                                                <div class="title-item-service fw-bold my-2">{{$service['label']}}</div>
                                                <hr class="MuiDivider-root MuiDivider-fullWidth css-6jywu4">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="start-at-title text-uppercase">Bắt đầu chỉ từ</div>
                                                    <div class="text-secondary d-flex">
                                                        <span class="price-item-service text-decoration-line-through me-1">{{number_format($price*$rate['VND'])}}đ</span>
                                                        <span class="fw-bold">{{ number_format(floor(($price*$rate['VND'] - ($price*$rate['VND'] * $discount / 100)) * 100) / 100) }}đ/{{$metadata[$service['id']]['metadata']['specialOffer']['properties']['unit']}}
                                                    </div>
{{--                                                    <div class="text-secondary d-flex">--}}
{{--                                                        <span class="price-item-service text-decoration-line-through me-1">${{$service['plans'][0]['price']['priceNoDiscounts']}}</span>--}}
{{--                                                        <span class="fw-bold">--}}
{{--                                                            {{ floor(($service['plans'][0]['price']['priceNoDiscounts'] - ($service['plans'][0]['price']['priceNoDiscounts'] * $metadata[$service['id']]['metadata']['specialOffer']['discount'] / 100)) * 100) / 100 }}/{{$metadata[$service['id']]['metadata']['specialOffer']['properties']['unit']}}--}}
{{--                                                        </span>--}}
{{--                                                    </div>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--list plan--}}
    <div class="card service-details-block" style="display: none">
        <div class="card-body pt-0 card-body-service-details-block">
        </div>
    </div>
    {{--no plan/of rorating--}}
    <div class="card service-order-block">
        <div class="card-body pt-0 card-body-service-order-block">
        </div>
    </div>
    {{--no plan/of ipv6 datacenter--}}
    <div class="card service-order-dc-ipv6-block">
        <div class="card-body pt-0 card-body-service-order-dc-ipv6-block">
        </div>
    </div>

    <div class="card order-summary-block" style="display: none">
        <div class="card-body card-body-order-summary">
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
        const assetBase = "{{ asset('') }}";
        // const vnd    = n => (Number(n)||0).toLocaleString('vi-VN') + 'đ';
        const vnd = n => (Number(n) || 0).toLocaleString('en-US') + ' đ';
        const rate = @json($rate);

        $(document).on('click', '.js-buy', function(){
            const $modal = $('#psCheckoutModal');

            let baseAmount = $(this).data('baseamount');
            baseAmount = baseAmount * rate.VND;

            const service_id = $(this).data('service_id');
            const plan_id = $(this).data('plan_id');
            const country = $(this).data('country');
            const isp = $(this).data('isp');
            const quantity = $(this).data('quantity');
            const months = $(this).data('months');
            const traffic = $(this).data('traffic');
            const package_id = $(this).data('package');


            // --- Lưu toàn bộ context để confirm sử dụng ---
            $modal.data('ctx', {
                service_id: service_id,
                plan_id: plan_id || null,
                country: country,
                isp: isp,
                quantity: quantity,
                months: months,
                traffic: traffic,
                package_id: package_id,
                baseAmount: baseAmount,
            });

            // Cập nhật giá hiển thị
            $modal.find('.js-grand').text(vnd(baseAmount));

            const bsModal = new bootstrap.Modal($modal[0]);
            bsModal.show();
        });

        // Khi confirm thanh toán
        $(document).on('click', '#psCheckoutModal .js-confirm', function(){
            const $btn = $(this);
            $btn.prop('disabled', true).text('Đang xử lý...');

            const $modal = $('#psCheckoutModal');
            const ctx = $modal.data('ctx');

            $.ajax({
                url: "{{ route('proxyResidential.proxyMakeOrder') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    service_id: ctx.service_id,
                    plan_id: ctx.plan_id,
                    country: ctx.country,
                    isp: (typeof ctx.isp === 'object' && ctx.isp?.name) ? ctx.isp.name : ctx.isp,
                    quantity: ctx.quantity,
                    months: ctx.months,
                    traffic: ctx.traffic,
                    package_id: ctx.package_id
                },
                success: function(res) {
                    // Kiểm tra có message hay không
                    if (res.success) {
                        toastr.options = {
                            "timeOut": 1500,
                            "extendedTimeOut": 1000,
                            "positionClass": "toast-top-right",
                            "onHidden": function() {
                                window.location.href = '{{ route('proxyResidential.proxyStaticList') }}';
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

        document.addEventListener('DOMContentLoaded', function () {
            const detailSummaryCard = document.querySelector('.order-summary-block');
            const detailSummaryBodySelector = '.card-body-order-summary';

            const detailOrderDCIPV6Card = document.querySelector('.service-order-dc-ipv6-block');
            const detailOrderDCIPV6BodySelector = '.card-body-service-order-dc-ipv6-block';

            const detailOrderCard = document.querySelector('.service-order-block');
            const detailOrderBodySelector = '.card-body-service-order-block';

            const detailService = document.querySelector('.service-details-block');

            //clear order & summary block
            function clearOrderBlock() {
                // hide card datacenter ipv6 order
                detailOrderDCIPV6Card.style.display = 'none';
                const orderDCIPV6Body = detailOrderDCIPV6Card.querySelector(detailOrderDCIPV6BodySelector);
                if (orderDCIPV6Body) orderDCIPV6Body.innerHTML = '';

                // hide card order
                detailOrderCard.style.display = 'none';
                const orderBody = detailOrderCard.querySelector(detailOrderBodySelector);
                if (orderBody) orderBody.innerHTML = '';

                // clear bootstrap-select events
                try {
                    if (window.jQuery) {
                        $('#proxyLocation').off('changed.bs.select');
                        if ($('#proxyLocation').data('selectpicker')) {
                            $('#proxyLocation').selectpicker('destroy');
                        }
                    }
                } catch (e) {}

                // clear order summary
                if (detailSummaryCard) {
                    const summaryBody = detailSummaryCard.querySelector(detailSummaryBodySelector);
                    if (summaryBody) summaryBody.innerHTML = '';
                    detailSummaryCard.style.display = 'none';
                }
            }

            // update order summary
            function updateOrderSummary(service, plan, selectedCountryKey, ispValue, quantity, period, rawPrice, discount) {
                if (!selectedCountryKey) return; // chưa chọn country thì không gọi Ajax
                const ispElem = document.getElementById('ispLocation');
                if (ispElem) { // chỉ có ISP khi service có trường này
                    if (!ispValue) {
                        return;
                    }
                }
                if (!period) return; // chưa chọn period
                if (!quantity || quantity < 1) return;

                const summaryBody = detailSummaryCard.querySelector(detailSummaryBodySelector);
                if (!summaryBody) return;

                // Hiển thị "Loading..."
                summaryBody.innerHTML = `<div class="p-3 text-center text-muted">Đang tính toán...</div>`;
                detailSummaryCard.style.display = 'block';
                const isp = (typeof ispValue === 'object' && ispValue?.value) ? ispValue.value : null;
                $.ajax({
                    url: "{{ route('proxyResidential.proxyGetPrice') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        service_id: service.id,
                        plan_id: plan.id,
                        country: selectedCountryKey,
                        isp: isp,
                        quantity: quantity,
                        months: period
                    },
                    success: function (res) {
                        if (res.success) {
                            let ispHTML = '';
                            const ispElem = document.getElementById('ispLocation');
                            if (ispElem) { // chỉ có ISP khi service có trường này
                                if (ispValue) {
                                    ispHTML = `<li><strong>ISP:</strong> ${ispValue.name}</li>`;
                                } else {
                                    ispHTML = `<li><strong>ISP:</strong> Không được chọn</li>`; // có thể để thông báo chưa chọn
                                }
                            }
                            summaryBody.innerHTML = `
                                <h3 class="page-title mb-3">Đơn hàng</h3>
                                <div class="proxy-card p-3 mb-4">
                                    <ul class="list-unstyled lh-lg">
                                        <li><strong>Dịch vụ:</strong> ${service.label}</li>
                                        <li><strong>Gói:</strong> ${plan.label}</li>
                                        <li><strong>Quốc gia:</strong> ${selectedCountryKey || 'N/A'}</li>
                                        ${ispHTML}
                                        <li><strong>Giá mỗi IP:</strong> ${vnd(parseFloat(res.unitPriceAfterDiscount > 0 ? res.unitPriceAfterDiscount*rate.VND : res.unitPrice*rate.VND).toFixed(2))}</li>
                                        <li><strong>Số lượng (IP):</strong> ${quantity} IP</li>
                                        <li><strong>Thời gian thuê:</strong> ${period} tháng</li>
                                        <li><hr></li>
                                        <li><strong>Giá:</strong> ${vnd(parseFloat(res.priceNoDiscounts*rate.VND).toFixed(2))}</li>
                                        <li><strong>Giảm giá:</strong> -${vnd(parseFloat(res.discountAmount*rate.VND).toFixed(2))} (${res.discount}%)</li>
                                    </ul>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold fs-5">Tổng</span>
                                        <div class="col-md-2 text-center">
                                            <div class="proxy-price js-total">${vnd(parseFloat(res.finalPrice*rate.VND).toFixed(2))}</div>
                                            @if (auth()->check())
                                                <button class="btn btn-buy mt-2 js-buy"
                                                    data-baseamount="${res.finalPrice}"
                                                    data-service_id='${service.id}'
                                                    data-plan_id='${plan.id}'
                                                    data-country="${selectedCountryKey}"
                                                    data-isp='${(typeof ispValue === 'object' && ispValue?.value) ? ispValue.value : null}'
                                                    data-quantity="${quantity}"
                                                    data-months="${period}">Mua hàng</button>
                                            @else
                                                <a href="{{route('auth.login')}}" class="btn btn-buy mt-2 js-buy">Đăng nhập</a>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                            `;
                        } else {
                            summaryBody.innerHTML = `<div class="alert alert-danger">Error: ${res.error || 'Failed to calculate price'}</div>`;
                        }
                    },
                    error: function () {
                        summaryBody.innerHTML = `<div class="alert alert-danger">Failed to connect to pricing API.</div>`;
                    }
                });
            }

            // initial clear
            clearOrderBlock();

            const cards = document.querySelectorAll('.card-item-service');
            cards.forEach(card => {
                card.addEventListener('click', function () {
                    cards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    clearOrderBlock();

                    const serviceData = JSON.parse(this.dataset.service);
                    const serviceMetadata = JSON.parse(this.dataset.metadata);

                    let plans = serviceMetadata?.plans ?? [];
                    if (!Array.isArray(plans)) plans = Object.values(plans);

                    if (!plans.length) {
                        detailService.style.display = 'none';
                        if (serviceData.id === 'rotating-mobile' || serviceData.id === 'rotating-residential') {
                            renderCardRotating(serviceData,serviceMetadata);
                        }
                        if (serviceData.id === 'static-datacenter-ipv6') {
                            renderCardDatacenterIPV6(serviceData,serviceMetadata);
                        }
                        return;
                    }

                    detailService.style.display = 'block';
                    renderPlans(serviceData, serviceMetadata);
                });
            });
            if (cards.length > 0) {
                cards[0].classList.add('active');
                cards[0].click();
            }

            // render plans
            function renderPlans(serviceData, metadata) {
                const detailBody = detailService.querySelector('.card-body-service-details-block');
                if (!detailBody) return;

                const plans = serviceData.plans || [];
                const metaDataPlans = metadata.plans || {};

                let html = `
                    <h3 class="page-title">Gói</h3>
                    <div class="proxy-card p-3 mb-4">
                        <div class="row g-3 align-items-center"><div class="col-12"><div class="row g-2">
                `;

                plans.forEach(plan => {
                    // const rawPrice = plan.price?.priceNoDiscounts || 0;
                    // const discount = metadata.specialOffer?.discount || 0;
                    const rawPrice = metaDataPlans[plan.id].price;
                    const discount = metadata.specialOffer?.discount || 0;

                    const price = Math.floor((rawPrice - (rawPrice * discount / 100)) * 100) / 100;
                    const unit = metadata.specialOffer?.properties?.unit ?? '';
                    const label = metaDataPlans[plan.id].label ?? 'No name';
                    const planMeta = metaDataPlans[plan.id] || {};
                    const popularHTML = planMeta.popular ? `<span class="badge bg-danger text-light">PHỔ BIẾN</span>` : '';
                    const providedListHTML = (planMeta.list_provided?.length
                            ? planMeta.list_provided.map(v => {
                                const svg = v.status === 'checked'
                                    ? `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="icon me-1 text-success"><path d="M5 12l5 5l10 -10"></path></svg>`
                                    : `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="icon me-1 text-danger"><path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path></svg>`;
                                return `<li>${svg} ${v.label}</li>`;
                            }).join('')
                            : '<li class="text-muted">Không có thông tin</li>'
                    );

                    html += `
                        <div class="col-sm-6 col-md-4">
                            <div class="card card-item-service"
                                 data-id="${plan.id}"
                                 data-plan='${JSON.stringify(plan)}'
                                 data-planmeta='${JSON.stringify(planMeta)}'
                                 data-service='${JSON.stringify(serviceData)}'
                                 data-rawprice='${rawPrice}'
                                 data-discount='${discount}'>
                                <div class="card-body p-3">
                                    <div class="title-item-service fw-bold my-2 d-flex justify-content-between align-items-center">
                                        <span>${label}</span> ${popularHTML}
                                    </div>
                                    <ul class="list-unstyled list-provided lh-lg">${providedListHTML}</ul>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="start-at-title text-uppercase">Bắt đầu chỉ từ</div>
                                        <div class="text-secondary d-flex">
                                            <span class="price-item-service text-decoration-line-through me-1">${vnd(rawPrice*rate.VND)}</span>
                                            <span class="fw-bold">${vnd(price*rate.VND)}</span>/${unit}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += `</div></div></div></div>`;
                detailBody.innerHTML = html;

                const newPlanCards = detailBody.querySelectorAll('.card-item-service');
                newPlanCards.forEach(pc => {
                    pc.addEventListener('click', function () {
                        newPlanCards.forEach(c => c.classList.remove('active'));
                        this.classList.add('active');

                        const plan = JSON.parse(this.dataset.plan);
                        const planmeta = JSON.parse(this.dataset.planmeta);
                        const service = JSON.parse(this.dataset.service);
                        const rawPrice = this.dataset.rawprice;
                        const discount = this.dataset.discount;

                        renderCardOrder(plan.id, plan, planmeta, service, rawPrice, discount);
                    });
                });
                if (newPlanCards.length > 0) {
                    newPlanCards[0].classList.add('active');
                    newPlanCards[0].click();
                }
            }

            // render order
            function renderCardOrder(planId = null, plan = null, planmeta = null, service, rawPrice = 0, discount = 0) {
                const detailOrderBody = detailOrderCard.querySelector('.card-body-service-order-block');
                if (!detailOrderBody) return;

                clearOrderBlock();

                const getCountryAll = @json($getCountryAll);
                const countries = Array.isArray(plan.info?.countries) ? plan.info.countries : [];
                const filtered = Object.entries(getCountryAll).filter(([k]) => countries.includes(k));
                const allIsps = (plan.info && typeof plan.info.isps === 'object') ? plan.info.isps : {};
                const ispsByCountry = {};
                const countryOptionsHTML = filtered.map(([key, value]) => {
                    const countryIsps = Array.isArray(allIsps[key]) ? allIsps[key] : [];
                    ispsByCountry[key] = countryIsps;
                    // const imgPath = assetBase + value.feature_image.replace(/^public\//, '');
                    const imgPath = assetBase + value.feature_image;
                    return `<option value="${key}" data-content="<img src='${imgPath}' width='25' class='me-2 rounded'> ${value.name}">${value.name}</option>`;
                }).join('');

                let periods = plan.info?.periods.months || [];
                let periodsOptionsHTML = ``;
                periods.forEach(item => {
                    periodsOptionsHTML += `<option value="${item}">${item} tháng</option>`;
                });

                let innerIspsHTML = ``;
                if (allIsps && Object.keys(allIsps).length > 0) {
                    innerIspsHTML += `
                        <hr>
                        <div class="row mb-3">
                            <label for="ispLocation" class="col-sm-6 col-form-label">ISP</label>
                            <div class="col-sm-6 d-flex align-items-center">
                                <span>Không khả dụng. Vui lòng chọn vị trí trước.</span>
                                <select id="ispLocation" name="isp_region" class="form-select" style="display:none;" required>
                                    <option selected disabled>Chọn ISP</option>
                                </select>
                            </div>
                        </div>
                    `;
                }

                detailOrderBody.innerHTML = `
                    <div class="proxy-static-list proxy-static">
                        <div class="proxy-card p-3 mb-4">
                            <div class="row mb-3">
                                <label for="proxyLocation" class="col-sm-6 col-form-label">Quốc gia</label>
                                <div class="col-sm-6">
                                    <select id="proxyLocation" name="region" class="selectpicker" data-live-search="true" data-width="100%" required>
                                        <option selected>Chọn quốc gia</option>
                                        ${countryOptionsHTML}
                                    </select>
                                </div>
                            </div>
                            ${innerIspsHTML}
                            <hr>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Số lượng (IP)</label>
                                <div class="col-sm-6">
                                    <input type="number" min="1" max="100" class="form-control" name="number_proxy" value="1">
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Thời gian thuê</label>
                                <div class="col-sm-6">
                                    <select id="time_period" class="form-select" required>
                                        ${periodsOptionsHTML}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                detailOrderCard.style.display = 'block';

                //Nghe sự kiện thay đổi để update Order Summary=================================
                let selectedCountryKey = null;
                let selectedISP = null;
                let quantity = 1;
                let period = 1;

                const proxyLocation = document.getElementById('proxyLocation');
                const ispSelect = document.getElementById('ispLocation');
                const qtyInput = detailOrderBody.querySelector('input[name="number_proxy"]');
                const periodSelect = detailOrderBody.querySelector('#time_period');

                proxyLocation?.addEventListener('change', function() {
                    selectedCountryKey = this.value;
                    let selectedISP = null;
                    detailSummaryCard.style.display = 'none';
                    updateOrderSummary(service, plan, selectedCountryKey, selectedISP, quantity, period, rawPrice, discount);
                });

                ispSelect?.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    selectedISP = {
                        value: selectedOption.value,
                        name: selectedOption.textContent
                    };
                    updateOrderSummary(service, plan, selectedCountryKey, selectedISP, quantity, period, rawPrice, discount);
                });

                qtyInput?.addEventListener('input', function() {
                    quantity = parseInt(this.value) || 1;
                    updateOrderSummary(service, plan, selectedCountryKey, selectedISP, quantity, period, rawPrice, discount);
                });

                periodSelect?.addEventListener('change', function() {
                    period = parseInt(this.value) || 1;
                    updateOrderSummary(service, plan, selectedCountryKey, selectedISP, quantity, period, rawPrice, discount);
                });
                //Nghe sự kiện thay đổi để update Order Summary=================================

                setTimeout(() => {
                    if (window.jQuery) {
                        $('#proxyLocation').off('changed.bs.select');
                        if ($('#proxyLocation').data('selectpicker')) {
                            $('#proxyLocation').selectpicker('destroy');
                        }
                        $('#proxyLocation').selectpicker();
                        $('#proxyLocation').on('changed.bs.select', function () {
                            const proxyElem = document.getElementById('proxyLocation');
                            if (!proxyElem) return;
                            const selectedOption = proxyElem.options[proxyElem.selectedIndex];
                            const ispSelect = document.getElementById('ispLocation');
                            if (!ispSelect) return;

                            const ispContainer = ispSelect.parentElement;
                            const infoSpan = ispContainer ? ispContainer.querySelector('span') : null;
                            ispSelect.style.display = 'none';
                            ispSelect.innerHTML = '<option selected disabled>Chọn ISP</option>';

                            if (!selectedOption) {
                                if (infoSpan) infoSpan.style.display = '';
                                return;
                            }
                            const selectedCountry = selectedOption.value;
                            const isps = Array.isArray(ispsByCountry[selectedCountry]) ? ispsByCountry[selectedCountry] : [];

                            if (isps.length) {
                                if (infoSpan) infoSpan.style.display = 'none';
                                isps.forEach(item => {
                                    const opt = document.createElement('option');
                                    opt.value = item.id ?? (typeof item === 'string' ? item : (item.label ?? ''));
                                    opt.textContent = item.label ?? (typeof item === 'string' ? item : '');
                                    ispSelect.appendChild(opt);
                                });
                                ispSelect.style.display = 'block';
                            } else {
                                ispSelect.style.display = 'none';
                                if (infoSpan) infoSpan.style.display = '';
                            }
                        });
                    }
                }, 80);
            }

            function renderCardDatacenterIPV6(service, serviceMetadata) {
                const detailOrderDCIPV6Body = detailOrderDCIPV6Card.querySelector('.card-body-service-order-dc-ipv6-block');
                if (!detailOrderDCIPV6Body) return;

                clearOrderBlock();

                const getCountryAll = @json($getCountryAll);
                const countries = Array.isArray(service.plans[0].info.countries)
                    ? service.plans[0].info.countries
                    : [];

                const filtered = Object.entries(getCountryAll).filter(([k]) => countries.includes(k));

                const countryOptionsHTML = filtered.map(([key, value]) => {
                    // const imgPath = assetBase + value.feature_image.replace(/^public\//, '');
                    const imgPath = assetBase + value.feature_image;
                    return `<option value="${key}" data-content="<img src='${imgPath}' width='25' class='me-2 rounded'> ${value.name}">${value.name}</option>`;
                }).join('');

                let periods = service.plans[0].info.periods?.months || [];
                let periodsOptionsHTML = ``;
                periods.forEach(item => {
                    periodsOptionsHTML += `<option value="${item}">${item} tháng</option>`;
                });

                let packages = service.plans[0].info?.packages || [];
                let packagesOptionsHTML = ``;
                packages.forEach(item => {
                    packagesOptionsHTML += `<option value="${item}">${item}</option>`;
                });

                // Render giao diện IPv6
                detailOrderDCIPV6Body.innerHTML = `
                    <div class="proxy-static-list proxy-static">
                        <div class="proxy-card p-3 mb-4">
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Quốc gia</label>
                                <div class="col-sm-6">
                                    <select name="region" class="selectpicker proxyLocation"
                                        data-live-search="true"
                                        data-width="100%"
                                        required>
                                        <option selected>Chọn quốc gia</option>
                                        ${countryOptionsHTML}
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">IP gói</label>
                                <div class="col-sm-6">
                                    <select class="form-select package" name="package" required>
                                        ${packagesOptionsHTML}
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Thời gian thuê</label>
                                <div class="col-sm-6">
                                    <select class="form-select timePeriod" name="time_period" required>
                                        ${periodsOptionsHTML}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Hiển thị card IPv6
                detailOrderDCIPV6Card.style.display = 'block';

                // Kích hoạt selectpicker cho đúng phần tử trong block này
                const proxyLocation = detailOrderDCIPV6Body.querySelector('.proxyLocation');
                if (proxyLocation) {
                    $(proxyLocation).selectpicker();
                }

                // === Cập nhật Order Summary ===
                let selectedCountryKey = null;
                let selectedPackage = 10;
                let period = 1;

                const packageSelect = detailOrderDCIPV6Body.querySelector('.package');
                const periodSelect = detailOrderDCIPV6Body.querySelector('.timePeriod');

                proxyLocation?.addEventListener('change', function() {
                    selectedCountryKey = this.value;
                    detailSummaryCard.style.display = 'none';
                    updateOrderSummaryDCIPV6(service, selectedCountryKey, selectedPackage, period);
                });

                packageSelect?.addEventListener('change', function() {
                    selectedPackage = this.value;
                    updateOrderSummaryDCIPV6(service, selectedCountryKey, selectedPackage, period);
                });

                periodSelect?.addEventListener('change', function() {
                    period = parseInt(this.value) || 1;
                    updateOrderSummaryDCIPV6(service, selectedCountryKey, selectedPackage, period);
                });
                //Nghe sự kiện thay đổi để update Order Summary=================================
                function updateOrderSummaryDCIPV6(service, selectedCountryKey, selectedPackage, period) {
                    const summaryBody = detailSummaryCard.querySelector('.card-body-order-summary');
                    if (!summaryBody) return;

                    summaryBody.innerHTML = `<div class="p-3 text-center text-muted">Đang tính toán...</div>`;
                    detailSummaryCard.style.display = 'block';

                    $.ajax({
                        url: "{{ route('proxyResidential.proxyGetPrice') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            service_id: service.id,
                            country: selectedCountryKey,
                            package: selectedPackage,
                            months: period
                        },
                        success: function (res) {
                            if (res.success) {
                                summaryBody.innerHTML = `
                                    <h3 class="page-title mb-3">Đơn hàng</h3>
                                    <div class="proxy-card p-3 mb-4">
                                        <ul class="list-unstyled lh-lg">
                                            <li><strong>Dịch vụ:</strong> ${service.label}</li>
                                            <li><strong>Quốc gia:</strong> ${selectedCountryKey || 'N/A'}</li>
                                            <li><strong>Giá mỗi IP:</strong> ${vnd(parseFloat(res.unitPriceAfterDiscount > 0 ? res.unitPriceAfterDiscount*rate.VND : res.unitPrice*rate.VND).toFixed(2))}</li>
                                            <li><strong>Gói IP:</strong> ${selectedPackage} IPs</li>
                                            <li><strong>Thời gian thuê:</strong> ${period} tháng</li>
                                            <li><hr></li>
                                            <li><strong>Giá:</strong> ${vnd(parseFloat(res.priceNoDiscounts*rate.VND).toFixed(2))}</li>
                                            <li><strong>Giảm giá:</strong> -${vnd(parseFloat(res.discountAmount*rate.VND).toFixed(2))} (${res.discount}%)</li>
                                        </ul>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold fs-5">Tổng</span>
                                            <div class="col-md-2 text-center">
                                                <div class="proxy-price js-total">${vnd(parseFloat(res.finalPrice*rate.VND).toFixed(2))}</div>
                                                @if (auth()->check())
                                                    <button class="btn btn-buy mt-2 js-buy"
                                                        data-baseamount="${res.finalPrice}"
                                                        data-service_id='${service.id}'
                                                        data-country="${selectedCountryKey}"
                                                        data-package="${selectedPackage}"
                                                        data-months="${period}">Mua hàng</button>
                                                @else
                                                    <a href="{{route('auth.login')}}" class="btn btn-buy mt-2 js-buy">Đăng nhập</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                `;
                            } else {
                                summaryBody.innerHTML = `<div class="alert alert-danger">Error: ${res.error || 'Failed to calculate price'}</div>`;
                            }
                        },
                        error: function () {
                            summaryBody.innerHTML = `<div class="alert alert-danger">Cannot connect to pricing API.</div>`;
                        }
                    });
                }
            }

            function renderCardRotating(service,serviceMetadata) {
                const detailOrderBody = detailOrderCard.querySelector('.card-body-service-order-block');
                if (!detailOrderBody) return;

                // Xóa phần order cũ
                clearOrderBlock();

                // Form nhập Bandwidth
                detailOrderBody.innerHTML = `
                    <div class="proxy-static-list proxy-static">
                        <div class="proxy-card p-3 mb-4">
                            <div class="row align-items-center">
                                <label class="col-sm-6 col-form-label mb-0">Băng thông (GB)</label>
                                <div class="col-sm-6">
                                    <input id="rotatingBandwidth" type="number" min="1" max="10000" class="form-control" value="5">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                detailOrderCard.style.display = 'block';

                // === Cập nhật Order Summary ===
                const summaryBody = detailSummaryCard.querySelector('.card-body-order-summary');
                if (!summaryBody) return;

                // Lấy đơn giá từ service
                let pricePer = 0;
                const discountPercent = serviceMetadata.specialOffer?.discount || 0;
                let price = 0;
                let priceDiscount = 0;
                const bwInput = detailOrderBody.querySelector('#rotatingBandwidth');

                // Hàm cập nhật Order Summary
                function updateOrderSummaryRotating() {
                    const bw = parseInt(bwInput.value, 10) || 1;

                    pricePer = serviceMetadata.price || 0;
                    price = pricePer * bw;
                    priceDiscount = price - (price * discountPercent / 100);

                    summaryBody.innerHTML = `<div class="p-3 text-center text-muted">Đang tính toán...</div>`;
                    detailSummaryCard.style.display = 'block';

                    $.ajax({
                        url: "{{ route('proxyResidential.proxyGetPrice') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            service_id: service.id,
                            traffic: bw
                        },
                        success: function (res) {
                            if (res.success) {
                                summaryBody.innerHTML = `
                                <h3 class="page-title mb-3">Đơn hàng</h3>
                                <div class="proxy-card p-3 mb-4">
                                    <ul class="list-unstyled lh-lg mb-3">
                                        <li><strong>Dịch vụ:</strong> ${service.label}</li>
                                        <li><strong>Băng thông:</strong> ${bw} GB</li>
                                        <li><strong>Giá mỗi GB:</strong> ${vnd(parseFloat(res.unitPrice*rate.VND).toFixed(2))}</li>
                                        <li><hr></li>
                                        <li><strong>Giá:</strong> ${vnd(parseFloat(res.priceNoDiscounts*rate.VND).toFixed(2))}</li>
                                        <li><strong>Giảm giá:</strong> ${vnd(parseFloat(res.discountAmount*rate.VND).toFixed(2))} (${res.discount}%)</li>
                                    </ul>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold fs-5">Tổng</span>
                                        <div class="col-md-2 text-center">
                                            <div class="proxy-price js-total">${vnd(parseFloat(res.finalPrice*rate.VND).toFixed(2))}</div>
                                            @if (auth()->check())
                                                <button class="btn btn-buy mt-2 js-buy"
                                                data-baseamount="${res.finalPrice}"
                                                data-service_id='${service.id}'
                                                data-traffic='${bw}'
                                                >Mua hàng</button>
                                            @else
                                            <a href="{{route('auth.login')}}" class="btn btn-buy mt-2 js-buy">Đăng nhập</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>`;
                            } else {
                                summaryBody.innerHTML = `<div class="alert alert-danger">Error: ${res.error || 'Failed to calculate price'}</div>`;
                            }
                        },
                        error: function () {
                            summaryBody.innerHTML = `<div class="alert alert-danger">Cannot connect to pricing API.</div>`;
                        }
                    });
                }

                // Render mặc định
                updateOrderSummaryRotating();

                // Lắng nghe thay đổi Bandwidth
                bwInput.addEventListener('input', () => {
                    let val = parseInt(bwInput.value, 10);
                    if (isNaN(val) || val < 1) val = 1;
                    if (val > 10000) val = 10000;
                    bwInput.value = val;
                    updateOrderSummaryRotating();
                });
            }
        });
    </script>
@stop


