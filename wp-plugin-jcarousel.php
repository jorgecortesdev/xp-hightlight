<?php
/**
 * Plugin Name: WP Plugin JCarousel
 * Description: Add a carousel using jcarousel
 * Plugin URI: http://www.dacure.com
 * Author: Jorge Cortes
 * Author URI: http://www.dacure.com
 * Version: 1.0
 */

if (!defined('WPINC')) {
    die;
}

function activate_wp_plugin_jcarousel() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-plugin-jcarousel-activator.php';
    WP_Plugin_JCarousel_Activator::activate();
}

function deactivate_wp_plugin_jcarousel() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-plugin-jcarousel-deactivator.php';
    WP_Plugin_JCarousel_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_plugin_jcarousel');
register_deactivation_hook(__FILE__,'deactivate_wp_plugin_jcarousel');

require plugin_dir_path( __FILE__ ) . 'includes/class-wp-plugin-jcarousel.php';

function run_wp_plugin_jcarousel() {
    $plugin = new WP_Plugin_JCarousel();
    $plugin->run();
}

run_wp_plugin_jcarousel();