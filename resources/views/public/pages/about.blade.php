@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle($page->title_seo) }}
@endsection

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('public/assets/css/about.css') }}?v={{ time() }}">
@endpush

@section('content')
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <section class="message-user">
                        <div class="message-avatar ">
                            <div class="message-avatar-wrapper">
                                <a href="#" class="avatar-ms avatar--m">
                                    <img src="{{ asset('public/assets/images/79913.jpg') }}">
                                </a>
                            </div>
                        </div>
                        <div class="message-userDetails">
                            <h4 class="message-name">
                                <a href="#" class="username">
                                    <span class="username">YouAndIVN</span>
                                </a>
                            </h4>
                            <h5 class="userTitle">Hero</h5>
                            <div class="userBanner lightGreen">
                                <span class="userBanner-before"></span>
                                <strong>Verified</strong>
                                <span class="userBanner-after"></span>
                            </div>
                            <div class="userBanner silver">
                                <span class="userBanner-before"></span>
                                <strong>Trusted 3</strong>
                                <span class="userBanner-after"></span>
                            </div>
                        </div>

                        <div class="message-userExtras">
                            <dl class="pairs pairs--justified">
                                <dt>Joined:</dt>
                                <dd>Aug 17, 2014</dd>
                            </dl>

                            <dl class="pairs pairs--justified">
                                <dt>Messages:</dt>
                                <dd>2,126</dd>
                            </dl>

                            <dl class="pairs pairs--justified">
                                <dt>Reactions:</dt>
                                <dd>1,787</dd>
                            </dl>

                            <dl class="pairs pairs--justified" data-field="credit_bar">
                                <div class="credit-bar" title="MR: 2.800">
                                    <a href="#">
                                        <img src="data:image/png;base64,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">
                                    </a>
                                    <span class="fauxBlockLink-blockLink u-concealed">
                                        2.800
                                    </span>

                                    <div class="credit-progress">
                                        <div class="credit-progress-bar red" style="width: 5%"></div>
                                    </div>
                                </div>
                            </dl>

                            <div class="mmo4me-insurance-block center-box">

                                <a href="#" class="u-concealed">
                                    <div class="insuree-bar" title="Bảo hiểm: $740.00">
                                        <span style="width: 80%;" class="orange"><span>$740.00</span></span>
                                    </div>
                                </a>
                                <a class="insurance-stamp" href="#" target="_blank">
{{--                                    <i class="ti ti-rubber-stamp"></i>--}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M312 201.8c0-17.4 9.2-33.2 19.9-47C344.5 138.5 352 118.1 352 96c0-53-43-96-96-96s-96 43-96 96c0 22.1 7.5 42.5 20.1 58.8c10.7 13.8 19.9 29.6 19.9 47c0 29.9-24.3 54.2-54.2 54.2L112 256C50.1 256 0 306.1 0 368c0 20.9 13.4 38.7 32 45.3L32 464c0 26.5 21.5 48 48 48l352 0c26.5 0 48-21.5 48-48l0-50.7c18.6-6.6 32-24.4 32-45.3c0-61.9-50.1-112-112-112l-33.8 0c-29.9 0-54.2-24.3-54.2-54.2zM416 416l0 32L96 448l0-32 320 0z"/></svg>
                                </a>
                            </div>

                            <dl class="pairs pairs--justified" data-field="service_details">
                                <div class="user-service-bar">
                                    <div>Services</div>
                                    <ul>
                                        <li>

                                            <a href="https://mmo4me.com/threads/ssh-all-country-chat-luong-tot-nhat-gia-re-nhat-inter-10k-vcb-dab-vtb-acb-wmz-pm-pp-bao-kim.279037/" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                                                <strong title="Service: SSH">SSH</strong>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="https://mmo4me.com/threads/youandivn-trung-gian-24-7.425637/" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                                                <strong title="Service: Trung Gian">Trung Gian</strong>
                                            </a>
                                        </li>

                                        <li>

                                            <a href="https://mmo4me.com/threads/dai-ly-chinh-thuc-cua-922proxy-piaproxy-abcproxy-lunaproxy-chinh-hang-gia-re-youandivn.426142/" target="_blank">
                                                <i class="ti ti-external-link"></i>
                                                <strong title="Service: Socks 911">Socks 911</strong>
                                            </a>

                                        </li>

                                    </ul>
                                </div>
                            </dl>

                            <div class="memberHeader-stats mmo4me-reputaion-member-stats-mini">
                                <div class="pairJustifier">
                                    <dl class="pairs pairs--rows pairs--rows--centered">
                                        <dt title="Trusted points">
                                            <i class="ti ti-circle-dashed-check"></i>
                                        </dt>
                                        <dd>
                                            <span data-xf-click="overlay" class="u-concealed">
                                                -
                                            </span>
                                        </dd>
                                    </dl>
                                    <div class="vertical-seperator"></div>
                                    <dl class="pairs pairs--rows pairs--rows--centered">
                                        <dt title="Evidences">
                                            <svg class="money-bill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 64C28.7 64 0 92.7 0 128L0 384c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-256c0-35.3-28.7-64-64-64L64 64zm64 320l-64 0 0-64c35.3 0 64 28.7 64 64zM64 192l0-64 64 0c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64l0 64-64 0zm64-192c-35.3 0-64-28.7-64-64l64 0 0 64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
                                        </dt>
                                        <dd>

                                            <span class="fauxBlockLink-blockLink u-concealed">
                                                1
                                            </span>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
{{--                            <dl class="pairs pairs--justified">--}}
{{--                                <div class="user-social-bar">--}}

{{--                                    <a target="_blank" title="Call me!" href="tel:0708762402"><img alt="Call me!" src="{{ asset('public/assets/images/phone1.png') }}"></a>--}}

{{--                                    <a target="_blank" title="Call me!" href="https://zalo.me/0708762402"><img alt="Call me!" src="{{ asset('public/assets/images/zalo1.png') }}"></a>--}}

{{--                                    <a target="_blank" title="Follow me on Facebook" href="https://www.facebook.com/ssh.sell.3/"><img alt="Follow me on Facebook" src="{{ asset('public/assets/images/facebook1.png') }}"></a>--}}

{{--                                    <a target="_blank" title="Chat with me via Teams" href="https://teams.microsoft.com/l/chat/0/0?users=live:nickchatdelamgi@outlook.com.vn?chat" data-blank-handler="true"><img alt="Chat with me via Teams" src="{{ asset('public/assets/images/teams.png') }}"></a>--}}
{{--                                </div>--}}
{{--                            </dl>--}}
                        </div>
                        <span class="message-userArrow"></span>
                    </section>
                </div>
                <div class="col-md-10">
                    <div class="content">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    @include('public.scripts.swiper')
@endpush
