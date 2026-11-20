@if($proxies->isEmpty())
    <div class="d-flex align-items-center mb-2 gap-2">
        <p class="text-center text-muted">@lang('Không có proxy nào. Bấm refresh để cào proxy của đơn về')</p>
        <button class="btn btn-icon btn-primary craw-proxy-btn" data-url="{{ route('admin.homeproxy.handleSyncProxiesForOrder', ['partner_order_id' => $order->partner_order_id]) }}" title="Crawl proxies">
            <i class="ti ti-refresh"></i>
        </button>
    </div>
@else
    @foreach ($proxies as $proxy)
        @php
            $isKeyRotate = isset($order) && $order->type === 'key-rotate';
            // Lấy token nếu có sẵn, nếu không thì để trống hoặc hiển thị chữ "Chưa có token"
            $tokenValue = $proxy->token ?? '';
        @endphp

        @if ($isKeyRotate)
            <div class="d-flex align-items-center mb-2 gap-2">
                <input type="text" class="form-control form-control-sm text-truncate js-token-input"
                       value="{{ $tokenValue }}" placeholder="@lang('Chưa có token')" readonly style="max-width: 220px;">

                <button class="btn btn-icon copy-text" data-text="{{ $tokenValue }}" title="Copy Token" {{ empty($tokenValue) ? 'disabled' : '' }}>
                    <i class="ti ti-copy"></i>
                </button>

                <button class="btn btn-icon btn-primary generate-token-btn"
                        data-id="{{ $proxy->id }}" title="Generate Token">
                    <i class="ti ti-refresh"></i>
                </button>
            </div>
        @endif
        <div class="d-flex align-items-center mb-2 gap-2">
            {{ str($proxy->ip.':'.$proxy->port.':'.$proxy->username.':'.$proxy->password)->limit(20) }}
            <button class="btn btn-icon copy-text" data-text="{{ $proxy->ip.':'.$proxy->port.':'.$proxy->username.':'.$proxy->password }}">
                <i class="ti ti-copy"></i>
            </button>
        </div>


        <p class="mb-1">
            @lang('Hết hạn'): {{ format_datetime($proxy->expired_at) }} - @lang('Trạng thái'): {{$proxy->status_name}}
        </p>
    @endforeach
@endif

