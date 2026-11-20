@extends("proxy-residential.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3  class="page-title">Lịch sử giao dịch</h3>
            <div class="proxy-static-list proxy-static">
                <table id="demo-custom-toolbar" class="table data-table--custom" cellspacing="0"
                       data-toggle="table"
                       data-locale="vi-VN"
                       data-toolbar="#table-toolbar"
                       data-striped="true"
                       data-url="{{ route("proxyResidential.searchTransactionHistory") }}"
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
                        <th data-field="check_id" data-checkbox="true">ID</th>
                        <th data-field="code" data-sortable="true">Mã</th>
                        <th data-field="note" data-sortable="true">Giao dịch</th>
                        <th data-field="amount" data-sortable="true" data-formatter="formatPriceVND">Số tiền</th>
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
    const vnd    = n => (Number(n)||0).toLocaleString('vi-VN') + 'đ';
    function formatPriceVND(value){
        return vnd(value);
    }
    function formatDateVN(value) {
        if (!value) return '';
        const d = new Date(value);
        return d.toLocaleString('vi-VN');
    }
    function proxyFormatter(value, row, index) {
        return `
                  <div>
                    <strong>IP:</strong> ${row.ip}:${row.port}<br>
                    <strong>User:</strong> ${row.username}<br>
                    <strong>Pass:</strong> ${row.password}
                  </div>
                `;
    }
    function queryParams(params) {
        params.search_by = $('#searchBy').val();
        params.q = $('#filterInput').val();
        return params;
    }
</script>
@stop
