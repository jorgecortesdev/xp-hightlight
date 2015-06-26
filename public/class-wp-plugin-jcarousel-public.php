<?php
class WP_Plugin_JCarousel_Public {
    private $plugin_name;
    private $version;
    private $view;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->view = new WP_Plugin_JCarousel_View(basename(plugin_dir_path(__FILE__)));
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-plugin-jcarousel.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-plugin-jcarousel.js', array('jquery'), $this->version, false);
        wp_enqueue_script('jquery-carousel', plugin_dir_url(__FILE__) . 'js/jquery.jcarousel.min.js', array('jquery'), '0.3.0', false);
    }
    
    public function display() {
        $this->view->file('wp-plugin-jcarousel-view');

        $args = array(
            'category_name' => 'carousel',
            'showposts' => 24,
            'orderby' => 'rand'
        );
        $carousel_posts = new WP_Query($args);
        $posts = array();
        if ($carousel_posts->have_posts()) {
            while ($carousel_posts->have_posts()) {
                $carousel_posts->the_post();
                $post_thumbnail_id = get_post_thumbnail_id();
                $posts[] = array(
                    'permalink' => get_permalink(),
                    'title'     => get_the_title(),
                    'format'    => get_post_format(),
                    'thumbnail' => wp_get_attachment_image_src($post_thumbnail_id)
                );
            }
        }

        $this->view->set('posts', $posts);
        $this->view->render();

        wp_reset_postdata();
    }
}