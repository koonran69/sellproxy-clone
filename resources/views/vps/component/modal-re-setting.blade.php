<div class="modal fade" id="modalReSetting" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form id="formReSetting" method="POST" data-action="{{route('vps.reSettingVPS')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Cài đặt lại server</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <input type="hidden" name="id" class="form-control" value="">
                <div class="modal-body">
                    <div class="mt-3">
                        <p>
                            Thông tin đăng nhập sẽ được gửi đến email của quý khách. Để đảm bảo an toàn, mật khẩu sẽ bị xoá trong vòng 24h. Vui lòng đổi mật khẩu khác hoặc lưu lại ở nơi an toàn.
                        </p>
                    </div>
                    <div class="mt-3">
                        <label class="form-check  mb-3">
                            <input class="form-check-input" name="status_chrome" type="checkbox">
                            <span class="form-check-label">Cài đặt Chrome</span>
                        </label>
                        <label class="form-check  mb-3">
                            <input class="form-check-input" name="status_firefox" type="checkbox">
                            <span class="form-check-label">Cài đặt Firefox</span>
                        </label>

                        <div class="form-group mb-3">
                            <label class="form-check">
                                <input class="form-check-input" name="status_random_password"
                                       type="checkbox" checked>
                                <span class="form-check-label">Mật khẩu ngẫu nhiên</span>
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" placeholder="Nhập mật khẩu"
                                       class="form-control d-none mt-2" autocomplete="off" style="z-index: 1">
                                <button type="button" class="btn btn-outline-secondary toggle-password" tabindex="-1" style="border: none;position: absolute;top: 19%;right: 0;z-index: 2">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            <div id="password-error" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-check">
                                <input class="form-check-input" name="status_random_port"
                                       type="checkbox" checked>
                                <span class="form-check-label">Port ngẫu nhiên</span>
                            </label>
                            <input type="number" name="port" placeholder="Nhập port"
                                   class="form-control d-none mt-2">
                            <div id="port-error" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="form-label">Hệ điều hành</div>
                            <select id="os" class="form-select" name="os">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger w-100"><i class="fa-solid fa-pen-to-square me-2"></i>Cập nhật</button>
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
