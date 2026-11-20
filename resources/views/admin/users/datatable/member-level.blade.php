@if(!isset($member_level['name']))
    <span class="badge bg-secondary">Chưa xếp hạng</span>
@else
    <span class="badge bg-green">{{ $member_level['name'] }}</span>
@endif


