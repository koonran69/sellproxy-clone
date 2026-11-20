@forelse ($list as $index => $item)
    @php
        $isActive = ($item['status'] ?? 0) === 1;
        $isLocked = ($item['lock'] ?? 0) === 1;
        $statusClass = $isActive ? 'badge bg-success-lt' : 'badge bg-secondary-lt';
        $statusText = $isActive ? __('Khả dụng') : __('Không khả dụng');
        $ip = $item['mark_ip'] ?? '—';
        $lockStatus = $isLocked ? 0 : 1;
        $lockIcon = $isLocked ? 'ti-lock-open' : 'ti-lock';
        $lockTitle = $isLocked ? __('Bỏ khóa') : __('Khóa');
    @endphp
    <tr>
        <td class="text-muted">{{ $loop->iteration + ($list->currentPage() - 1) * $list->perPage() }}</td>
        <td class="fw-semibold">{{ $ip }}</td>
        <td>
            <div class="d-flex gap-2">
                <span class="{{ $statusClass }}">{{ $statusText }}</span>
                @if ($isLocked)
                    <span class="badge bg-orange-lt ms-1"><i class="ti ti-lock me-1"></i>{{ __('Đã khóa') }}</span>
                @endif
            </div>
        </td>
        <td>
            <div class="d-flex gap-2">
                <button class="btn-icon-plain text-muted btn-lock-ip" data-ip="{{ $ip }}"
                    data-status="{{ $lockStatus }}" title="{{ $lockTitle }}">
                    <i class="ti {{ $lockIcon }}"></i>
                </button>
                <button class="btn-icon-plain text-danger btn-delete-ip" data-ip="{{ $ip }}"
                    title="{{ __('Xóa') }}">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center py-4 text-muted">{{ __('Chưa có IP nào trong whitelist.') }}</td>
    </tr>
@endforelse

@if ($list->hasPages())
    <tr class="pagination-row">
        <td colspan="4">
            <div class="mt-3 d-flex justify-content-center whitelist-pagination-wrapper">
                {!! $list->links('public.pagination') !!}
            </div>
        </td>
    </tr>
@endif
