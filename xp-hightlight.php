<?php
/**
 * Plugin Name: XP Hightlight
 * Description: Add a hightlight section for wordpress
 * Plugin URI: http://www.dacure.com
 * Author: Jorge Cortes
 * Author URI: http://www.dacure.com
 * Version: 1.0
 */

if (!defined('WPINC')) {
    die;
}

function activate_xp_hightlight() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-xp-hightlight-activator.php';
    XP_Hightlight_Activator::activate();
}

function deactivate_xp_hightlight() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-xp-hightlight-deactivator.php';
    XP_Hightlight_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_xp_hightlight');
register_deactivation_hook(__FILE__,'deactivate_xp_hightlight');

require plugin_dir_path( __FILE__ ) . 'includes/class-xp-hightlight.php';

function run_xp_hightlight() {
    $plugin = new XP_Hightlight();
    $plugin->run();
}

run_xp_hightlight();