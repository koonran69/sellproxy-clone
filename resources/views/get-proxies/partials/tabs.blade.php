<div class="provider-tabs">
    @foreach ($providers as $key => $p)
        <a href="{{ route('getProxies.show', ['slug' => $p['slug']]) }}"
            class="provider-tab-btn {{ $activeProvider == $key ? 'active' : '' }} {{ !empty($p['is_connected']) ? 'connected' : '' }} {{ !empty($p['is_connected']) ? 'connected' : '' }}">
            <img src="{{ $p['logo_tab'] }}" alt="{{ $p['label'] }}" class="provider-tab-icon">
            <span class="provider-name">{{ __($p['label']) }}</span>
            @if ($activeProvider == $key)
                <span class="active-badge">
                    <i class="ti ti-check"></i>
                </span>
            @endif
        </a>
    @endforeach
</div>

@push('css')
    <style>
        .get-proxies-page .provider-tab-btn.disable{
            opacity: .6;
            pointer-events: none;
        }

        .get-proxies-page .provider-tabs {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .get-proxies-page .provider-tab-icon {
            width: 18px;
            height: 18px;
            object-fit: contain;
            border-radius: 4px;
        }

        .get-proxies-page .provider-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 30px;
            font-weight: 600;
            color: #4b5563;
            text-decoration: none !important;
            transition: all 0.2s ease;
            position: relative;
        }

        .get-proxies-page .provider-tab-btn:hover {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .get-proxies-page .provider-tab-btn.active {
            border-color: #3b82f6;
            background: #fff;
            color: #2563eb;
            box-shadow: 0 0 0 1px #3b82f6;
        }

        .get-proxies-page .active-badge {
            position: absolute;
            top: -6px;
            right: -2px;
            background: #3b82f6;
            color: #fff;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .get-proxies-page .provider-name {
            font-size: 13.5px;
        }

        @media (max-width: 768px) {
            .get-proxies-page .provider-tabs {
                gap: 8px;
                /*margin-bottom: 0;*/
            }

            .get-proxies-page .provider-tab-btn {
                padding: 6px 14px;
            }

            .get-proxies-page .provider-name {
                font-size: 13px;
            }
        }
    </style>
@endpush
