<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-md-3">
                <label>Loại Proxy</label>
                <select class="form-control" name="proxy_type_id" required>
                    <option value="">Chọn loại</option>
                    @foreach($proxyTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3">
                <label>IP Version</label>
                <select class="form-control" name="ip_version_id" required>
                    <option value="">Chọn version</option>
                    @foreach($ipVersions as $version)
                        <option value="{{ $version->id }}">{{ $version->version }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row card-body">
            <div class="form-group mb-4">
                <h3>Country</h3>
                
                <div class="row mt-2">
                    <div class="col-12 pb-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="checkAllCountries" class="custom-control-input">
                            <label class="custom-control-label font-weight-bold" for="checkAllCountries">
                                Chọn tất cả
                            </label>
                        </div>
                    </div>
                    @foreach($countries as $country)
                        <div class="col-6 col-md-6 col-lg-4 pb-2 order__country">
                            <div class="custom-control custom-radio">
                                <input type="checkbox" id="id_country-{{ $country->code }}" name="country_ids[]" value="{{ $country->id }}" class="custom-control-input country-checkbox" data-name="{{ $country->name }}">
                                <label class="custom-control-label" for="id_country-{{ $country->code }}"><img src="{{ asset($country->feature_image) }}"> <span class="pl-1">{{ $country->name }}</span></label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
