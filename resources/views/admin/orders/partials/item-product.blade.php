@php
    $accountType = $data['account_type'] ?? '';
@endphp
<tr @class([
    'item-product',
    'product-' . $data['product_id'],
]) data-product-id="{{ $data['product_id'] }}" data-variation-id="{{ $data['variation_id'] }}">
    <td class="align-middle">
    </td>
    <td class="align-middle">
        <div class="d-flex align-items-center">
            <div class="me-2">
                <img class="avatar" src="{{ asset($data['feature_image']) }}" alt="{{ $data['name_vi'] }}">
            </div>
            <div>
                <strong>{{ $data['name_vi'] }}</strong>
                <div class="text-muted small">
                    ({{ $data['variation_name'] }})
                </div>
            </div>
        </div>
    </td>
{{--    <td>--}}
{{--        <div class="d-flex gap-3">--}}
{{--            <div class="form-check">--}}
{{--                <input {{ $accountType === 'cd_key' ? 'checked' : '' }} class="form-check-input" type="radio" name="data[account_type][{{$data['product_id'] }}_{{ $data['variation_id'] }}]" id="account_type_cdkey_{{$data['product_id'] }}_{{ $data['variation_id'] }}" value="cd_key" onclick="toggleInput('{{$data['product_id'] }}_{{ $data['variation_id'] }}')">--}}
{{--                <label class="form-check-label" for="account_type_cdkey_{{$data['product_id'] }}_{{ $data['variation_id'] }}">@lang('CD Key')</label>--}}
{{--            </div>--}}
{{--            <div class="form-check">--}}
{{--                <input {{ $accountType === 'account_pass' ? 'checked' : '' }} class="form-check-input" type="radio" name="data[account_type][{{$data['product_id'] }}_{{$data['variation_id'] }}]" id="account_type_account_{{$data['product_id'] }}_{{ $data['variation_id'] }}" value="account_pass" onclick="toggleInput('{{$data['product_id'] }}_{{ $data['variation_id'] }}')">--}}
{{--                <label class="form-check-label" for="account_type_account_{{$data['product_id'] }}_{{ $data['variation_id'] }}">@lang('Account & Password')</label>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div id="cdKeyInput_{{$data['product_id'] }}_{{ $data['variation_id'] }}" class="mt-3 {{ $accountType !==  'cd_key' ? 'd-none' : '' }}">--}}
{{--            <input value="{{ $data['cd_key'] ?? "" }}" name="data[cd_key][{{$data['product_id'] }}_{{$data['variation_id'] }}]" type="text" class="form-control" placeholder="@lang('Nhập CD Key')">--}}
{{--        </div>--}}

{{--        <div id="accountInput_{{$data['product_id'] }}_{{ $data['variation_id'] }}" class="mt-3 {{ $accountType !==  'account_pass' ? 'd-none' : '' }}">--}}
{{--            <input value="{{ $data['username'] ?? "" }}" name="data[username][{{$data['product_id'] }}_{{$data['variation_id'] }}]" type="text" class="form-control mb-2" placeholder="@lang('Nhập Username')">--}}
{{--            <input value="{{ $data['password'] ?? "" }}" name="data[password][{{$data['product_id'] }}_{{$data['variation_id'] }}]" class="form-control" placeholder="@lang('Nhập Password')">--}}
{{--        </div>--}}
{{--    </td>--}}
    <td class="text-start align-middle">
        <div class="quantity-wrapper">
            <input type="text" class="form-control quantity" value="{{ $data['quantity'] }}" name="data[quantity][]">
        </div>
    </td>
    <td class="text-end align-middle">
        <span class="">{{ format_price($data['price']) }}</span>
    </td>
    <td class="text-end align-middle">
        <span class="total-price">{{ format_price($data['total_price']) }}</span>
    </td>
</tr>

@php
    $cdKeys = \App\Models\CDkey::where('user_id', $order->user_id)
    ->where('proxy_id', $data['product_id'])
    ->where('variation_id', $data['variation_id'])
    ->where('order_id', $order->id)
    ->get();
@endphp
@if($cdKeys && !$cdKeys->isEmpty())
<tr>
    <td colspan="10">
        <p class="text-success">Danh sách CDKEYs đã cấp: </p>
        <ul>
            @foreach($cdKeys as $cdKey)
            <li>{{ $cdKey->cdkey }}</li>
            @endforeach
        </ul>
    </td>
</tr>
@endif
