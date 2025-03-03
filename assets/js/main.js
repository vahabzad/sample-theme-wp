var swiper = new Swiper('.swiper-logo', {
    spaceBetween: 30,
    centeredSlides: true,
    loop: true,
    speed: 4000,
    freeMode: false,
    autoplay: {
        delay: 20,
        disableOnInteraction: false
    },
    slidesPerView: 6, // Default slides per view for large screens
    breakpoints: {
        1358: {
            slidesPerView: 6,
            spaceBetween: 30
        },
        1200: {
            slidesPerView: 5,
            spaceBetween: 30
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 20
        },
        480: {
            slidesPerView: 3,
            spaceBetween: 10
        },
        320: {
            slidesPerView: 3,
            spaceBetween: 5
        }
    }
});
var swiper = new Swiper(".mySwiper", {
    slidesPerView: "auto",
    spaceBetween: 30,
    pagination: {
        el: ".pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".button-prev",
        prevEl: ".button-next",
    },
});
$(document).ready(function () {
    $.ajax({
        url: my_ajax_object.ajax_url,
        type: 'POST',
        data: {
            action: 'filter_projects',
            data : data
        },
        beforeSend: function () {
            $('.posts-project-pages').html('<p>در حال بارگذاری...</p>');
        },
        success: function (response) {
            $('.posts-project-pages').html(response);
        },
        error: function () {
            $('.posts-project-pages').html('<p>مشکلی رخ داد. لطفا دوباره امتحان کنید.</p>');
        }
    });
}