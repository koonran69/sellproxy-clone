<div class="col-12 col-md-3">
    <div class="card" id="blockSubmit">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                @adminaccessroutename('admin.voucher.update')
                <button type="submit" class="btn btn-primary" title="@lang('save')" name="submitter" value="save">@lang('save')</button>
                <button type="submit" class="btn" name="submitter" value="saveAndExit">
                    @lang('save&exit')
                </button>
                @endadminaccessroutename
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :option="$coin->status->value" :value="$key" :title="$value" />
                @endforeach
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('Icon')
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="icon" showImage="icon" :value="$coin->icon"/>
        </div>
    </div>
</div>
