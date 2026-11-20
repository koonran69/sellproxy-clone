@if ($variations)
    <div>
        @foreach ($variations as $variation)
            {{ $variation['name'] }}@if (!$loop->last), 
            @endif
        @endforeach
    </div>
@else
    <div>- </div>
@endif
<a href="{{ route('admin.proxy.variation.index', $id) }}">@lang('Cấu hình chủng loại của thuộc tính')</a>
