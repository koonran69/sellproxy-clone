<div class="modal fade" id="modalChangeProtocal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formChangeProtocal" method="POST" action="{{ route('proxyhome.bulkProtocal') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Cập nhật thông tin proxy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                
                <div class="modal-body">
                    <label class="form-label">Proxy đã chọn</label>
                    <textarea id="txtSelectedProtocal" class="form-control" rows="6" readonly></textarea>
                    <input type="hidden" name="items" id="selectedItemsProtocalJson">
                    
                    <div class="mt-3">
                        <label class="form-label">Giao thức</label>
                        <select name="protocal" id="protocal" class="form-control">
                            <option value="">--Chọn giao thức--</option>
                            <option value="HTTP">HTTP</option>
                            <option value="SOCKS">SOCKS</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button id="btnSubmitChangeProtocal" type="submit" class="btn btn-danger w-100">Cập nhật</button>
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