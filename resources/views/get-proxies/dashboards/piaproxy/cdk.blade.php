<div class="gp-tab-panel" id="tab-cdk" data-route-list="{{ route('getProxies.piaproxy.cdk.list') }}"
    data-route-exchange="{{ route('getProxies.piaproxy.cdk.exchange') }}"
    data-route-generate="{{ route('getProxies.piaproxy.cdk.generate') }}">
    <div class="gp-section-card">
        <div class="gp-section-header">
            <div class="gp-section-title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-key"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0" /><path d="M15 9h.01" /></svg> {{ __('Quản lý CDK') }}</div>
        </div>
        <div class="gp-section-body">
            <ul class="nav nav-pills mb-4" id="cdkSubTabs" role="tablist" style="gap: 8px;">
                <li class="nav-item" role="presentation">
                    <button class="btn btn-ghost active" id="redeem-tab" data-bs-toggle="pill"
                        data-bs-target="#panel-redeem" type="button" role="tab">{{ __('Nhập mã CDK') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn btn-ghost" id="generate-tab" data-bs-toggle="pill"
                        data-bs-target="#panel-generate" type="button"
                        role="tab">{{ __('Tạo tài nguyên CDK') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn btn-ghost" id="list-tab" data-bs-toggle="pill" data-bs-target="#panel-list"
                        type="button" role="tab">{{ __('Danh sách CDK') }}</button>
                </li>
            </ul>

            <div class="tab-content" id="cdkSubTabsContent">
                <div class="tab-pane fade show active" id="panel-redeem" role="tabpanel">
                    <div class="p-3 border rounded">
                        <h4 class="mb-2">{{ __('Nhập mã Giftcode') }}</h4>
                        <p class="text-muted mb-3">
                            {{ __('Nhập mã tài nguyên bạn được chia sẻ để cộng vào tài khoản hiện hành.') }}</p>
                        <div class="row align-items-end g-3">
                            <div class="col-12 col-md">
                                <input type="text" id="cdk-code-input" class="form-control"
                                    placeholder="{{ __('Nhập mã CDK tại đây...') }}">
                            </div>
                            <div class="col-12 col-md-auto text-center">
                                <button class="btn btn-primary w-100" id="btnRedeemCdk" style="min-width: 140px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg> {{ __('Nhập') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="panel-generate" role="tabpanel">
                    <div class="p-3 border rounded">
                        <h4 class="mb-2">{{ __('Tạo CDK chia sẻ') }}</h4>
                        <p class="text-muted mb-3">
                            {{ __('Trừ lưu lượng gốc tạo thẻ để chia sẻ cho các tài khoản khác.') }}
                        </p>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('Giá trị lưu lượng truy cập trên mỗi CDK (G)') }}</label>
                                <input type="number" id="gen-cdk-flow" class="form-control" value="1"
                                    min="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('Số lượng cần tạo') }}</label>
                                <input type="number" id="gen-cdk-number" class="form-control" value="1"
                                    min="1">
                            </div>
                        </div>
                        <button class="btn btn-primary mb-2" id="btnGenerateCdk">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-circle-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M9 12h6" /><path d="M12 9v6" /></svg> {{ __('Tạo CDK') }}
                        </button>

                        <div class="mt-4">
                            <label
                                class="form-label fw-bold">{{ __('KẾT QUẢ XUẤT CDK (SAO CHÉP ĐỂ LƯU TRỮ)') }}</label>
                            <textarea id="gen-cdk-result" class="form-control mb-2" rows="5" readonly
                                placeholder="{{ __('Các thẻ vừa tạo sẽ hiển thị tại đây...') }}"></textarea>
                            <button class="btn btn-outline-secondary btn-sm" id="btnCopyCdk">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667l0 -8.666" /><path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" /></svg> {{ __('Sao chép kết quả') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade text-center" id="panel-list" role="tabpanel">
                    {{ __('Không hỗ trợ') }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            const container = $('#tab-cdk');
            const routes = {
                list: container.data('route-list'),
                exchange: container.data('route-exchange'),
                generate: container.data('route-generate')
            };

            $('#btnRedeemCdk').on('click', function() {
                const btn = $(this);
                const code = $('#cdk-code-input').val().trim();

                if (!code) {
                    msgError(window.__trans('Vui lòng nhập mã CDK.'));
                    return;
                }

                btn.addClass('spinning').prop('disabled', true);

                AjaxLibrary.post(routes.exchange, {
                    _token: token,
                    provider: 'piaproxy',
                    cdk: code
                }, function(res) {
                    if (res.success) {
                        msgSuccess(window.__trans('Nạp CDK thành công!'));
                        $('#cdk-code-input').val('');
                    } else {
                        msgError(res.message || window.__trans('Nạp CDK thất bại.'));
                    }
                }, null, () => btn.removeClass('spinning').prop('disabled', false));
            });

            $('#btnGenerateCdk').on('click', function() {
                const btn = $(this);
                const flow = $('#gen-cdk-flow').val();
                const number = $('#gen-cdk-number').val();

                btn.addClass('spinning').prop('disabled', true);

                AjaxLibrary.post(routes.generate, {
                    _token: token,
                    provider: 'piaproxy',
                    flow: flow,
                    number: number
                }, function(res) {
                    if (res.success) {
                        msgSuccess(window.__trans('Tạo CDK thành công!'));
                        let codes = [];
                        if (Array.isArray(res.data)) {
                            codes = res.data.map(i => i.cdk || i);
                        } else if (res.data.cdk) {
                            codes = [res.data.cdk];
                        }
                        $('#gen-cdk-result').val(codes.join('\n'));
                    } else {
                        msgError(res.message || window.__trans('Tạo CDK thất bại.'));
                    }
                }, null, () => btn.removeClass('spinning').prop('disabled', false));
            });

            $('#btnCopyCdk').on('click', function() {
                const text = $('#gen-cdk-result').val();
                if (!text) return;

                navigator.clipboard.writeText(text).then(() => {
                    msgSuccess(window.__trans('Đã sao chép vào bộ nhớ tạm.'));
                });
            });
        });
    </script>
@endpush
