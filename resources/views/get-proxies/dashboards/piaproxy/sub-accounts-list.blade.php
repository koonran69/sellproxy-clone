@forelse ($list as $index => $item)
    @php
        $divisor = 1024 ** 3;
        // Tính STT: (Trang hiện tại - 1) * 20 + index + 1
        $stt = (($page ?? 1) - 1) * ($size ?? 20) + $index + 1;
        // Lưu lượng Residential
        $resUsed = (isset($item['flow_used']) && $item['flow_used'] > 0) ? number_format($item['flow_used']/$divisor, 2).' GB' : '0';
        $resLimit = (isset($item['flow_limit']) && $item['flow_limit'] > 0) ? number_format($item['flow_limit'], 2).' GB' : '0';

        // Lưu lượng DC
        $dcUsed = (isset($item['data_center_used']) && $item['data_center_used'] > 0) ? number_format($item['data_center_used']/$divisor, 2).' GB' : '0';
        $dcLimit = (isset($item['data_center_limit']) && $item['data_center_limit'] > 0) ? number_format($item['data_center_limit'], 2).' GB' : '0';

        // Trạng thái
        $statusActive = ($item['status'] ?? 0) == 1;
        $statusBadge = $statusActive
            ? '<span class="badge bg-green-lt" style="padding: 5px 12px; border-radius: 4px;">' . __('Khả dụng') . '</span>'
            : '<span class="badge bg-red-lt" style="padding: 5px 12px; border-radius: 4px;">' . __('Khóa') . '</span>';

        $statusIcon = $statusActive ? 'ti-toggle-right text-primary' : 'ti-toggle-left text-muted';
        $nextStatus = $statusActive ? 0 : 1;
    @endphp
    <tr>
        <td>{{ $index + 1 }}</td>
        <td class="fw-bold text-dark">{{ $item['username'] ?? '—' }}</td>
        <td>
            <div class="gp-password-field">
                <span class="sub-pass-val"
                      data-id="{{ $item['id'] ?? '' }}"
                      data-real-pass="{{ $item['plaintext_password'] ?? $item['password'] ?? '' }}">••••••••</span>
                <i class="ti ti-eye btn-view-pass" style="cursor: pointer; margin-left: 8px;"></i>
            </div>
        </td>
        <td class="text-nowrap">
            <span class="fw-medium">{{ $resUsed }}</span>
            <span class="fw-medium">/ {{ $resLimit }}</span>
        </td>
        <td class="text-nowrap">
            <span class="fw-medium">{{ $dcUsed }}</span>
            <span class="fw-medium">/ {{ $dcLimit }}</span>
        </td>
        <td>{!! $statusBadge !!}</td>
        <td class="text-muted small">{{ $item['remark'] ?: '—' }}</td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-5 text-muted">
            <i class="ti ti-database-off d-block mb-2" style="font-size: 32px;"></i>
            {{ __('Chưa có tài khoản phụ nào.') }}
        </td>
    </tr>
@endforelse
