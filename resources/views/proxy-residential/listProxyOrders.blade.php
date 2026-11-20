@extends("proxy-residential.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3  class="page-title">Danh sách đơn hàng proxy</h3>
            <div class="proxy-static-list proxy-static">
                <table id="demo-custom-toolbar" class="table data-table--custom" cellspacing="0"
                       data-toggle="table"
                       data-locale="vi-VN"
                       data-toolbar="#table-toolbar"
                       data-striped="true"
                       data-url="{{ route("proxyResidential.searchProxyOrders") }}"
                       data-search="false"
                       data-show-refresh="false"
                       data-show-toggle="false"
                       data-show-columns="false"
                       data-pagination="true"
                       data-side-pagination="server"
                       data-page-size="25"
                       data-query-params="queryParams"
                       data-cookie="true"
                       data-sort-order="desc"
                       data-cookie-id-table="proxy-index"
                       data-cookie-expire="{!! config('params.bootstrapTable.extension.cookie.cookieExpire') !!}"
                >
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">ID đơn hàng</th>
                        <th data-field="partner_order_id" data-sortable="true">Mã</th>
                        <th data-field="service_name" data-sortable="true">Dịch vụ</th>
                        <th data-field="plan" data-sortable="true">Gói (nếu có)</th>
                        <th data-field="amount" data-sortable="true">Số tiền</th>
                        <th data-field="created_at" data-sortable="true" data-formatter="formatDateVN">Ngày tạo</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    function formatDateVN(value) {
        if (!value) return '';
        const d = new Date(value);
        return d.toLocaleString('vi-VN');
    }
    function queryParams(params) {
        params.search_by = $('#searchBy').val();
        params.q = $('#filterInput').val();
        return params;
    }
</script>
@stop
