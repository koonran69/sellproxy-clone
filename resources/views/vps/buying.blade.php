@extends("vps.layout")
@section('content')
    <div class="card">
        <div class="card-body pt-0">
            <h3 class="page-title">Danh sách gói dịch vụ VPS {{$getDetail['name']}}</h3>
            <div class="proxy-static-list proxy-static">
                <div class="p-3 mb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-12">
                            <div class="row g-2">
                                @foreach($packages as $package)
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="card card-item-service">
                                            <div class="card-body card-body-item-service p-3">
                                                <div class="flex justify-content-center text-center">
                                                    <h3 class="text-primary-bg">{{$package['name']}}</h3>
                                                </div>
                                                <div class="flex justify-content-center text-center">
                                                    <h3
                                                        class="price m-0">{{number_format((int) str_replace(',', '', $package['price']) + ((int) str_replace(',', '', $package['price']) * ($feePercent/100)))}} VNĐ</h3> <span
                                                        class="fw-bold text-secondary">/Tháng</span>
                                                </div>
                                                <div class="card-body p-3">
                                                    <ul class="list-unstyled list-provided lh-lg">
                                                        <li class="fw-medium mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20" fill="none" stroke="currentColor"
                                                                 stroke-width="2" class="icon me-1 text-success">
                                                                <path d="M5 12l5 5l10 -10"></path>
                                                            </svg>
                                                            CPU: {{$package['cpu']}}
                                                        </li>
                                                        <li class="fw-medium mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20" fill="none" stroke="currentColor"
                                                                 stroke-width="2" class="icon me-1 text-success">
                                                                <path d="M5 12l5 5l10 -10"></path>
                                                            </svg>
                                                            RAM: {{$package['ram']}}
                                                        </li>
                                                        <li class="fw-medium mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20" fill="none" stroke="currentColor"
                                                                 stroke-width="2" class="icon me-1 text-success">
                                                                <path d="M5 12l5 5l10 -10"></path>
                                                            </svg>
                                                            SSD: {{$package['ssd']}}
                                                        </li>
                                                        <li class="fw-medium mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20" fill="none" stroke="currentColor"
                                                                 stroke-width="2" class="icon me-1 text-success">
                                                                <path d="M5 12l5 5l10 -10"></path>
                                                            </svg>
                                                            IPv4: {{$package['ipv4']}}
                                                        </li>
                                                        <li class="fw-medium mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20" fill="none" stroke="currentColor"
                                                                 stroke-width="2" class="icon me-1 text-success">
                                                                <path d="M5 12l5 5l10 -10"></path>
                                                            </svg>
                                                            Băng thông: {{$package['bandwidth']}}
                                                        </li>
                                                        <li class="fw-medium mb-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                 height="20" fill="none" stroke="currentColor"
                                                                 stroke-width="2" class="icon me-1 text-success">
                                                                <path d="M5 12l5 5l10 -10"></path>
                                                            </svg>
                                                            Ethernet port: {{$package['ethernet_port']}}
                                                        </li>
                                                    </ul>
                                                    <div class="d-flex align-items-center text-center">
                                                        @if($package['status'] == 'sold_out')
                                                            <button class="btn btn-danger w-100 prx-buy disabled">Đã bán hết</button>
                                                        @else
                                                            @if($type === 'gpu')
                                                                <a href="{{route('vps.buyingOrderGPU',['id'=>$package['id']])}}" class="btn btn-danger w-100 prx-buy">Mua hàng</a>
                                                            @else
                                                                <a href="{{route('vps.buyingOrder',['nation'=>$getDetail['symbol'],'id'=>$package['id']])}}" class="btn btn-danger w-100 prx-buy">Mua hàng</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@stop


