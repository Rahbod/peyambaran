var nicescrolls = [];

$(function() {
    // $(".nicescroll").each(function () {
    //     var options = $(this).data();
    //     $(this).niceScroll(options);
    // });

    $(".nicescroll").niceScrollTrigger();

    $(".owl-carousel").each(function () {
        var options = $(this).data();
        if ($(this).hasClass('news-carousel'))
            options['navText'] = ["<i class='icon icon-chevron-right'></i>", "<i class='icon icon-chevron-left'></i>"];
        $(this).owlCarousel(options);
    });

    // news carousel initialize
    $(".news-carousel .owl-next").css({left: $(".news-carousel .owl-dot:last-of-type").offset().left - 45 - $(".container").offset().left});
    $(".news-carousel .owl-prev").css({left: $(".news-carousel .owl-dot:first-of-type").offset().left + 10 - $(".container").offset().left});

    // $(".news-carousel").css({right: $(".container").offset().left + 15, width: $(".container").width()});
    // var dotsCount = $(".owl-carousel .owl-dot").length;
    // $(".owl-carousel .owl-dots").css("margin-left", -((dotsCount * 16 + 20) / 2));

    $('.mobile-menu-trigger').on('click', function (e) {
        e.preventDefault();
        $('.overlay').fadeIn('fast', function () {
            $('.menu-container .menu').addClass('open');
        });
    });

    $('.overlay').on('click', function (e) {
        e.preventDefault();
        $('.menu-container .menu').removeClass('open');
        $(this).hide();
    });

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 10)
            $('header').addClass('shadow');
        else
            $('header').removeClass('shadow');
    });

    $("body").on("mouseover", "li.dropdown", function () {
        $(this).addClass("open");
    }).on("mouseleave", "li.dropdown", function () {
        $(this).removeClass("open");
    });
});
(function () {
    /// define functions
    $.fn.niceScrollTrigger = function (refresh) {
        this.each(function () {
            var options = $(this).data();
            $.each(options, function (key, value) {
                if (typeof value === "string" && value.indexOf("js:") !== -1)
                    options[key] = JSON.parse(value.substr(3));
            });
            if (refresh === true)
                $(this).getNiceScroll().remove();

            var instance = $(this).niceScroll(options);
            // if($(this).attr('id')=='scroll-box')
            //     console.log(instance);
            nicescrolls.push({id: $(this).attr('id'), instance: instance});
        });
    };
})(jQuery);