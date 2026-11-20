<!-- Modal Xác nhận gia hạn từng proxy -->
<div class="modal fade" id="modalConfirmRenew" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Xác nhận gia hạn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Bạn có chắc chắn muốn gia hạn proxy này không?</p>
                <div class="bg-light p-3 rounded-3 mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Proxy / IP:</span>
                        <span class="fw-bold js-renew-ip">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Thời hạn gia hạn:</span>
                        <span class="fw-bold js-renew-days">-</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Tổng tiền thanh toán:</span>
                        <span class="fw-bold text-danger js-renew-price" style="font-size: 1.2rem;">0đ</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-warning" id="btnConfirmRenewAction">Xác nhận gia hạn</button>
            </div>
        </div>
    </div>
</div>
