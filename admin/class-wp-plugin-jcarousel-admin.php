<?php
class WP_Plugin_JCarousel_Admin {
    private $plugin_name;
    private $version;
    private $view;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->view = new WP_Plugin_JCarousel_View(basename(plugin_dir_path(__FILE__)));
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-plugin-jcarousel-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_scripts($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-plugin-jcarousel-admin.js', array('jquery'), $this->version, false);
    }
}