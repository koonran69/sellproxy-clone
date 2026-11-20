@adminaccessroutename('admin.customer.edit')
    <a href="{{ route('admin.customer.edit', $id) }}">{{ $fullname }}</a>
@elseadminaccessroutename
    {{ $fullname }}
@endadminaccessroutename
