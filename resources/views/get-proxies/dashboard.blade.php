@extends('public.layouts.master')

@section('content')
    <div class="container get-proxies-page">

        <div class="mb-4">
            <h2 class="fw-bold mb-1">{{ __('Bảng điều khiển Proxy') }}</h2>
            <p class="text-muted mb-0">{{ __('Kết nối và quản lý tài khoản nhà cung cấp proxy') }}
            </p>
        </div>

        <div class="gp-header-wrapper">
            <div class="gp-tabs-container">
                @include('get-proxies.partials.tabs', ['activeProvider' => $provider])
            </div>

            <div class="gp-provider-bar">
                <a href="{{ route('getProxies.' . $providerSlug . '.logout') }}" class="gp-logout-btn">
                    <i class="ti ti-plug-off"></i>{{ __('Ngắt kết nối') }}
                </a>
            </div>
        </div>

        @includeIf('get-proxies.dashboards.' . $providerSlug)

    </div>
@endsection

@push('css')
    <style>
        .get-proxies-page {
            padding-top: 130px;
            padding-bottom: 50px;
        }

        .gp-header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 25px;
        }

        .gp-tabs-container {
            flex: 1;
        }

        .gp-provider-bar {
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .get-proxies-page {
                padding-top: 110px;
            }

            .gp-header-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .gp-logout-btn {
                width: auto;
                display: inline-flex;
                justify-content: center;
                padding: 6px 16px !important;
                background: #fff5f5 !important;
                border: none !important;
                color: #ef4444 !important;
                font-weight: 600 !important;
                border-radius: 8px !important;
                font-size: 13px !important;
            }
        }

        .gp-provider-identity {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .gp-provider-logo {
            width: 32px;
            height: 32px;
            object-fit: contain;
            border-radius: 6px;
        }

        .gp-provider-name {
            font-weight: 700;
            font-size: 16px;
            color: #1a1f36;
        }

        .gp-logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none !important;
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all .18s;
            color: #ef4444;
            border-color: #fca5a5;
            background: #fff5f5;
        }

        .gp-tabs {
            display: flex;
            gap: 4px;
            border: 1px solid #e5e7eb;
            border-bottom-width: 2px;
            margin-bottom: 15px;
            border-radius: 8px 8px 0 0;
            overflow-x: auto;
            flex-wrap: nowrap;
            background: #fff;
            -webkit-overflow-scrolling: touch;
        }

        .gp-tabs::-webkit-scrollbar {
            display: none;
        }

        .gp-tab {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 12px 18px;
            border: none;
            background: transparent;
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            cursor: pointer;
            white-space: nowrap;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all .18s;
        }

        .gp-tab:hover {
            color: #2563eb;
        }

        .gp-tab.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
            font-weight: 600;
        }

        .gp-tab-panel {
            display: none;
        }

        .gp-tab-panel.active {
            display: block;
        }

        .gp-refresh-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border: 1.5px solid #2563eb;
            background: #fff;
            color: #2563eb;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: all .18s;
        }

        .gp-refresh-btn:hover {
            background: #eff6ff;
        }

        .gp-refresh-btn.spinning i {
            animation: spin .8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .gp-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: 1.5px solid #e5e7eb;
            background: #f9fafb;
            color: #4b5563;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: all .18s;
            text-decoration: none !important;
        }

        .gp-btn-secondary:hover {
            background: #f3f4f6;
            color: #2563eb;
            border-color: #d1d5db;
        }

        .gp-btn-secondary i {
            font-size: 16px;
        }

        .gp-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            border: none;
            background: #007bff;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all .18s;
            text-decoration: none !important;
        }

        .gp-btn-primary:hover {
            background: #0069d9;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }

        .gp-btn-primary i {
            font-size: 16px;
        }

        .gp-stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        @media (max-width: 900px) {
            .gp-stats-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .gp-stat-value {
                font-size: 18px !important;
            }
        }

        @media (max-width: 540px) {
            .gp-stats-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .gp-stat-card {
                padding: 15px 12px;
            }

            .gp-stat-value {
                font-size: 18px;
            }

            .gp-stat-label {
                font-size: 11px;
            }

            .get-proxies-page {
                padding-top: 110px;
            }
        }

        .gp-stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px 20px 16px;
            position: relative;
        }

        .gp-stat-card.gp-stat-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-color: transparent;
            color: #fff;
        }

        .gp-stat-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .gp-stat-primary .gp-stat-label {
            color: rgba(255, 255, 255, .8);
        }

        .gp-stat-label i {
            font-size: 18px;
        }

        .gp-stat-icon-blue {
            color: #2563eb;
        }

        .gp-stat-value {
            font-size: 26px;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
            margin-bottom: 6px;
        }

        .gp-stat-primary .gp-stat-value {
            color: #fff;
        }

        .gp-stat-sub {
            font-size: 12px;
            color: #9ca3af;
        }

        .gp-stat-primary .gp-stat-sub {
            color: rgba(255, 255, 255, .7);
        }

        .gp-section-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .gp-section-header {
            background: #f9fafb;
            padding: 16px 24px;
            border-bottom: 1px solid #f3f4f6;
        }

        .gp-section-title {
            font-size: 15px;
            font-weight: 600;
            color: #1a1f36;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .gp-section-body {
            padding: 16px 24px;
        }

        .gp-section-title i {
            color: #6b7280;
        }

        .gp-info-grid {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .gp-info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 40px;
            padding: 12px 0;
        }

        .gp-info-row:first-child {
            border-top: none;
        }

        @media (max-width: 600px) {
            .gp-info-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .gp-section-body {
                padding: 10px 18px;
            }
        }

        .gp-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .gp-info-label {
            font-size: 13.5px;
            color: #6b7280;
            white-space: nowrap;
            font-weight: 500;
        }

        .gp-info-value {
            font-size: 13.5px;
            color: #111827;
            font-weight: 500;
            text-align: right;
        }

        .gp-empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .gp-empty-state i {
            font-size: 36px;
            margin-bottom: 12px;
            display: block;
        }

        .gp-empty-state p {
            font-size: 14px;
            margin: 0;
        }

        .gp-table-wrapper {
            overflow-x: auto;
        }

        .gp-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .gp-table thead {
            background: #f9fafb;
        }

        .gp-table th {

            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #f3f4f6;
            text-align: left;
        }

        .gp-table td {
            padding: 16px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .gp-table tr:last-child td {
            border-bottom: none;
        }

        .gp-table tr:hover td {
            background: #fcfcfd;
        }

        .gp-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 9999px;
        }

        .gp-badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .gp-table-actions {
            display: flex;
            gap: 12px;
            color: #9ca3af;
        }

        .gp-table-actions i {
            font-size: 18px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .gp-table-actions i:hover {
            color: #4b5563;
        }

        .gp-table-actions .ti-trash:hover {
            color: #ef4444;
        }

        .gp-password-field {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .gp-password-field i {
            cursor: pointer;
            color: #9ca3af;
        }

        @media (max-width: 768px) {
            .gp-sub-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 12px !important;
                margin-top: 10px !important;
            }

            .gp-sub-header .d-flex.gap-2 {
                width: 100% !important;
            }

            .gp-sub-header button {
                flex: 1;
                font-size: 11.5px !important;
                padding: 8px 10px !important;
            }

            .gp-table-wrapper {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                margin: 0 -15px;
                padding: 0 15px;
            }

            .gp-table {
                min-width: 600px;
            }

            .gp-table th,
            .gp-table td {
                white-space: nowrap !important;
            }

            .gp-table-actions {
                justify-content: flex-end !important;
                width: 100%;
            }
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('public/core/assets/js/lib-ajax.js') }}"></script>
    <script>
        $(document).ready(function() {

            const loadedTabs = new Set();

            $('.gp-tab').on('click', function() {
                const tabId = $(this).data('tab');

                $('.gp-tab').removeClass('active');
                $('.gp-tab-panel').removeClass('active');

                $(this).addClass('active');
                $('#tab-' + tabId).addClass('active');

                if (!loadedTabs.has(tabId)) {
                    loadedTabs.add(tabId);
                    window.dispatchEvent(new CustomEvent('tab-init-' + tabId));
                }
            });

            $('#btnRefresh').on('click', function() {

                const btn = $(this);

                btn.addClass('spinning');

                AjaxLibrary.post(

                    btn.data('route'), {
                        _token: token,
                        provider: btn.data('provider')
                    },

                    (res) => {
                        if (res.success && res.data) {
                            $.each(res.data, (key, val) => {
                                const slug = key.replace(/_/g, '-');
                                $(`#stat-${slug}, #info-${slug}`).text(val);
                            });

                            window.dispatchEvent(new CustomEvent('proxy-data-updated', { detail: res.data }));
                        }
                    }, null, () => btn.removeClass('spinning'));
            });

            const initialTab = $('.gp-tab.active').data('tab');

            if (initialTab) {

                loadedTabs.add(initialTab);

                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('tab-init-' + initialTab));
                }, 0);
            }
        });
    </script>
@endpush
