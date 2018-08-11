jQuery(document).ready(function ($) {

    $('#filter').change(function () {
        var filterClass = $(this).val();
    });

    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 4,
        slidesPerColumn: 1,
        paginationClickable: true,
        spaceBetween: 0,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            1024: {
              slidesPerView: 4,
              spaceBetween: 0,
            },
            768: {
              slidesPerView: 3,
              spaceBetween: 0,
            },
            640: {
              slidesPerView: 2,
              spaceBetween: 0,
            },
            320: {
              slidesPerView: 1,
              spaceBetween: 0,
            }
        }
    });

    $('#filter').change(function () {
        var filter = $(this).val();
        var slidesxcol;
        $(".categories span")
        $(".categories span").removeClass("active");
        $(this).addClass("active");
          
        if(filter=="all"){
            $("[data-filter]").removeClass("non-swiper-slide").addClass("swiper-slide").show('slow');
            swiper.destroy();
            swiper = new Swiper('.swiper-container', {
                pagination: '.swiper-pagination',
                slidesPerView: 4,
                slidesPerColumn: 1,
                paginationClickable: true,
                spaceBetween: 0,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    1024: {
                      slidesPerView: 4,
                      spaceBetween: 0,
                    },
                    768: {
                      slidesPerView: 3,
                      spaceBetween: 0,
                    },
                    640: {
                      slidesPerView: 2,
                      spaceBetween: 0,
                    },
                    320: {
                      slidesPerView: 1,
                      spaceBetween: 0,
                    }
                }
            });
        }
        else {
            $(".swiper-slide").not("[data-filter='"+filter+"']").addClass("non-swiper-slide").removeClass("swiper-slide").hide();
            $("[data-filter='"+filter+"']").removeClass("non-swiper-slide").addClass("swiper-slide").attr("style", null).show('slow');
            swiper.destroy();
            swiper = new Swiper('.swiper-container', {
                pagination: '.swiper-pagination',
                slidesPerView: 4,
                slidesPerView: 4,
                slidesPerColumn: 1,
                paginationClickable: true,
                spaceBetween: 0,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    1024: {
                      slidesPerView: 4,
                      spaceBetween: 0,
                    },
                    768: {
                      slidesPerView: 3,
                      spaceBetween: 0,
                    },
                    640: {
                      slidesPerView: 2,
                      spaceBetween: 0,
                    },
                    320: {
                      slidesPerView: 1,
                      spaceBetween: 0,
                    }
                }
            });
        }
    });

    $( '.swipebox' ).swipebox();
        
});
