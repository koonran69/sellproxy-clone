<div class="modal fade" id="modalChangeNote" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form id="formChangeNote" method="POST" data-action="{{ route('proxyResidential.changeNoteProxy') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Ghi chú Proxy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <input type="hidden" name="id" class="form-control" value="">
                <div class="modal-body">
                    <div class="mt-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="note" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="btnSubmitChangeNote" type="submit" class="btn btn-danger w-100">Cập nhật</button>
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
