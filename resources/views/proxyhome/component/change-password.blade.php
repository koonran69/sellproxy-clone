<div class="modal fade" id="modalChangePwd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formChangePwd" method="POST" action="{{ route('proxyhome.bulkChangePassword') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Cập nhật thông tin proxy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                
                <div class="modal-body">
                    <label class="form-label">Proxy đã chọn</label>
                    <textarea id="txtSelected" class="form-control" rows="6" readonly></textarea>
                    <input type="hidden" name="items" id="selectedItemsJson">
                    
                    <div class="mt-3">
                        <label class="form-label">Tài khoản</label>
                        <input type="text" name="account" class="form-control" placeholder="Nhập tài khoản">
                    </div>
                    
                    <div class="mt-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="text" name="password" class="form-control" placeholder="Nhập mật khẩu">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button id="btnSubmitChangePwd" type="submit" class="btn btn-danger w-100">Cập nhật</button>
                </div>
                <div id="modalLoadingOverlay"
                     class="position-absolute top-0 start-0 w-100 h-100 d-none"
                     style="background: rgba(255,255,255,.55); z-index: 5;">
                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                        <div class="spinner-border" role="status" aria-hidden="true"></div>
                        <div class="small mt-2 text-muted">Đang xử lý, vui lòng đợi…</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>