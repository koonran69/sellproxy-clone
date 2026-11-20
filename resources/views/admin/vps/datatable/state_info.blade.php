<p>
    @if($data->state)
        @if($data->state === "GPU") {{$data->state}}
        @else Bang: {{$data->state}}
        @endif
    @elseif($data->provider)
        Nhà mạng: {{$data->provider}}
    @else
        -
    @endif
</p>
