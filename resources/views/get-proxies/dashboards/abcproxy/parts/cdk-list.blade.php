@forelse ($list as $item)
    @php
        $statusText = '';
        $statusClass = '';
        if ($item['status'] === 1) {
            $statusText = __('Chưa sử dụng');
            $statusClass = 'badge bg-success-lt';
        } elseif ($item['status'] === -1) {
            $statusText = __('Đã sử dụng');
            $statusClass = 'badge bg-secondary-lt';
        } else {
            $statusText = __('Vô hiệu');
            $statusClass = 'badge bg-danger-lt';
        }

        $createTime = '—';
        if (!empty($item['create_time'])) {
            $createTime = date('d/m/Y H:i:s', $item['create_time']);
        }

        $cdkCode = $item['code'] ?? ($item['cdk'] ?? '—');
        $resourceNum = $item['num'] ?? '—';
        $resourceName = $item['name'] ?? '';

        $resourceType = ($item['resource_type'] ?? 0) == 1 ? 'Socks5' : 'Residential';
        $unit = ($item['resource_type'] ?? 0) == 1 ? __('Hạt') : 'GB';
    @endphp
    <tr>
        <td class="fw-bold"><code class="text-primary">{{ $cdkCode }}</code></td>
        <td>
            <div>{{ $resourceNum }} {{ $unit }}</div>
            <div class="small text-muted text-truncate" style="max-width: 200px;" title="{{ $resourceName }}">
                {{ $resourceName }}</div>
        </td>
        <td><span class="badge badge-outline text-blue">{{ $resourceType }}</span></td>
        <td>{{ $createTime }}</td>
        <td><span class="{{ $statusClass }}">{{ $statusText }}</span></td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-4 text-muted">{{ __('Chưa có CDK nào.') }}</td>
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
