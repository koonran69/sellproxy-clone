<div class="modal fade" id="modalRenew" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content position-relative">
            <form id="formRenew" method="POST" action="{{ route('proxyhome.bulkRenew') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Gia hạn proxy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">Proxy đã chọn</label>
                    <textarea id="txtSelectedRenew" class="form-control is-invalid" rows="6" readonly placeholder="Chưa chọn proxy nào"></textarea>
                    <input type="hidden" name="items" id="selectedItemsRenewJson">

                    <div class="row g-3 align-items-center mt-1">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Thời hạn</label>
                            <input type="number" min="1" step="1" name="months" id="months" class="form-control" placeholder="1">
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-check mt-4 pt-2">
                                <input class="form-check-input" type="checkbox" value="1" id="autoRenew" name="auto_renew" checked>
                                <label class="form-check-label" for="autoRenew">Tự động gia hạn</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="text-muted">Số tiền:</div>
                        <div id="totalAmount" class="fs-5 fw-semibold text-danger">0đ</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="btnSubmitRenew" class="btn btn-danger w-100">
                        <span class="btn-text">Gia hạn</span>
                        <span class="spinner-border spinner-border-sm align-text-bottom ms-2 d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>

                <!-- Overlay loading -->
                <div id="modalRenewLoading" class="position-absolute top-0 start-0 w-100 h-100 d-none"
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
