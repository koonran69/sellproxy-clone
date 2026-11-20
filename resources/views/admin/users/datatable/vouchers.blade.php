@if(isset($private_vouchers))
<ul style="list-style-type: none; padding: 0px">
    @foreach($private_vouchers as $voucher)
    <li><a href="{{ route('admin.voucher.edit', ['id' => $voucher['id'] ]) }}">{{ $voucher['code'] }}</a></li>
    @endforeach
</ul>
@endif