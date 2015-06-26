(function($) {
    $(function() {
        $('.wp-plugin-jcarousel-highlights .jcarousel').jcarousel({
            scroll: 6,
            wrap: 'circular'
        });

        $('.wp-plugin-jcarousel-highlights .jcarousel-control-prev')
            .jcarouselControl({
                target: '-=6'
            });

        $('.wp-plugin-jcarousel-highlights .jcarousel-control-next')
            .jcarouselControl({
                target: '+=6'
            });

        $(window).resize(function() {
            var number_of_elements = Math.abs($(window).width() / 143);
            $('.wp-plugin-jcarousel-highlights .jcarousel-control-prev')
                .jcarouselControl({
                    target: '-=' + number_of_elements
                });

            $('.wp-plugin-jcarousel-highlights .jcarousel-control-next')
                .jcarouselControl({
                    target: '+=' + number_of_elements
                });
        });
    });
})(jQuery);