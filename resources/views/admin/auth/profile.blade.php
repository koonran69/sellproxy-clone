@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <x-core-form class="block-double-click" :action="route('admin.profile.update')" type="put" enctype="multipart/form-data" :validate="true">
                    <div class="card">
                        <div class="card-body">
                            <!-- fullname -->
                            <div class="mb-3">
                                <label class="form-label">@lang('fullname'):</label>
                                <x-input name="fullname" :value="$auth->fullname" :required="true" placeholder="{{ __('fullname') }}"/>
                            </div>
                            <!-- phone -->
                            <div class="mb-3">
                                <label class="form-label">@lang('phone'):</label>
                                <x-input-phone name="phone" :value="$auth->phone" :required="true" />
                            </div>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-center">
                                <button type="submit" class="btn btn-primary">@lang('Update')</button>
                            </div>
                        </div>
                    </div>
                    </x-core-form>
                </div>
            </div>
        </div>
    </div>
@endsection
