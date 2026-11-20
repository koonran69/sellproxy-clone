<div class="modal fade" id="modalRenew" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formRenew" method="POST" data-action="{{route('vps.proxy.renewProxy')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Gia hạn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <input type="hidden" name="id" class="form-control" value="">
                <div class="modal-body">
                    <div class="mt-3">
                        <ul class="nav nav-pills" role="tablist">
                            @foreach($durations as $key=>$label)
                                <li class="nav-item">
                                    <a class="nav-link" data-month="{{$key}}" data-bs-toggle="pill" href="#month_{{$key}}">{{$label}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach($durations as $key => $label)
                                <div id="month_{{ $key }}" class="container tab-pane fade calculate-info" data-month="{{ $key }}"><br>
                                    <div class="loading text-center text-muted small">Chưa tải dữ liệu...</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger w-100"><i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Gia hạn</button>
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
