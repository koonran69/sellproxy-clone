<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item d-lg-none" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- LOGO -->
            <div class="navbar-brand-box d-lg-block d-none">
                <a href="{{ route('home') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('public/assets/images/logo_desktop.png') }}" alt="" height="24">
                            </span>
                    <span class="logo-lg">
                                <img src="{{ asset('public/assets/images/logo_desktop.png') }}" alt="" height="36">
                            </span>
                </a>

                <a href="{{ route('home') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{asset('public/assets/images/logo-sm.svg') }}" alt="" height="24">
                            </span>
                    <span class="logo-lg">
                                <img src="{{asset('public/assets/images/logo-sm.svg') }}" alt="" height="24"> <span
                                class="logo-txt">Sellsocks247</span>
                            </span>
                </a>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown ms-2">
                <form class="p-3">
                    <div class="navbar-header-search form-group m-0">
                        <div class="input-group">
                            <button class="btn" type="submit">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                            <input type="text" class="form-control" placeholder="Search"
                                   aria-label="Search Result">
                        </div>
                    </div>
                </form>
            </div>

            <div class="dropdown d-inline-block d-none">
                <button type="button" class="btn header-item noti-icon position-relative"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill">5</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Thông báo </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small text-reset text-decoration-underline"> Chưa xem (3)</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="{{asset('public/proxyhome/assets/images/avatar.jpg') }}" class="rounded-circle avatar-sm" alt="user-pic">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">James Lemire</h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">It will seem like simplified English.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>1 hour ago</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="bx bx-cart"></i>
                                            </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your order is placed</h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span>3 min ago</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i>
                            <span>Xem thêm..</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
