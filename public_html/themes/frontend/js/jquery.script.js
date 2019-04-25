var nicescrolls = [];

$(function () {
    // $(".nicescroll").each(function () {
    //     var options = $(this).data();
    //     $(this).niceScroll(options);
    // });

    $(".nicescroll").niceScrollTrigger();

    // $(window).on("load resize scroll", function () {
        $(".owl-carousel").each(function () {
            var options = $(this).data();
            if (typeof options.autoheight !== undefined) {
                options.autoHeight = true;
                delete options.autoheight;
            }

            if (typeof options.autoplayspeed !== undefined) {
                options.autoPlaySpeed = true;
                delete options.autoplayspeed;
            }

            if ($(this).hasClass('news-carousel') || $(this).hasClass('header-slider'))
                options['navText'] = ["<i class='icon icon-chevron-right'></i>", "<i class='icon icon-chevron-left'></i>"];
            else
                options['navText'] = ["<i class='fa-icon-angle-left'></i>", "<i class='fa-icon-angle-right'></i>"];

            $(this).owlCarousel(options);
        });
    // });

    // news carousel initialize
    if ($(".news-carousel").length) {
        $(".news-carousel .owl-next").css({left: $(".news-carousel .owl-dot:last-of-type").offset().left - 45 - $(".container").offset().left});
        $(".news-carousel .owl-prev").css({left: $(".news-carousel .owl-dot:first-of-type").offset().left + 10 - $(".container").offset().left});
    }

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
    }).on('click', '.panel-title', function (event) {
        $('.overlay').toggle();
        var This = $(event.target);
        var panel_parent = This.parents('.panel');
        var el_id = This.parents('.panel').find('div.collapse').attr('id');
        $('#' + el_id).collapse();
        if (panel_parent.hasClass('-z-index')) {
            panel_parent.removeClass('-z-index')
        }
        else {
            panel_parent.addClass('-z-index')
        }
    }).on('click', '#sidebarCollapse', function () {
        // open sidebar
        $('#sidebar').addClass('active');
        // fade in the overlay
        $('.sidebar--overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    }).on('click', '#dismiss, .sidebar--overlay', function () {
        // hide sidebar
        $('#sidebar').removeClass('active');
        // hide overlay
        $('.sidebar--overlay').removeClass('active');
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

// hide or show the main navbar base on page scroll : start
// var header_height = $('header').height();
var header_height = 160;
var headerTag = $('header');

$(window).on("load resize scroll", function () {
    var width = $(this).width();
    console.log(width);
    if (width > 992) {
        var scroll = $(window).scrollTop();
        if (scroll > header_height) {
            $('header > .container').hide();
            $('header .navbar > li > a').addClass('text-white');
            headerTag.addClass('smallHeader');
            // $('li.dropdown').removeClass("open");
        }
        else {
            $('header > .container').show();
            headerTag.removeClass('smallHeader');
            $('header .navbar > li > a').removeClass('text-white');

        }
    }
    // header_height = scroll;
});
// hide or show the main navbar base on page scroll : end


$('#dismiss, .screen-overlay').on('click', function () {
    $('nav#sidebar').removeClass('active');
    $('.screen-overlay').removeClass('active');
});

$('#sidebarCollapse').on('click', function () {
    $('#sidebar').addClass('active');
    $('.screen-overlay').addClass('active');
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
});
