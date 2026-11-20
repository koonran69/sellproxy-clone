<script>
    var proxyList = new Swiper(".proxyList", {
        slidesPerView: 'auto',
        spaceBetween: 15,
        slidesPerGroup: 1,
        navigation: {
            nextEl: "#nextProxyBtn",
            prevEl: "#prevProxyBtn",
        },
    });


    // pricingLists
    var pricingList = new Swiper(".pricingList", {
        slidesPerView: 1,
        spaceBetween: 30,
        slidesPerGroup: 1,
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 4,
            }
        }
    });



    var pricingList = new Swiper(".partnerList", {
        slidesPerView: "auto",
        spaceBetween: 50,
        loop: true,
        autoplay: {
            delay: 0,
        },
        speed: 2000,
    });
</script>
