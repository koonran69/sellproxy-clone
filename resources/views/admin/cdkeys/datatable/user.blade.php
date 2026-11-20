@if(isset($user['name']))
    {{ $user['name']  }}
@else
    <span @class(['badge', 'bg-secondary'])>Chưa có</span>
@endif
