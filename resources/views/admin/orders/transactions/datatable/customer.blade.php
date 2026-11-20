@if ($customer)
    <a href="{{ route('admin.customer.edit', $reference_id) }}">{{ $customer['fullname'] }}</a>
@endif
