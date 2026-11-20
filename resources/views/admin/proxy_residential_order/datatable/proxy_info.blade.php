<p><b>Tên dịch vụ::</b> {{ $data->service_name }}</p>
<p><b>Tên gói (nếu có):</b> {{ $data->plan ?? '-' }}</p>
<p><b>Loại:</b> {{ $data->type ?? '-' }}</p>
<div><b>Quốc gia:</b>
    <div class="d-flex align-items-center gap-2">
        <img src="{{asset('') . $data->country->feature_image}}" width="28" height="20" class="rounded shadow-sm border" alt="{{$data->country->name}}">
        <div>
            <div class="fw-semibold text-dark">{{$data->country->name}}</div>
            <div class="text-muted small">Mã code: <span class="fw-medium">{{$data->country->code ?? 'N/A'}}</span></div>
        </div>
    </div>
</div>
<p><b>ISP (nếu có):</b> {{ config('proxyresidental')['setting']['isps'][$data->location][$data->isp]['label'] ?? ($data->isp ?? '-') }}</p>
