<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Code -->
            <div class="col-12 col-md-9">
                <div class="mb-3">
                    <label class="form-label">@lang('Coin Name'):</label>
                    <x-input name="coin_name" :value="$coin->coin_name" :required="true" />
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="mb-3">
                    <label class="form-label">@lang('Code'):</label>
                    <x-input name="code" :value="$coin->code" :required="true" />
                </div>
            </div>
        </div>
    </div>
</div>
