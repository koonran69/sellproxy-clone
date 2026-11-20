<div class="modal fade" id="modalExtendProxy" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content position-relative">
            <form id="formExtendProxy" method="POST" data-action="{{ route('proxyResidential.extendProxy') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Gia hạn proxy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <input type="hidden" name="id" class="form-control" value="">
                <div class="modal-body">
                    <div class="row g-3 align-items-center mt-1">
                        <div class="col-12">
                            <label class="form-label">Thời hạn</label>
                            <select id="time_period" name="time_period" class="form-select" required>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="text-muted">Số tiền:</div>
                        <div id="totalAmount" class="fs-5 fw-semibold text-danger">0đ</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="btnSubmitRenew" type="submit" class="btn btn-danger w-100">Gia hạn</button>
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
