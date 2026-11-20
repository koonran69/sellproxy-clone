<p><b>Mã:</b> {{ $code }}</p>
<p>{{ $user['name'] }} <a target="_blank" href="{{ route('admin.user.edit', [ 'id' => $user['id'] ]) }}">(ID: {{ $user['id'] }})</a></p>
