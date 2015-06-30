<?php
class WP_Plugin_JCarousel {
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'wp-plugin-jcarousel';
        $this->version     = '1.0.0';

        $this->load_dependencies();
        $this->define_public_hooks();

        if (is_admin()) {
            $this->define_admin_hooks();
        }
    }

    public function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-plugin-jcarousel-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-plugin-jcarousel-view.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wp-plugin-jcarousel-public.php';

        if (is_admin()) {
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wp-plugin-jcarousel-admin.php';
        }

        $this->loader = new WP_Plugin_JCarousel_Loader();
    }

    public function define_admin_hooks() {
        $plugin_admin = new WP_Plugin_JCarousel_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        // $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('load-post.php', $plugin_admin, 'post');
        $this->loader->add_action('load-post-new.php', $plugin_admin, 'post');
        $this->loader->add_action('admin_init', $plugin_admin, 'posts_list');
    }

    public function define_public_hooks() {
        $plugin_public = new WP_Plugin_JCarousel_Public($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('wp-plugin-jcarousel-display', $plugin_public, 'display');
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_loader() {
        return $this->loader;
    }

    public function get_version() {
        return $this->version;
    }
}