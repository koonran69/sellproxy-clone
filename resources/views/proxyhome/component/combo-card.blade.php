{{-- Thêm class chia cột để không bị rớt dòng --}}
<div class="col-md-6 col-lg-4">
    <div class="combo-card border rounded-3 p-4 bg-white shadow-sm" data-type-unit="{{$item['category']['type_unit']}}" data-provider="{{$item['provider']}}" data-price="{{ $item['price'] }}" data-rules="{{ json_encode($item['discount_rules']) }}" data-type="{{ $item['slug'] }}">

        <h5 class="text-center fw-bold mb-3">{{ $item['name'] }}</h5>

        <div class="border border-danger-subtle rounded-3 p-3 mb-4 position-relative">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold fs-5 text-primary">
                    <img src="{{ asset($item['logo']) }}" alt="{{$item['name']}}" width="{{$item['width_flag']}}">
                </span>
                <h4 class="text-danger fw-bold mb-0">
                    {{ number_format($item['price']) }} đ <small class="text-dark fs-6">/{{ $item['category']['unit'] }}</small>
                </h4>
            </div>

            <hr class="text-danger-subtle opacity-50 my-2">

            <div class="promotion-box">
                @if(isset($item['discount_rules']['tiers']))
                    <div class="d-flex flex-column gap-1">
                        @foreach($item['discount_rules']['tiers'] as $tier)
                            <div class="d-flex justify-content-between align-items-center">
                                <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: #fd4336;"><path opacity="0.2" d="M19.5 12V18.75C19.5 18.9489 19.421 19.1397 19.2803 19.2803C19.1397 19.421 18.9489 19.5 18.75 19.5H5.25C5.05109 19.5 4.86032 19.421 4.71967 19.2803C4.57902 19.1397 4.5 18.9489 4.5 18.75V12H19.5Z" fill="currentColor"></path><path d="M20.25 6.74984H16.9613C16.9978 6.71891 17.0353 6.68891 17.0709 6.65609C17.3557 6.40314 17.5851 6.09415 17.745 5.74846C17.9049 5.40276 17.9917 5.02781 18 4.64703C18.0123 4.23048 17.9394 3.8158 17.7856 3.42846C17.6319 3.04112 17.4006 2.68928 17.106 2.39456C16.8113 2.09984 16.4596 1.86845 16.0723 1.71459C15.685 1.56073 15.2703 1.48765 14.8538 1.49984C14.4728 1.50805 14.0977 1.5948 13.7518 1.75466C13.406 1.91453 13.0968 2.14406 12.8438 2.42891C12.4936 2.83474 12.2089 3.29276 12 3.78641C11.7911 3.29276 11.5064 2.83474 11.1562 2.42891C10.9032 2.14406 10.594 1.91453 10.2482 1.75466C9.90232 1.5948 9.52718 1.50805 9.14625 1.49984C8.72969 1.48765 8.31503 1.56073 7.92774 1.71459C7.54044 1.86845 7.18868 2.09984 6.89405 2.39456C6.59941 2.68928 6.36812 3.04112 6.21438 3.42846C6.06064 3.8158 5.98768 4.23048 6 4.64703C6.00833 5.02781 6.09514 5.40276 6.255 5.74846C6.41486 6.09415 6.64434 6.40314 6.92906 6.65609C6.96469 6.68703 7.00219 6.71703 7.03875 6.74984H3.75C3.35218 6.74984 2.97064 6.90788 2.68934 7.18918C2.40804 7.47049 2.25 7.85202 2.25 8.24984V11.2498C2.25 11.6477 2.40804 12.0292 2.68934 12.3105C2.97064 12.5918 3.35218 12.7498 3.75 12.7498V18.7498C3.75 19.1477 3.90804 19.5292 4.18934 19.8105C4.47064 20.0918 4.85218 20.2498 5.25 20.2498H18.75C19.1478 20.2498 19.5294 20.0918 19.8107 19.8105C20.092 19.5292 20.25 19.1477 20.25 18.7498V12.7498C20.6478 12.7498 21.0294 12.5918 21.3107 12.3105C21.592 12.0292 21.75 11.6477 21.75 11.2498V8.24984C21.75 7.85202 21.592 7.47049 21.3107 7.18918C21.0294 6.90788 20.6478 6.74984 20.25 6.74984ZM13.9688 3.42266C14.0875 3.29152 14.2321 3.18635 14.3934 3.11375C14.5547 3.04115 14.7293 3.00269 14.9062 3.00078H14.9522C15.1595 3.00208 15.3645 3.04475 15.5552 3.12629C15.7458 3.20783 15.9183 3.3266 16.0624 3.47564C16.2066 3.62468 16.3195 3.801 16.3947 3.99425C16.4698 4.18751 16.5056 4.39382 16.5 4.60109C16.4981 4.778 16.4596 4.9526 16.387 5.11393C16.3144 5.27526 16.2093 5.41984 16.0781 5.53859C15.1884 6.32609 13.7119 6.60359 12.7969 6.70109C12.9094 5.70828 13.2188 4.26547 13.9688 3.42266ZM7.96031 3.45641C8.25088 3.16587 8.64441 3.00179 9.05531 2.99984H9.10125C9.27815 3.00175 9.45275 3.04021 9.61409 3.11281C9.77542 3.18541 9.92 3.29058 10.0388 3.42172C10.8253 4.31047 11.1028 5.78422 11.2003 6.69547C10.2891 6.60172 8.81531 6.32047 7.92656 5.53391C7.79543 5.41516 7.69026 5.27057 7.61766 5.10924C7.54506 4.94791 7.5066 4.77331 7.50469 4.59641C7.49887 4.38569 7.53593 4.17599 7.61361 3.98002C7.69128 3.78406 7.80796 3.60592 7.95656 3.45641H7.96031ZM3.75 8.24984H11.25V11.2498H3.75V8.24984ZM5.25 12.7498H11.25V18.7498H5.25V12.7498ZM18.75 18.7498H12.75V12.7498H18.75V18.7498ZM20.25 11.2498H12.75V8.24984H20.25V11.2498Z" fill="currentColor"></path></svg>
                                    Mua {{ $tier[0] }} {{ $item['category']['unit'] }}
                                </span>
                                <span class="fw-bold text-danger">ưu đãi {{ $tier[1] }}%</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-center">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: #fd4336;"><path opacity="0.2" d="M19.5 12V18.75C19.5 18.9489 19.421 19.1397 19.2803 19.2803C19.1397 19.421 18.9489 19.5 18.75 19.5H5.25C5.05109 19.5 4.86032 19.421 4.71967 19.2803C4.57902 19.1397 4.5 18.9489 4.5 18.75V12H19.5Z" fill="currentColor"></path><path d="M20.25 6.74984H16.9613C16.9978 6.71891 17.0353 6.68891 17.0709 6.65609C17.3557 6.40314 17.5851 6.09415 17.745 5.74846C17.9049 5.40276 17.9917 5.02781 18 4.64703C18.0123 4.23048 17.9394 3.8158 17.7856 3.42846C17.6319 3.04112 17.4006 2.68928 17.106 2.39456C16.8113 2.09984 16.4596 1.86845 16.0723 1.71459C15.685 1.56073 15.2703 1.48765 14.8538 1.49984C14.4728 1.50805 14.0977 1.5948 13.7518 1.75466C13.406 1.91453 13.0968 2.14406 12.8438 2.42891C12.4936 2.83474 12.2089 3.29276 12 3.78641C11.7911 3.29276 11.5064 2.83474 11.1562 2.42891C10.9032 2.14406 10.594 1.91453 10.2482 1.75466C9.90232 1.5948 9.52718 1.50805 9.14625 1.49984C8.72969 1.48765 8.31503 1.56073 7.92774 1.71459C7.54044 1.86845 7.18868 2.09984 6.89405 2.39456C6.59941 2.68928 6.36812 3.04112 6.21438 3.42846C6.06064 3.8158 5.98768 4.23048 6 4.64703C6.00833 5.02781 6.09514 5.40276 6.255 5.74846C6.41486 6.09415 6.64434 6.40314 6.92906 6.65609C6.96469 6.68703 7.00219 6.71703 7.03875 6.74984H3.75C3.35218 6.74984 2.97064 6.90788 2.68934 7.18918C2.40804 7.47049 2.25 7.85202 2.25 8.24984V11.2498C2.25 11.6477 2.40804 12.0292 2.68934 12.3105C2.97064 12.5918 3.35218 12.7498 3.75 12.7498V18.7498C3.75 19.1477 3.90804 19.5292 4.18934 19.8105C4.47064 20.0918 4.85218 20.2498 5.25 20.2498H18.75C19.1478 20.2498 19.5294 20.0918 19.8107 19.8105C20.092 19.5292 20.25 19.1477 20.25 18.7498V12.7498C20.6478 12.7498 21.0294 12.5918 21.3107 12.3105C21.592 12.0292 21.75 11.6477 21.75 11.2498V8.24984C21.75 7.85202 21.592 7.47049 21.3107 7.18918C21.0294 6.90788 20.6478 6.74984 20.25 6.74984ZM13.9688 3.42266C14.0875 3.29152 14.2321 3.18635 14.3934 3.11375C14.5547 3.04115 14.7293 3.00269 14.9062 3.00078H14.9522C15.1595 3.00208 15.3645 3.04475 15.5552 3.12629C15.7458 3.20783 15.9183 3.3266 16.0624 3.47564C16.2066 3.62468 16.3195 3.801 16.3947 3.99425C16.4698 4.18751 16.5056 4.39382 16.5 4.60109C16.4981 4.778 16.4596 4.9526 16.387 5.11393C16.3144 5.27526 16.2093 5.41984 16.0781 5.53859C15.1884 6.32609 13.7119 6.60359 12.7969 6.70109C12.9094 5.70828 13.2188 4.26547 13.9688 3.42266ZM7.96031 3.45641C8.25088 3.16587 8.64441 3.00179 9.05531 2.99984H9.10125C9.27815 3.00175 9.45275 3.04021 9.61409 3.11281C9.77542 3.18541 9.92 3.29058 10.0388 3.42172C10.8253 4.31047 11.1028 5.78422 11.2003 6.69547C10.2891 6.60172 8.81531 6.32047 7.92656 5.53391C7.79543 5.41516 7.69026 5.27057 7.61766 5.10924C7.54506 4.94791 7.5066 4.77331 7.50469 4.59641C7.49887 4.38569 7.53593 4.17599 7.61361 3.98002C7.69128 3.78406 7.80796 3.60592 7.95656 3.45641H7.96031ZM3.75 8.24984H11.25V11.2498H3.75V8.24984ZM5.25 12.7498H11.25V18.7498H5.25V12.7498ZM18.75 18.7498H12.75V12.7498H18.75V18.7498ZM20.25 11.2498H12.75V8.24984H20.25V11.2498Z" fill="currentColor"></path></svg>
                            Mua {{ $item['discount_rules']['min_unit'] }} {{ $item['category']['unit'] }}
                        </span>
                        <span class="fw-bold text-danger">ưu đãi {{ $item['discount_rules']['percent'] }}%</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Input Số lượng --}}
        <div class="row g-3 mb-3">
            <div class="col-6">
                <label class="small text-dark mb-1">Số {{ $item['category']['unit'] }}</label>
                <div class="input-group input-group-sm mb-1">
                    <button class="btn btn-outline-secondary js-minus text-dark" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus h-5 w-5 text-[#6B6B6E]"><path d="M5 12h14"></path></svg>
                    </button>
                    <input type="number" class="form-control text-center js-unit" value="1" min="1">
                    <button class="btn btn-outline-secondary js-plus text-dark" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus h-5 w-5 text-[#6B6B6E]"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                    </button>
                </div>
                <small class="text-muted" style="font-size: 0.75rem;">Thanh toán theo {{ $item['category']['unit'] }}</small>
            </div>
            <div class="col-6">
                <label class="small text-dark mb-1">Số gói</label>
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text bg-white">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="color: #fd625e;"><path opacity="0.3" d="M17.3043 6.65186L17.3227 6.81019L17.3285 6.97186V13.0285C17.3285 13.7202 16.9852 14.366 16.4127 14.7535L16.2877 14.8327L11.0418 17.861L10.9385 17.9169L10.8335 17.9669V10.4752L17.3043 6.65186Z" fill="currentColor"></path><path d="M11.0415 2.13924L16.2865 5.16757C16.3282 5.19257 16.3698 5.21757 16.4098 5.24424L9.99984 9.03174L3.58984 5.24424C3.62984 5.21757 3.67151 5.19174 3.71318 5.16757L8.95818 2.13924C9.60318 1.76674 10.3965 1.76674 11.0415 2.13924Z" fill="currentColor"></path><path opacity="0.3" d="M2.69604 6.65186L9.16687 10.476V17.966C9.09521 17.9352 9.02604 17.9002 8.95854 17.861L3.71354 14.8327C3.06937 14.4602 2.67188 13.7727 2.67188 13.0285V6.97186C2.67188 6.86352 2.68021 6.75686 2.69687 6.65186H2.69604Z" fill="currentColor"></path></svg>
                    </span>
                    <input type="number" class="form-control text-center js-qty" value="1" min="1">
                </div>
                <small class="text-muted" style="font-size: 0.75rem;">Mỗi gói gồm {{ $item['proxy_count'] }} Proxy</small>
            </div>
        </div>

        {{-- Form Thông tin --}}
        <div class="mb-3">
            <label class="small text-dark mb-1">Giao thức <span class="text-danger">*</span></label>
            <select class="form-select text-secondary js-protocol">
                <option value="HTTP">HTTP</option>
                <option value="SOCKS5">SOCKS5</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="small text-dark mb-1">Tài khoản <span class="text-danger">*</span></label>
            <input type="text" class="form-control js-user" placeholder="Random">
        </div>
        <div class="mb-4">
            <label class="small text-dark mb-1">Mật khẩu <span class="text-danger">*</span></label>
            <input type="text" class="form-control js-pass" placeholder="Random">
        </div>

        <div class="rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
            <span class="fw-bold text-dark fs-5">Tổng tiền:</span>

            <div class="d-flex align-items-center">
                <span class="badge bg-danger rounded-pill px-2 py-1 js-discount-badge" style="font-size: 14px; display: none; width: fit-content; margin-right: 5px;"></span>
                <strong class="text-danger fs-4 js-total">{{ number_format($item['price']) }}đ</strong>
            </div>
        </div>

        @if (auth()->check())
            <button class="btn btn-danger w-100 prx-buy" data-id="{{ $item['id'] }}">Mua hàng</button>
        @else
            <a href="{{route('auth.login')}}" class="btn btn-primary w-100">Đăng nhập</a>
        @endif


        {{-- Footer Cam kết (Icon đỏ) --}}
        <div class="d-flex flex-row justify-content-between text-muted gap-2 mt-3" style="font-size: 0.75rem;">
            <span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="!h-5 !w-5"><path d="M7.5 10.6251L9.375 12.5001L12.5 8.12505M10 2.26172C8.11311 4.05358 5.60022 5.03637 2.99834 5.00005C2.66737 6.00837 2.49915 7.06297 2.5 8.12422C2.5 12.7842 5.68667 16.6992 10 17.8101C14.3133 16.7001 17.5 12.7851 17.5 8.12505C17.5 7.03339 17.325 5.98255 17.0017 4.99922H16.875C14.2117 4.99922 11.7917 3.95922 10 2.26172Z" stroke="#fd625e" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                Thanh toán nhanh
            </span>
            <span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="!h-5 !w-5"><path d="M3.125 11.25L11.875 1.875L10 8.75H16.875L8.125 18.125L10 11.25H3.125Z" stroke="#fd625e" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                Kích hoạt nhanh
            </span>
            <span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="!h-5 !w-5"><path d="M10 16.875C14.1417 16.875 17.5 13.7967 17.5 10C17.5 6.20333 14.1417 3.125 10 3.125C5.85833 3.125 2.5 6.20333 2.5 10C2.5 11.7533 3.21583 13.3525 4.39417 14.5667C4.75417 14.9392 5.01083 15.4333 4.8825 15.9342C4.74198 16.4818 4.47898 16.9904 4.11333 17.4217C4.40595 17.4742 4.7027 17.5004 5 17.5C6.06833 17.5 7.05833 17.165 7.87083 16.5942C8.54583 16.7775 9.26083 16.875 10 16.875Z" stroke="#fd625e" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                Hỗ trợ 24/7
            </span>
        </div>
    </div>
</div>
