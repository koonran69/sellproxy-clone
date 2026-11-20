<?php
    $regions = app(\App\Services\VPS\VPSService::class)->listRegion();
    $regions = collect($regions)->keyBy('symbol')->toArray();
?>
@if($data->nation !== 'GPU')
    <div class="d-flex align-items-center gap-2">
        <img src="data:image/png;base64,{{$regions[$data->nation]['flag']}}" width="28" height="20" class="rounded shadow-sm border" alt="{{$regions[$data->nation]['name']}}">
        <div>
            <div class="fw-semibold text-dark">{{$regions[$data->nation]['name']}}</div>
            <div class="text-muted small">Mã code: <span class="fw-medium">{{$regions[$data->nation]['symbol']}}</span></div>
        </div>
    </div>
@else
    {{$data->nation}}
@endif
