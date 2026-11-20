@extends('admin.layouts.master')

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/core/libs/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/core/libs/select2/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
@push('css')
    <style>
        .wrap-loop-input .add-image-ckfinder{
            width: auto !important;
        }
        #site_logo {
            width: 200px !important;
        }

    </style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-core-form :action="route('admin.setting.update')" type="put" :validate="true">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-9">
                        <div class="card h-100">
                            <div class="card-header">
                                <h2 class="mb-0">{{ $title ?? trans('Setting') }}</h2>
                            </div>
                            <div class="row card-body wrap-loop-input settings">
                                @foreach ($settings as $setting)
                        
                                    <div class="col-12 mb-3">
                                        <label class="form-label" for="">@lang($setting->setting_name)</label>
                                        <div class="row g-2">
                                            <div class="col">
                                                @if ($setting->setting_key == 'bank_account_id')
                                                    <x-select class="select2-bs5" name="bank_account_id" :required="true">
                                                        @foreach ($vietqr_banks as $bank)
                                                            <x-select-option :option="$setting->plain_value" :value="$bank->bin" :title="$bank->name . ' - ' . $bank->shortName" />
                                                        @endforeach
                                                    </x-select>
                                                @else
                                                    <x-dynamic-component :component="$setting->getNameComponent()"
                                                        :name="$setting->setting_key"
                                                        :value="$setting->plain_value" 
                                                        showImage="{{ $setting->setting_key }}"
                                                        :required="true"
                                                    />
                                                @endif
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <span class="form-help" data-bs-toggle="popover" data-bs-placement="top"
                                                    data-bs-content="@lang($setting->desc)">?</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <div class="card-header">
                                {{ __('Đăng') }}
                            </div>
                            <div class="card-body p-2 d-flex justify-content-between">
                                <div class="d-flex align-items-center h-100 gap-2">
                                    <button type="submit" class="btn btn-primary" title="@lang('save')" name="submitter"
                                        value="save">@lang('save')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-core-form>
        </div>
    </div>
@endsection

@push('libs-js')
<script src="{{ asset('/public/core/libs/select2/js/select2.min.js') }}"></script>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        addSelect2()
    })
</script>
@endpush
