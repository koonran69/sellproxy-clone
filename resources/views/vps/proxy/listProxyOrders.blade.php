@extends("vps.layout")

@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3  class="page-title">Danh sách đơn hàng vps</h3>
            <div class="vps-static-list vps-static">
                <table id="demo-custom-toolbar" class="table data-table--custom" cellspacing="0"
                       data-toggle="table"
                       data-locale="vi-VN"
                       data-toolbar="#table-toolbar"
                       data-striped="true"
                       data-url="{{ route("vps.proxy.searchProxyOrders") }}"
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
                       data-cookie-id-table="vps-index"
                       data-cookie-expire="{!! config('params.bootstrapTable.extension.cookie.cookieExpire') !!}"
                >
                    <thead>
                    <tr>
                        <th data-field="id" data-sortable="true">ID đơn hàng</th>
                        <th data-field="range_ip" data-sortable="true">Range IP</th>
                        <th data-field="remote_port" data-sortable="true">Port</th>
                        <th data-field="nation" data-sortable="true" data-formatter="formatCountry">Quốc gia/GPU</th>
                        <th data-field="state" data-sortable="true" data-formatter="formatState">Bang/Nhà mạng</th>
                        <th data-field="duration" data-sortable="true">Số tháng</th>
                        <th data-field="quantity" data-sortable="true">Số lượng</th>
                        <th data-field="price" data-sortable="true" data-formatter="formatPriceVND">Price</th>
                        <th data-field="created_at" data-sortable="true" data-formatter="formatDateVN">Ngày tạo</th>
                        <th data-field="request" data-sortable="false" data-formatter="formatNote">Mô tả</th>
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
    const regions = @json($regions);
    function formatCountry(value){
        if(value === 'VNR'){
            value = 'VN';
            $symbolTempo = 'VNR;'
        }
        return `
            <div class="d-flex align-items-center gap-2">
                <img src="data:image/png;base64,${regions[value].flag}" width="28" height="20" class="rounded shadow-sm border" alt="${regions[value].name}">
                <div>
                    <div class="fw-semibold text-dark">${regions[value].name}</div>
                    <div class="text-muted small">Mã code: <span class="fw-medium">${regions[value].symbol}</span></div>
                </div>
            </div>
            `;
    }
    function formatState(value,row){
        if(row.state){
            return 'Bang: '+row.state;
        }else if(row.isp){
            return 'Nhà mạng: '+row.isp;
        }else{
            return '-';
        }
    }
    function formatNote(value) {
        if (!value) return '';
        return value.note;
    }
    function formatDateVN(value) {
        if (!value) return '';
        const d = new Date(value);
        return d.toLocaleString('vi-VN');
    }
    function formatPriceVND(value){
        return vnd(value);
    }
    function queryParams(params) {
        params.search_by = $('#searchBy').val();
        params.q = $('#filterInput').val();
        return params;
    }
</script>
@stop
