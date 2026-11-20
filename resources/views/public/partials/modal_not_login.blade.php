<div class="modal fade" id="notLoginModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel"> <i class="ti ti-progress-check text-success"></i> Đăng nhập!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn chưa đăng nhập. Vui lòng <a href="{{ route("auth.login") }}">Đăng nhập</a> để tiếp tục sử dụng dịch vụ của chúng tôi
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button class="btn rounded-3" id="google-login">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo" class="w-4 h-4">
                    <span class="ms-1">Đăng nhập</span>
                </button>
                <a href="{{ route("auth.login") }}" class="btn btn-primary">Đăng nhập</a>
            </div>
        </div>
    </div>
</div>