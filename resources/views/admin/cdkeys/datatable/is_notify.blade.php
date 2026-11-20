@if($is_notify)
    <span @class(['badge', 'bg-green'])>Đã</span>
@else
    <span @class(['badge', 'bg-secondary'])>Chưa</span>
@endif
