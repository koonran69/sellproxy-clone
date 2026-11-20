<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- Code -->
            <div class="col-12 col-md-9">
                <div class="mb-3">
                    <label class="form-label">@lang('Question'):</label>
                    <x-input name="question" :value="old('question')" :required="true" />
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="mb-3">
                    <label class="form-label">@lang('Answer'):</label>
                    <textarea name="answer" class="ckeditor visually-hidden">{{ old('answer') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
