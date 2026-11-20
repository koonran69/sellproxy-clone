<p>
    @if($data->state)
        Bang: {{$data->state}}
    @elseif($data->isp)
        Nhà mạng: {{$data->isp}}
    @else
        -
    @endif
</p>
