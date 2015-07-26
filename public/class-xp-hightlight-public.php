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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/xp-hightlight.css', array(), $this->version, 'all');
        wp_enqueue_style('slick', plugin_dir_url(__FILE__)            . 'css/slick.css', array(), $this->version, 'all');
        wp_enqueue_style('slick-theme', plugin_dir_url(__FILE__)      . 'css/slick-theme.css', array('slick'), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script('slick', plugin_dir_url(__FILE__)            . 'js/slick.min.js', array('jquery'), '1.5.7', false);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/xp-hightlight.js', array('slick'), $this->version, false);
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
                    'thumbnail' =>  get_the_post_thumbnail(get_the_ID(), 'xp-hightlight')
                );
            }
        }

        $this->view->set('posts', $posts);
        $this->view->render();

        wp_reset_postdata();
    }

    public function add_featured_image_support() {
        $supported_types = get_theme_support('post-thumbnails');

        if($supported_types === false) {
            add_theme_support('post-thumbnails');
        }

        add_image_size('xp-hightlight', 150, 150, true);
    }
}