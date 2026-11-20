<div class="modal fade modal-load-ajax" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <x-core-form class="ajax-modal-form" data-load-dt="true" data-table-id="permission" action="{{ route('admin.permission.store') }}" type="post" :validate="true">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Create')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('Permission name'):</label>
                                <x-input name="name" :value="old('name')" :required="true"
                                    :placeholder="__('Permission name')" />
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">@lang('Route list'):</label>
                            <div class="row">
                                @foreach ($route_names as $route_name)
                                    <div class="col-12 col-md-4">
                                        <x-input-switch name="route_names[]" value="{{ $route_name }}" :label="$route_name" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                </div>
            </x-core-form>
        </div>
    </div>
</div>