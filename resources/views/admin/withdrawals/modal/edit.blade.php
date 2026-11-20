<div class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('Chi tiết') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-md-12">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="row">
                                <div class="col-md-9 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('Khách hàng')</label>
                                        <x-input name="user_id" :value="$deposit->user->lable" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('Số tiền'):</label>
                                        <x-input-number name="amount" :value="format_price($deposit->amount)" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('Loại'):</label>
                                        <x-input-number name="type" :value="$deposit->type->description()" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('Trạng thái'):</label>
                                        <x-input-number name="status" :value="$deposit->status->description()" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="mb-3">
                                        <label class="'form-label">@lang('Ghi chú')</label>
                                        <x-textarea name="note" rows="3">{{ $deposit->note }}</x-textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn app-btn-secondary me-auto"
                    data-bs-dismiss="modal">{{ __('Thoát') }}</button>

            </div>
        </div>
    </div>
</div>
