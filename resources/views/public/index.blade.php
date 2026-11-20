@extends('public.layouts.master')

@section('title')
    {{ \App\Core\Supports\MetaHelper::getTitle() }}
@endsection

@section('content')
    <div class="bg-home"></div>

    @include('public.partials.hero')

    @include('public.partials.second')

    @include('public.partials.third')

    @include('public.partials.fourth')

    @include('public.partials.fifth')

    @include('public.partials.sixth')

    @include('public.partials.seventh')

    @include('public.partials.qa')

    @include('public.partials.modal_register')

{{--    @include('public.partials.modal_event')--}}
@endsection


@push('js')
    @include('public.scripts.swiper')
    <script>
        $(".variation-select").on('change',function(e) {
            let selectedValue = $(this).val();
            let selectedPrice = $(this).find("option:selected").data("price");
            let variationProxyId = selectedValue;
            let selectedProxyId = $(this).find("option:selected").data("proxy-id");
            $("#proxy_item_" + selectedProxyId).find(".variation-price").stop().text(number_format(selectedPrice) + 'đ');
            $("#proxy_item_" + selectedProxyId).find("input[name='proxy_variation_id']").stop().val(variationProxyId);
        });

        $(".cart-btn").on("click", function(e) {
            requestAddCart(this, "addToCart");
        })

        $(".buy-btn").on("click", function(e) {
            requestAddCart(this, "buyNow");
        })

        function requestAddCart(t, type) {
            var proxy_id = $(t).parents("tr").find("input[name='proxy_id']").val();
            var proxy_variation_id = $(t).parents("tr").find("input[name='proxy_variation_id']").val();
            var url = '{{ route('cart.addToCart') }}';
            var data = { 'proxy_id': proxy_id,
                'proxy_variation_id': proxy_variation_id,
                'type': type
            };
            $.ajax({
                method: 'post',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: data
            }).done(function(res) {
                if(res.status) {
                    $("#cart_count_total").text(res.count);
                    if(res.type && res.type == 'buyNow') {
                        window.location.href = res.redirect_url;
                    } else {
                        msgSuccess(window.__trans("Thêm giỏ hàng thành công"));
                    }
                }
            }).fail(function(res) {

            });
        }

        document.getElementById('searchInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                const keyword = this.value.trim();
                if (keyword) {
                    window.location.href = '?keyword=' + encodeURIComponent(keyword);
                }
            }
        });

        @if((isset($filter['type_id']) && $filter['type_id'] != 'all') || isset($filter['keyword']) && $filter['keyword'] != 'all')
        let thirdSection = $("#third-section");
        let position = thirdSection.offset().top;
        window.scrollTo(0, position);
        @endif
    </script>
@endpush
