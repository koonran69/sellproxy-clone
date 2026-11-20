@forelse ($list as $index => $item)
    @php
        $limitGB = isset($item['traffic_limit']) ? number_format($item['traffic_limit']) : '0';
        $statusActive = ($item['status'] ?? 0) == 1;
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
        <td>{{ $limitGB }} {{$item['traffic_unit']}}</td>
        <td>{{ $item['traffic_use'] }} {{$item['traffic_unit']}}</td>
        <td>{!! $statusBadge !!}</td>
        <td style="text-align: right;">
            <div class="gp-table-actions justify-content-end">
                <i class="ti ti-pencil text-primary btn-edit-sub" title="{{ __('Đổi mật khẩu') }}"
                    data-subaccount="{{ json_encode($item) }}"></i>
                <i class="ti ti-trash text-danger btn-delete-sub" title="{{ __('Xóa') }}"
                   data-subaccount="{{ json_encode($item) }}"></i>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-4 text-muted">{{ __('Chưa có tài khoản phụ nào.') }}</td>
    </tr>
@endforelse
