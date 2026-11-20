@if (!$is_hot && !$is_feature)
    <span class="badge">@lang('Tin thường')</span>
@else
    @if ($is_hot)
        <span class="badge bg-danger">@lang('Tin hot')</span>
    @endif
    @if ($is_feature)
        <span class="badge bg-primary" >@lang('Tin nổi bật')</span>
    @endif
@endif
