<div class="modal fade" id="modalChangeAuth" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formChangeAuth" method="POST" data-action="{{ route('proxyResidential.changeAuthProxy') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Thông tin xác thực</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <input type="hidden" name="id" class="form-control" value="">
                <div class="modal-body">
                    <div class="mt-3">
                        <label class="form-label">Tài khoản</label>
                        <input type="text" name="username" class="form-control" placeholder="Nhập tài khoản" readonly>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Mật khẩu</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off" readonly>
                            <button type="button" class="btn btn-outline-secondary toggle-password" tabindex="-1">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="btnSubmitChangeAuth" type="submit" class="btn btn-danger w-100"><i class="fa-solid fa-rotate me-2"></i>Xoay mật khẩu mới</button>
                </div>
                <div class="position-absolute top-0 start-0 w-100 h-100 d-none modalLoadingOverlay"
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
