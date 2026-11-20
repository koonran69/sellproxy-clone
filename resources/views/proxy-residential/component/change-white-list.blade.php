<div class="modal fade" id="modalChangeWhitelist" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formChangeWhitelist" method="POST" action="{{ route('proxyResidential.changeWhitelist') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Danh sách IP Whitelist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">IP Whitelist</label>
                    <small><i>Các ip ngăn cách nhau dấu phẩy ví dụ:<br>213.213.0.0,213.213.0.1,213.213.0.2</i></small>
                    <textarea name="ips" class="form-control" rows="6"></textarea>
                </div>

                <div class="modal-footer">
                    <button id="btnSubmitChangeWhitelist" type="submit" class="btn btn-danger w-100">Cập nhật</button>
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
