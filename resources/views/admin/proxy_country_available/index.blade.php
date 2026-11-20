@extends('admin.layouts.master')

@push('libs-css')
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.4.1/css/rowGroup.dataTables.min.css">
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">@lang('list')</h2>
                    @adminaccessroutename('admin.proxy_country_available.create')
                    <a href="{{ route('admin.proxy_country_available.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus"></i>
                        <span>@lang('add')</span>
                    </a>
                    @endadminaccessroutename
                </div>
                <div class="card-body">
                    <div class="table-responsive position-relative">
                        <table id="proxyTable" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Loại Proxy</th>
                                <th>IP Version</th>
                                <th>Quốc Gia</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
        </div>
    </div>
@endsection

@push('libs-js')
<!-- button in datatable -->
<script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
            <script src="https://cdn.datatables.net/rowgroup/1.4.1/js/dataTables.rowGroup.min.js"></script>
@endpush

@push('js')
            <script>
                $(document).ready(function () {
                    $('#proxyTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{{ route('admin.proxy_country_available.ajax') }}',
                        columns: [
                            { data: 'type.name', name: 'type.name' },
                            { data: 'ip_version.version', name: 'ipVersion.version' },
                            {
                                data: 'country',
                                orderable: false,
                                searchable: false,
                                render: function (data, type, row) {
                                    return `
                                          <img src="/flags/${row.country.code.toLowerCase()}.png" width="20" />
                                          ${row.country.name}
                                        `;
                                }
                            }
                        ],
                        rowGroup: {
                            dataSrc: function (row) {
                                const key = `${row.type.name} | ${row.ip_version.version}`;
                                const groupHtml = `
                                                  <strong>${key}</strong>
                                                  <a href="/admin/proxy-country-available/edit?type_id=${row.type.id}&ip_version_id=${row.ip_version.id}" class="btn btn-sm btn-link">
                                                    Sửa nhóm
                                                  </a>
                                                `;
                                return groupHtml;
                            }
                        }
                    });
                });
            </script>
@endpush
