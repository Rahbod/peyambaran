var nicescrolls = [];

$(function () {
    $('.digitFormat').digitFormat();
    $('.numberFormat').numericFormat();
    $('.dateFormat').dateFormat();

    $("body").on("keyup", '.digitFormat', function () {
        $(this).digitFormat();
    }).on("change", '.digitFormat', function () {
        $(this).digitFormat();
    }).on("keyup", '.numberFormat', function () {
        $(this).numericFormat();
    }).on("change", '.numberFormat', function () {
        $(this).numericFormat();
    }).on("keyup", '.dateFormat', function () {
        $(this).dateFormat();
    }).on("change", '.dateFormat', function () {
        $(this).dateFormat();
    });

    if($.fn.datepicker) {
        $(".datepicker").each(function () {
            var options = $(this).data('datepicker');
            $(this).datepicker(options);
        });
    }


    // $(window).on("load resize scroll", function () {
        $(".owl-carousel").each(function () {
            var options = $(this).data(),
                allOptions = $(this).data('owlcarousel');
            delete options.owlcarousel;

            if (typeof allOptions === "string" && allOptions.indexOf("js:") !== -1)
                allOptions = JSON.parse(allOptions.substr(3));

            if (typeof options.autoheight !== undefined) {
                options.autoHeight = true;
                delete options.autoheight;
            }

            // if (typeof options.autoplayspeed !== undefined) {
            //     options.autoPlaySpeed = options.autoplayspeed;
            //     options.autoplay = true;
            //     delete options.autoplayspeed;
            // }

            if ($(this).hasClass('news-carousel') || $(this).hasClass('header-slider'))
                options['navText'] = ["<i class='icon icon-chevron-right'></i>", "<i class='icon icon-chevron-left'></i>"];
            else
                options['navText'] = ["<i class='fa-icon-angle-left'></i>", "<i class='fa-icon-angle-right'></i>"];

            if(typeof allOptions !== undefined)
                options = $.extend(options, allOptions);

            $(this).owlCarousel(options);
        });
    // });

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

    var contentBodyH;
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 10)
            $('header').addClass('shadow');
        else
            $('header').removeClass('shadow');

        if($(window).width() < 768){
            if($(".content-body, #news-list").length) {
                contentBodyH = $(".content-body, #news-list").offset().top + $(".content-body, #news-list").height();
                if ($(this).scrollTop() > $(".content-header").height())
                    $('body').addClass('scroll');
                else
                    $('body').removeClass('scroll');

                if ($(this).scrollTop() > (contentBodyH - 300))
                    $('body').addClass('stop');
                else
                    $('body').removeClass('stop');
            }
        }

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

    $(window).on("load resize", function () {
        // news carousel initialize
        if ($(".news-carousel").length) {
            $(".news-carousel .owl-next").css({left: $(".news-carousel .owl-dot:last-of-type").offset().left - 45 - (($(window).width() - $(".container").width() - 30)/2)});
            $(".news-carousel .owl-prev").css({left: $(".news-carousel .owl-dot:first-of-type").offset().left + 10 - (($(window).width() - $(".container").width() - 30)/2)});
        }
        // if($(window).width()>768)
            // $(".nicescroll").each(function () {
            //     var options = $(this).data();
            //     $.each(options, function (key, value) {
            //         if (typeof value === "string" && value.indexOf("js:") !== -1)
            //             options[key] = JSON.parse(value.substr(3));
            //     });
            //     // if (refresh === true)
            //     //     $(this).getNiceScroll().remove();
            //
            //     var instance = $(this).niceScroll(options);
            //     // if($(this).attr('id')=='scroll-box')
            //     //     console.log(instance);
            //     nicescrolls.push({id: $(this).attr('id'), instance: instance});
            // });
    });
});
// hide or show the main navbar base on page scroll : start
// var header_height = $('header').height();
var header_height = 160;
var headerTag = $('header');

$(window).on("load resize scroll", function () {
    var width = $(this).width();
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
    $('body').removeClass('overflow-fix');
});

$('#sidebarCollapse').on('click', function () {
    $('#sidebar').addClass('active');
    $('.screen-overlay').addClass('active');
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    $('body').addClass('overflow-fix');
});


$.fn.digitFormat = function () {
    return this.each(function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            if (parseInt(value) === 0)
                return value;
            else if (value.indexOf(".") >=0) {
                return value;
                var arr = value.split('.');
                console.log(arr);
                value = arr[0]
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+arr[1];
                return value;
            }
            return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
};

$.fn.numericFormat = function () {
    return this.each(function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            return value
                .replace(/\D/g, "");
        });
    });
};

$.fn.dateFormat = function () {
    return this.each(function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        $(this).val(function (index, value) {
            return value
                .replace(/[0-9\/]*/g, "");
        });
    });
};