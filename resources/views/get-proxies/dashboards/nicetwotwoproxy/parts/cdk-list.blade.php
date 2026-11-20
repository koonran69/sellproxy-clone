@forelse ($list as $item)
    @php
        $status = $item['status'] ?? 0;
        $statusText = __('Vô hiệu');
        $statusClass = 'badge bg-danger-lt';

        if ($status == 1) {
            $statusText = __('Chưa sử dụng');
            $statusClass = 'badge bg-success-lt';
        } elseif ($status == 2) {
            $statusText = __('Đã sử dụng');
            $statusClass = 'badge bg-secondary-lt';
        }

        // Mapping Thời gian tạo (create_time từ API là timestamp)
        $createTime = '—';
        if (!empty($item['create_time'])) {
            $createTime = date('d/m/Y H:i:s', $item['create_time']);
        }

        // 922 dùng 'cdkey' thay vì 'code' và 'number' thay vì 'num'
        $cdkCode = $item['cdkey'] ?? '—';
        $resourceNum = $item['number'] ?? '0';

        // Xác định loại tài nguyên: 922 dùng 'ex_type'
        // ex_type: 'isp' thường tương ứng với Residential Traffic (GB)
        $exType = strtolower($item['ex_type'] ?? '');
        // Lấy giá trị định danh loại gói từ API (thường là 'flow', 'dynamic_isp', 'static-7', ...)
        $cateCode = strtolower($item['code'] ?? $item['cate'] ?? '');
        $exType = strtolower($item['ex_type'] ?? '');

        // Khởi tạo giá trị mặc định
        $resourceType = 'Socks5';
        $unit = __('Hạt');

        // Mapping dựa trên các giá trị bạn có trong <select> lúc tạo
        if ($cateCode === 'flow' || $exType === 'flow') {
            $resourceType = 'Residential Traffic';
            $unit = 'GB';
        } elseif ($cateCode === 'dynamic_isp' || $exType === 'isp') {
            // Dữ liệu mẫu của bạn cho thấy 'isp' là loại Rotating/Dynamic
            $resourceType = 'Rotating ISP';
            $unit = 'GB';
        } elseif (str_contains($cateCode, 'static')) {
            $resourceType = 'Static Residential';
            $unit = __('IP');
        }

        // Người dùng đã nạp mã (bind_username)
        $bindUser = $item['bind_username'] ?? '';
    @endphp
    <tr>
        <td class="fw-bold">
            <code class="text-primary" style="font-size: 0.85rem;">{{ $cdkCode }}</code>
            @if($bindUser)
                <div class="small text-muted mt-1">
                    <i class="ti ti-user-check"></i> {{ __('Nạp bởi') }}: <span class="text-dark">{{ $bindUser }}</span>
                </div>
            @endif
        </td>
        <td>
            <div class="fw-medium text-dark">{{ number_format($resourceNum) }} {{ $unit }}</div>
            <div class="small text-muted">
                {{ __('Nguồn') }}: {{ strtoupper($item['code'] ?? $item['cate'] ?? 'N/A') }}
            </div>
        </td>
        <td>
            <span class="badge badge-outline text-blue">{{ $resourceType }}</span>
            @if(!empty($item['country']))
                <div class="small text-muted mt-1"><i class="ti ti-world"></i> {{ strtoupper($item['country']) }}</div>
            @endif
        </td>
        <td>
            <div style="font-size: 0.85rem;">{{ $createTime }}</div>
        </td>
        <td>
            <span class="{{ $statusClass }}">{{ $statusText }}</span>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-4 text-muted">
            <div class="mb-2"><i class="ti ti-database-off fs-1"></i></div>
            {{ __('Chưa có CDK nào trong danh sách.') }}
        </td>
    </tr>
@endforelse

@if ($list->hasPages())
    <tr class="pagination-row">
        <td colspan="5">
            <div class="mt-3 d-flex justify-content-center cdk-pagination-wrapper">
                {!! $list->links('public.pagination') !!}
            </div>
        </td>
    </tr>
@endif
