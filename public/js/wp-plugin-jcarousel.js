(function($) {
    $(function() {
        $('.jcarousel').jcarousel({
            scroll: 6,
            wrap: 'circular'
        });

        $('.jcarousel-control-prev')
            .jcarouselControl({
                target: '-=6'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=6'
            });

        $(window).resize(function() {
            var number_of_elements = Math.abs($(window).width() / 143);
            $('.jcarousel-control-prev')
                .jcarouselControl({
                    target: '-=' + number_of_elements
                });

            $('.jcarousel-control-next')
                .jcarouselControl({
                    target: '+=' + number_of_elements
                });
        });
    });
})(jQuery);