<?php
/*
Plugin Name: DD WooCommerce Wishlist
Plugin URI: #
Description: WooCommerce Wishlist plugin for practice plugin development
Version: 1.0
Author: Danil Derevyanchenko
Author URI: #
Licence: GPLv2 or later
Text Domain: ddWishlist
Domain Path: /lang
*/ 

if( ! defined('ABSPATH') ) {
    die;
}  

define('DDWISHLIST_PATH', plugin_dir_path(__FILE__));

require DDWISHLIST_PATH . 'inc/helper.php';

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
    require DDWISHLIST_PATH . 'inc/class-gamajo-template-loader.php';
}

if ( ! class_exists( 'ddWishlist_Template_Loader' ) ) {
    require DDWISHLIST_PATH . 'inc/class-ddWishlist-template-loader.php';
}

if ( ! class_exists( 'ddWishlist_ajax' ) ) {
    require DDWISHLIST_PATH . 'inc/class-ddWishlist-ajax.php';
}


/**
 ******************************************
 * ddWishlist Class
 ****************************************** 
 */

class ddWishlist 
{

    private $svgIcon = '<svg class="" title="Like Shopping bag SVG File" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#8899a4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';

    public function __construct() 
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action( 'woocommerce_after_shop_loop_item', [$this, 'ddWishlist_add_wishlist_button'], 20 );
        add_filter( 'display_post_states', [$this, 'ddWishlist_add_display_post_states'], 10, 2 );
    }

    /**
     * generate 'Add to Wishlist' button
     */
    public function ddWishlist_add_wishlist_button()
    {
        global $product;
        $product_id = $product->get_id();
        $btn_classes = ddWishlist_ajax::check_if_product_exists_in_wishlist($product_id);
       
        echo sprintf(
            '<button class="dd_add_to_wishlist_btn %s" data-product_id="%s">%s</button>',
            $btn_classes,
            $product_id,
            $this->svgIcon
        );
    }

    /**
     * generate archive page wishlist
     */
    private function ddWishlist_generate_wishlist_archive_page()
    {
        if ( !function_exists( 'wc_create_page' ) ) { 
            include_once dirname(WC_PLUGIN_FILE) . '/includes/admin/wc-admin-functions.php';
        } 

        $wishlistPageId = wc_create_page( 
            'wishlist-page', 
            '', 
            'Wishlist', 
            '', 
            0, 
            'publish'
        );

        return $wishlistPageId;

    }

    /**
     * Add post states for Wishlist page
     */
    public function ddWishlist_add_display_post_states($post_states, $post) {

		if( $post->post_name == 'wishlist-page' ) {
            $post_states[] = __('Wishlist Page', 'ddWishlist');
		} 

		return $post_states;
	}

    /**
     * Set page template 'Wishlist template' by default for page 'Wishlist' 
     */
    public function ddWishlist_set_wishlist_template_by_default()
    {

        $page = get_page_by_path( 'wishlist-page' );

        if ( $page ) {
            update_post_meta( $page->ID, '_wp_page_template', 'templates/template-wishlist.php' );
        }
    }

    /**
     * enqueue frontend styles method
     */
    public function enqueue_styles()
    {
        wp_enqueue_style('ddWishlist_main_style', plugins_url( '/assets/css/main.css', __FILE__ ));
    }

    /**
     * enqueue frontend scripts method
     */
    public function enqueue_scripts()
    {
        wp_register_script('ddwishlist_main_script', plugins_url( '/assets/js/main.js', __FILE__ ), array('jquery'), time() );

        wp_localize_script('ddwishlist_main_script', 'ddwishlist_ajax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('_wpnonce'),
            'title' => esc_html__('ddWishlist test title', 'ddWishlist'),
        ));

        wp_enqueue_script( 'ddwishlist_main_script' );
    }



    /**
     * activation hook
     */
    static function activation() 
    {
        $this->ddWishlist_generate_wishlist_archive_page();
        $this->ddWishlist_set_wishlist_template_by_default();
        flush_rewrite_rules();
    }

    /**
     * deactivation hook
     */
    static function deactivation()
    {
        flush_rewrite_rules();
    }
}

if( class_exists('ddWishlist') ) {
    $ddWishlist = new ddWishlist();
} 

register_activation_hook( __FILE__, array( $ddWishlist, 'activation' ) );
register_deactivation_hook( __FILE__, array( $ddWishlist, 'deactivation' ) );