<p><b>Mã đơn hàng:</b> {{ $data->id }}</p>
<p>{{ $data->user->name }} <a target="_blank" href="{{ route('admin.user.edit', [ 'id' => $data->user->id ]) }}">(ID: {{ $data->user->id }})</a></p>
