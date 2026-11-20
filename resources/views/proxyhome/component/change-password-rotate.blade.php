<div class="modal fade" id="modalChangePwd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formChangePwd" method="POST" action="{{ route('proxyhome.bulkChangePasswordRotate') }}">
                @csrf
                <input type="hidden" id="rowId" name="id">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Cập nhật thông tin proxy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mt-3">
                        <label class="form-label">Tài khoản</label>
                        <input disabled id="rowUsername" type="text" name="account" class="form-control" placeholder="Nhập tài khoản">
                    </div>

                    {{-- <div class="mt-3">
                        <label class="form-label">Giao thức</label>
                        <select name="protocol" id="protocol" class="form-control">
                            <option value="">--Chọn giao thức--</option>
                            <option value="HTTP">HTTP</option>
                            <option value="SOCKS">SOCKS5</option>
                        </select>
                    </div> --}}

                    <div class="form-check my-3">
                        <input class="form-check-input" id="isRotate" type="checkbox" name="is_rotate" value="1" />
                        <label class="form-check-label" for="isRotate">Tự động xoay</label>
                    </div>
            
                    <div id="isShowRotate" class="mb-3" style="display: none;">
                        <label class="form-label">Thời gian xoay (phút)</label>
                        <input type="number" name="rotate_interval" min="1" value="1" class="form-control js-rotate-time">
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