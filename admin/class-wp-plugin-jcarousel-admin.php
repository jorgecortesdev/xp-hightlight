<?php
class WP_Plugin_JCarousel_Admin {
    private $plugin_name;
    private $version;
    private $view;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->view        = new WP_Plugin_JCarousel_View(basename(plugin_dir_path(__FILE__)));
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-plugin-jcarousel-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_scripts($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-plugin-jcarousel-admin.js', array('jquery'), $this->version, false);
    }

    public function post() {
        add_action('add_meta_boxes', array($this, 'post_meta_box'));
        add_action('save_post', array($this, 'post_save'));
    }

    public function post_meta_box($post_type) {
        $post_types = array('post');
        if (in_array($post_type, $post_types)) {
            add_meta_box(
                'wpp_highlights',
                'WPP Highlights',
                array($this, 'post_display_meta_box'),
                $post_type,
                'advanced',
                'high'
            );
        }
    }

    public function post_display_meta_box($post) {
        $this->view->file('wp-plugin-jcarousel-metabox');

        wp_nonce_field('wpph_custom_box', 'wpph_custom_box_nonce');

        $value = get_post_meta($post->ID, '_wpph', true);

        $this->view->set('value', $value);
        $this->view->render();
    }

    public function post_save($post_id) {
        if (!isset($_POST['wpph_custom_box_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['wpph_custom_box_nonce'];

        if (!wp_verify_nonce($nonce, 'wpph_custom_box')) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }

        update_post_meta($post_id, '_wpph', $_POST['wp_plugin_jcarousel_checkbox']);
    }

    public function posts_list() {
        add_action('restrict_manage_posts', array($this, 'posts_filter_dropdown'));
        add_filter('request', array($this, 'posts_filter'));
    }

    public function posts_filter_dropdown() {
        if ( $GLOBALS['pagenow'] === 'upload.php') {
            return;
        }

        $this->view->file('wp-plugin-jcarousel-metabox');
        $this->view->set('value', isset($_GET['wp_plugin_jcarousel_checkbox']));
        $this->view->render();
    }

    function posts_filter($vars) {
        if (!isset($_GET['wp_plugin_jcarousel_checkbox'])) {
            return $vars;
        }

        $vars = array_merge(
            $vars,
            array(
               'meta_query' => array(
                    array(
                        'key'     => '_wpph',
                        'value'   => '1',
                        'compare' => '=',
                    ),
                )
            )
        );

        return $vars;
    }
}