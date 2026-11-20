@forelse ($list as $index => $item)
    @php
        $limitGB = isset($item['limit_flow']) ? number_format($item['limit_flow'] / (1000 * 1000 * 1000), 2) : '0.00';
        $statusActive = ($item['state'] ?? 0) == 1;
        $statusBadge = $statusActive
            ? '<span class="badge bg-green-lt">' . __('Khả dụng') . '</span>'
            : '<span class="badge bg-orange-lt">' . __('Không khả dụng') . '</span>';
        $statusIcon = $statusActive ? 'ti-toggle-right text-primary' : 'ti-toggle-left text-muted';
        $nextStatus = $statusActive ? 2 : 1;
    @endphp
    <tr>
        <td>{{ $index + 1 }}</td>
        <td class="fw-bold">{{ $item['account'] ?? '—' }}</td>
        <td>
            <div class="gp-password-field">
                <span class="sub-pass-val" data-id="{{ $item['id'] ?? '' }}"
                    data-real-pass="{{ $item['password'] ?? '' }}">••••••••</span>
                <i class="ti ti-eye btn-view-pass" style="cursor: pointer;"></i>
            </div>
        </td>
        <td>{{ $limitGB }} GB</td>
        <td>{!! $statusBadge !!}</td>
        <td style="text-align: right;">
            <div class="gp-table-actions justify-content-end">
                <i class="ti ti-key btn-edit-sub" title="{{ __('Đổi mật khẩu') }}"
                    data-account="{{ $item['account'] ?? '' }}" data-state="{{ $item['state'] ?? '' }}"></i>
                <i class="ti {{ $statusIcon }} btn-toggle-sub" style="font-size: 20px; cursor: pointer;"
                    title="{{ __('Bật/Tắt') }}" data-id="{{ $item['id'] ?? '' }}"
                    data-status="{{ $nextStatus }}"></i>
                <i class="ti ti-trash text-danger btn-delete-sub" title="{{ __('Xóa') }}"
                    data-id="{{ $item['id'] ?? '' }}" data-status="{{ $item['state'] ?? 0 }}"></i>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-4 text-muted">{{ __('Chưa có tài khoản phụ nào.') }}</td>
    </tr>
@endforelse
