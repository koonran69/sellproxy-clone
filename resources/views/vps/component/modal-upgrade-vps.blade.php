<div class="modal fade" id="modalUpgradeVPS" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formUpgradeVPS" method="POST" data-action="{{route('vps.upgradeVPS')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Nâng cấp server</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <input type="hidden" name="id" class="form-control" value="">
                <div class="modal-body">
                    <div class="mt-3">
                        <label class="form-label">Theo Plan</label>
                        <select class="form-select" name="plan_id">
                            <option>Vui lòng chọn plan</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="calculate_price_upgrade"></label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger w-100"><i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Nâng cấp</button>
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
