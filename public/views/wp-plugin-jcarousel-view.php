<!-- Carousel -->
<div class="wp-plugin-jcarousel-highlights">
    <div class="jcarousel-container">
        <div class="jcarousel" data-jcarousel="true">
            <ul>
                <?php foreach($posts as $post) : ?>
                <li>
                    <?php if ($post['format'] == 'gallery') : ?>
                    <div class="type">
                        <div class="tail"></div>
                        <div class="label">gallery</div>
                    </div>
                    <?php endif; ?>
                    <div class="thumb-container">
                        <a class="wpptrack" data-post-id="<?php echo $post['id']; ?>" data-section-id="1" href="<?php echo $post['permalink'] ?>"><img width="<?php echo $post['thumbnail'][1] ?>" height="<?php echo $post['thumbnail'][2] ?>" src="<?php echo $post['thumbnail'][0] ?>" /></a>
                        <span><a href="<?php echo $post['permalink'] ?>"><?php echo $post['title'] ?></a></span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="jcarousel-control jcarousel-control-prev" data-jcarouselcontrol="true"></div>
    <div class="jcarousel-control jcarousel-control-next" data-jcarouselcontrol="true"></div>
</div>
<!-- .Carousel -->