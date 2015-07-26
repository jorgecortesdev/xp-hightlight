<div class="xp-hightlight">
    <a href="#" class="previous text-hide">Previous</a>
    <div class="content">
        <?php foreach($posts as $post) : ?>
        <a href="<?php echo $post['permalink'] ?>"><?php echo $post['thumbnail'] ?></a>
        <span><a href="<?php echo $post['permalink'] ?>"><?php echo $post['title'] ?></a></span>
        <?php endforeach; ?>
    </div>
    <a href="#" class="next text-hide">Next</a>
</div>

<script>
(function($) {
    $('.xp-hightlight .content').slick({
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 1,
        centerMode: true,
        prevArrow: $('.xp-hightlight .previous'),
        nextArrow: $('.xp-hightlight .next')
    });
})(jQuery);
</script>