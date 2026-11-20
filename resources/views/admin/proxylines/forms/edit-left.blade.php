<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <div class="col-md-3">
                <label>Loại Proxy</label>
                <select class="form-control" name="proxy_type_id" required>
                    <option value="">Chọn loại</option>
                    @foreach($proxyTypes as $type)
                        <option @if($type->id == $proxyline->proxy_type_id) selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3">
                <label>IP Version</label>
                <select class="form-control" name="ip_version_id" required>
                    <option value="">Chọn version</option>
                    @foreach($ipVersions as $version)
                        <option @if($version->id == $proxyline->ip_version_id) selected @endif value="{{ $version->id }}">{{ $version->version }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3">
                <label>Thời hạn thuê (ngày)</label>
                <select class="form-control" name="duration_days" required>
                    <option @if(5 == $proxyline->duration_days) selected @endif value="5">5 ngày</option>
                    <option @if(10 == $proxyline->duration_days) selected @endif value="10">10 ngày</option>
                    <option @if(20 == $proxyline->duration_days) selected @endif value="20">20 ngày</option>
                    <option @if(30 == $proxyline->duration_days) selected @endif value="30">30 ngày</option>
                    <option @if(60 == $proxyline->duration_days) selected @endif value="60">60 ngày</option>
                    <option @if(90 == $proxyline->duration_days) selected @endif value="90">90 ngày</option>
                    <option @if(120 == $proxyline->duration_days) selected @endif value="120">120 ngày</option>
                    <option @if(150 == $proxyline->duration_days) selected @endif value="150">150 ngày</option>
                    <option @if(180 == $proxyline->duration_days) selected @endif value="180">180 ngày</option>
                    <option @if(210 == $proxyline->duration_days) selected @endif value="210">210 ngày</option>
                    <option @if(240 == $proxyline->duration_days) selected @endif value="240">240 ngày</option>
                    <option @if(270 == $proxyline->duration_days) selected @endif value="270">270 ngày</option>
                    <option @if(300 == $proxyline->duration_days) selected @endif value="300">300 ngày</option>
                    <option @if(330 == $proxyline->duration_days) selected @endif value="330">330 ngày</option>
                    <option @if(360 == $proxyline->duration_days) selected @endif value="360">360 ngày</option>
                </select>
            </div>
        </div>
        
        <div class="row mt-3 card-body">
            <div class="col-md-3">
                <label>Số lượng IP tối thiểu</label>
                <input value="{{ $proxyline->min_quantity }}" type="number" name="min_quantity" class="form-control" required>
            </div>
            
            <div class="col-md-3">
                <label>Số lượng IP tối đa</label>
                <input value="{{ $proxyline->max_quantity }}" type="number" name="max_quantity" class="form-control" required>
            </div>
            
            <div class="col-md-3">
                <label>Giá mỗi IP</label>
                <input value="{{ $proxyline->price_per_ip }}" type="number" name="price_per_ip" class="form-control" required>
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
                                <input {{ in_array($country->id, $selectedCountryIds) ? 'checked' : '' }} type="checkbox" id="id_country-{{ $country->code }}" name="country_ids[]" value="{{ $country->id }}" class="custom-control-input country-checkbox" data-name="{{ $country->name }}" data-flag="https://static.proxyline.net/media/CACHE/images/flags/ru/16202e2bc1fc5dfa7f5a01caf77f4145.png">
                                <label class="custom-control-label" for="id_country-{{ $country->code }}"><img src="{{ asset($country->feature_image) }}"> <span class="pl-1">{{ $country->name }}</span></label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
