<div class="modal modal-blur fade" id="modalAjaxConfirmUpdate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">@lang('Are you sure?')</div>
                <div>@lang('If you continue, Please click to continue!')</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto"
                    data-bs-dismiss="modal">@lang('cancel')</button>
                <x-core-form class="ajax-modal-form" action="#" type="put">
                    <button type="submit" class="btn btn-primary">@lang('Continue')</button>
                </x-core-form>
            </div>
        </div>
    </div>
</div>