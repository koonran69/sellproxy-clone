<div class="modal fade" id="modalAddSubAccount" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0 pt-4 px-4 justify-content-between align-items-center">
                <h5 class="modal-title fw-bold" style="font-size: 1.25rem; color: #1f2937;">
                    {{ __('Thêm tài khoản phụ') }}
                </h5>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" style="font-size: 0.8rem;"></button>
            </div>
            <x-core-form id="formAddSubAccount">
                <div class="modal-body py-4 px-4">
                    <div class="mb-3">
                        <label class="form-label mb-2"
                            style="font-size: 0.95rem; color: #374151;">{{ __('Tên tài khoản phụ') }}</label>
                        <x-input type="text" name="username" placeholder="{{ __('Tên tài khoản phụ') }}"
                            style="background-color: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.75rem 1rem; border-radius: 0.5rem;"
                            pattern="^[a-zA-Z][a-zA-Z0-9_]{5,23}$"
                            title="{{ __('Tên người dùng phải chứa từ 6 đến 24 chữ cái, chữ số và dấu gạch dưới, và bắt đầu bằng một chữ cái tiếng Anh') }}"
                            required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label mb-2"
                            style="font-size: 0.95rem; color: #374151;">{{ __('Mật khẩu') }}</label>
                        <x-input type="password" name="password" id="add-sub-pass" placeholder="{{ __('Mật khẩu') }}"
                            style="background-color: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.75rem 1rem; border-radius: 0.5rem;"
                            required />
                    </div>
                    <div class="mb-0">
                        <label class="form-label mb-2"
                            style="font-size: 0.95rem; color: #374151;">{{ __('Giới hạn lưu lượng (GB)') }}</label>
                        <div class="input-group"
                            style="background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                            <input type="number" name="limit" class="form-control border-0 bg-transparent"
                                value="1" min="1" style="padding: 0.75rem 1rem; box-shadow: none;" required>
                            <span class="input-group-text border-0 bg-transparent text-muted"
                                style="padding-right: 1rem; font-size: 0.9rem;">GB</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 justify-content-end gap-2">
                    <button type="button" class="btn border-0 py-2 px-4 fw-medium" data-bs-dismiss="modal"
                        style="background-color: #f3f4f6; color: #4b5563; border-radius: 0.6rem; min-width: 80px;">
                        {{ __('Huỷ') }}</button>
                    <button type="submit" class="btn border-0 py-2 px-4 text-white fw-medium"
                        style="background-color: #007bff; border-radius: 0.6rem; min-width: 120px;">
                        {{ __('Xác nhận') }}</button>
                </div>
            </x-core-form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateSubAccount" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="font-size: 1.25rem; color: #1f2937;">
                    {{ __('Đổi mật khẩu') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="font-size: 0.8rem;"></button>
            </div>
            <x-core-form id="formUpdateSubAccount">
                <input type="hidden" name="account">
                <input type="hidden" name="state" value="1">
                <div class="modal-body pt-0 pb-0 px-4">
                    <div id="update-sub-display-name" class="mb-2 text-muted" style="font-size: 0.95rem;"></div>

                    <div class="mb-2">
                        <label class="form-label mb-2"
                            style="font-size: 0.95rem; color: #374151;">{{ __('Mật khẩu mới') }}</label>
                        <x-input type="password" name="password" id="update-sub-pass"
                            placeholder="{{ __('Mật khẩu mới') }}"
                            style="background-color: #f3f4f6; border: 1px solid #e5e7eb; padding: 0.75rem 1rem; border-radius: 0.5rem;"
                            required />
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4 justify-content-end gap-2">
                    <button type="button" class="btn border-0 py-2 px-4 fw-medium" data-bs-dismiss="modal"
                        style="background-color: #f3f4f6; color: #4b5563; border-radius: 0.6rem;">{{ __('Huỷ') }}</button>
                    <button type="submit" class="btn border-0 py-2 px-4 text-white fw-medium"
                        style="background-color: #6b7280; border-radius: 0.6rem;">{{ __('Lưu') }}</button>
                </div>
            </x-core-form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteSubAccount" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0 pt-4 px-4 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="font-size: 0.8rem;"></button>
            </div>
            <div class="modal-body pt-0 pb-4 px-4 text-center">
                <div class="d-inline-flex align-items-center justify-content-center mb-4"
                    style="width: 80px; height: 80px; background-color: #fee2e2; border-radius: 50%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                </div>

                <h5 class="fw-bold mb-2" style="font-size: 1.25rem; color: #1f2937; line-height: 1.4;">
                    {{ __('Bạn có chắc muốn xoá tài khoản phụ này?') }}
                </h5>
                <p class="text-muted mb-4" style="font-size: 0.95rem;">
                    {{ __('Bạn nên vô hiệu hoá tài khoản phụ trước khi xoá.') }}
                </p>

                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn border-0 py-2 px-4 fw-medium" data-bs-dismiss="modal"
                        style="background-color: #f3f4f6; color: #4b5563; border-radius: 0.6rem; min-width: 100px;">
                        {{ __('Huỷ') }}
                    </button>
                    <button type="button" id="confirm-delete-sub"
                        class="btn border-0 py-2 px-4 text-white fw-medium"
                        style="background-color: #ef4444; border-radius: 0.6rem; min-width: 100px;">
                        {{ __('Xoá') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
