<?php
/*
Plugin Name: DD WooCommerce Quick View
Plugin URI: #
Description: WooCommerce Quick View plugin for practice plugin development
Version: 1.0
Author: Danil Derevyanchenko
Author URI: #
Licence: GPLv2 or later
Text Domain: ddQuickView
Domain Path: /lang
*/ 

if( ! defined('ABSPATH') ) {
    die;
}

define('DDQUICKVIEW_PATH', plugin_dir_path(__FILE__));


require DDMOVIE_PATH . 'inc/helpers.php';

// if ( ! class_exists('ddMovieCpt') ) {
    // require DDMOVIE_PATH . 'inc/class-ddmovie-cpt.php';
// }

class ddQuickView 
{
    public function __construct() 
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend']);
    }

         // enqueue admin styles and scripts method
         public function enqueue_admin() {
            // wp_enqueue_style('ddBooking_style_admin', plugins_url( '/assets/css/admin/style.css', __FILE__ ));
            // wp_enqueue_script('ddBooking_script_admin', plugins_url( '/assets/js/admin/scripts.js', __FILE__ ), array('jquery'), '1.0', true);
        }
    
        // enqueue frontend styles and scripts method
        public function enqueue_frontend() {
            // wp_enqueue_style('ddBooking_style_frontend', plugins_url( '/assets/css/frontend/style.css', __FILE__ ));
            // wp_enqueue_script('ddBooking_script_frontend', plugins_url( '/assets/js/frontend/scripts.js', __FILE__ ), array('jquery'), '1.0', true);
            // wp_enqueue_script('jquery-form');
        }
    
        static function activation() {
             flush_rewrite_rules();
        }
    
        static function deactivation() {
            flush_rewrite_rules();
        }
}

if( class_exists('ddQuickView') ) {
    $ddMovie = new ddQuickView();
} 