<?php
class XP_Hightlight_Public {
    private $plugin_name;
    private $version;
    private $view;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->view        = new XP_Hightlight_View(basename(plugin_dir_path(__FILE__)));
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/slick.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/slick-theme.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/xp-hightlight.js', array('jquery'), $this->version, false);
        wp_enqueue_script('jquery-carousel', plugin_dir_url(__FILE__) . 'js/slick.min.js', array('jquery'), '0.3.0', false);
    }
    
    public function display() {
        $this->view->file('xp-hightlight-view');

        $args = array(
            'post_status' => 'publish',
            'showposts'   => 12,
            'orderby'     => 'rand',
            'meta_query'  => array(
            array(
                    'key'     => '_xph',
                    'value'   => '1',
                    'compare' => '=',
                ),
            )
        );
        $hightlight_posts = new WP_Query($args);
        $posts = array();
        if ($hightlight_posts->have_posts()) {
            while ($hightlight_posts->have_posts()) {
                $hightlight_posts->the_post();
                $post_thumbnail_id = get_post_thumbnail_id();
                $posts[] = array(
                    'id'        => get_the_ID(),
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