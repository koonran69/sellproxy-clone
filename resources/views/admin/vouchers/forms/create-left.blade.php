<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Code -->
            <div class="col-12 col-md-9">
                <div class="mb-3">
                    <label class="form-label">@lang('Code'):</label>
                    <x-input name="code" :value="old('code', 'PRX-' . uniqid_real(10))" :required="true" />
                </div>
            </div>

            <!-- Type -->
            <div class="col-12 col-md-3">
                <div class="mb-3">
                    <label class="form-label">@lang('Loại'):</label>
                    <x-select name="type" :required="true">
                        @foreach ($types as $key => $value)
                            <x-select-option :value="$key" :title="$value" :selected="old('type') == $key" />
                        @endforeach
                    </x-select>
                </div>
            </div>

            <!-- Value -->
            <div class="col-md-9 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Giá trị'):</label>
                    <x-input-number name="value" min="0" :value="old('value')" :required="true"
                        :placeholder="__('Giá trị')" />
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Giới hạn sử dụng'):</label>
                    <x-input-number name="usage_limit" min="0" :value="old('usage_limit')"
                        :placeholder="__('Giới hạn sử dụng')" />
                </div>
            </div>

            <!-- Start Date -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày bắt đầu'):</label>
                    <x-input type="date" name="start_date" :value="old('start_date')" :required="true" />
                </div>
            </div>

            <!-- End Date -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="form-label">@lang('Ngày kết thúc'):</label>
                    <x-input type="date" name="end_date" :value="old('end_date')" :required="true" />
                </div>
            </div>

            <div class="col-6 col-md-13">
                <div class="mb-3">
                    <label class="form-label">@lang('Hạng thành viên'):</label>
                    <x-select name="member_level_id">
                        <option value="">-- Chọn hạng thành viên --</option>
                        @foreach ($memberLevels as $key => $value)
                            <x-select-option :value="$value->id" :title="$value->name" :selected="old('member_level_id') == $value->id" />
                        @endforeach
                    </x-select>
                </div>
            </div>
    
            <div class="col-6 col-md-13">
                <div class="mb-3">
                    <label class="form-label">@lang('Áp dụng riêng cho User'):</label>
                    <x-select class="select2-bs5" name="user_id">
                        <option value="">-- Chọn User --</option>
                        @foreach ($users as $key => $value)
                            <x-select-option :value="$value->id" :title="$value->email" :selected="old('user_id') == $value->id" />
                        @endforeach
                    </x-select>
                </div>
            </div>


        </div>
    </div>
</div>
