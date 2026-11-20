<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>

                <div class="row g-0">
                    <div class="col-md-7 p-4 p-lg-5">
                        <div class="mb-3">
                            <span class="badge text-primary fw-bold" style="background-color: #e7f0ff; padding: 8px 16px; border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M20 4c1.11 0 2 .89 2 2v12c0 1.11-.89 2-2 2H4c-1.11 0-2-.89-2-2V6c0-1.11.89-2 2-2zM8.5 15V9H7.25v3.5L4.75 9H3.5v6h1.25v-3.5L7.3 15zm5-4.74V9h-4v6h4v-1.25H11v-1.11h2.5v-1.26H11v-1.12zm7 3.74V9h-1.25v4.5h-1.12V10h-1.25v3.5h-1.13V9H14.5v5a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1"></path></svg>
                                <span>NEW</span>
                            </span>
                        </div>

                        <h2 class="fw-bold mb-3" style="font-size: 28px; color: #1a202c; line-height: 1.2;">
                            @lang('Đã có thể sử dụng các nhà cung cấp tại mục Get Proxies')
                        </h2>

                        <p class="text-muted mb-4" style="font-size: 15px;">
                            @lang('Kết nối tài khoản proxy, quản lý tài khoản con, thiết lập IP Whitelist và trích xuất proxy tất cả tại một nơi').
                        </p>

                        <div class="mb-4">
                            <p class="small text-uppercase fw-bold mb-2">@lang('Nhà cung cấp hiện có')</p>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-2 border rounded d-flex align-items-center bg-light">
                                        <span class="fw-bold text-primary me-2">ABC</span> <small class="fw-semibold">ABC Proxy</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 border rounded d-flex align-items-center bg-light">
                                        <span class="fw-bold text-info me-2">PIA</span> <small class="fw-semibold">PIA Proxy</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 border rounded d-flex align-items-center bg-light">
                                        <span class="fw-bold text-danger me-2">922</span> <small class="fw-semibold">922 Proxy</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('getProxies.index') }}" class="btn btn-primary w-100 py-3 fw-bold" style="border-radius: 12px; background-color: #007bff;">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M4 11v2h12l-5.5 5.5l1.42 1.42L19.84 12l-7.92-7.92L10.5 5.5L16 11z"></path></svg>
                            Get Proxies
                        </a>
                    </div>

                    <div class="col-md-5 d-none d-md-block" style="background-color: #f1f5f9; position: relative;">
                        <div class="h-100 d-flex align-items-center justify-content-center p-4">
                            <img src="{{asset('public/assets/images/get-proxies/banner-event.jpg')}}" class="img-fluid rounded shadow-sm" alt="Dashboard" onerror="this.src='https://via.placeholder.com/400x500?text=Dashboard+Preview'">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const MODAL_KEY = 'hide_event_modal_timestamp';
        const EXPIRE_TIME = 15 * 60 * 1000; // 15 phút

        function shouldShow() {
            const storedTimestamp = localStorage.getItem(MODAL_KEY);
            if (!storedTimestamp) return true;

            const now = new Date().getTime();
            // Nếu thời gian hiện tại lớn hơn thời gian đã lưu + 15 phút thì hiện lại
            if (now - parseInt(storedTimestamp) > EXPIRE_TIME) {
                localStorage.removeItem(MODAL_KEY); // Xóa key cũ
                return true;
            }
            return false;
        }

        if (!shouldShow()) {
            // Delay nhẹ 1s để khách hàng kịp nhìn thấy trang chủ rồi mới hiện popup
            setTimeout(() => {
                const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                eventModal.show();

                // Đánh dấu thời điểm bắt đầu ẩn (khi modal hiện lên hoặc khi bấm đóng)
                // Ở đây mình đánh dấu ngay khi hiện để tính đủ 15p từ lúc thấy
                localStorage.setItem(MODAL_KEY, new Date().getTime().toString());
            }, 1000);
        }
    });
</script>

<style>
    /* Chỉnh sửa hiển thị trên Mobile */
    @media (max-width: 768px) {
        #eventModal h2 { font-size: 20px !important; }
        #eventModal .p-lg-5 { padding: 25px !important; }
    }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); transition: 0.2s; }
</style>
