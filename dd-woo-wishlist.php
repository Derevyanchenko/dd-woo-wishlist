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

// Define path and URL to the ACF plugin.
define( 'MY_ACF_PATH', DDWISHLIST_PATH . '/vendor/acf/' );
define( 'MY_ACF_URL', DDWISHLIST_PATH . '/vendor/acf/' );

// Include the ACF plugin.
if ( ! class_exists( 'ACF' ) ) {
    require_once DDWISHLIST_PATH . 'vendor/acf/acf.php';
}

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

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6196d9c24c17a',
        'title' => 'archive',
        'fields' => array(
            array(
                'key' => 'field_6196cee58dbe1',
                'label' => 'insert a shortcode for a wishlist link with an icon and quantity',
                'name' => 'insert_wishlist_header_shortcode',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Yes',
                'ui_off_text' => 'No',
            ),
            array(
                'key' => 'field_6196cf0e8dbe2',
                'label' => '[header_shortcode]',
                'name' => '',
                'type' => 'message',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => 'Your shortcode for a wishlist link with an icon and quantity',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => false,
        'description' => '',
    ));
    
    acf_add_local_field_group(array(
        'key' => 'group_6196cb872ca23',
        'title' => 'wishlist settings page',
        'fields' => array(
            array(
                'key' => 'field_6196cf628dbe3',
                'label' => 'General',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'left',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_6196cb898dbdf',
                'label' => 'Allow adding products to the wishlist for unauthorized users',
                'name' => 'allow_wishlist_unauthorized',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Yes',
                'ui_off_text' => 'No',
            ),
            array(
                'key' => 'field_6196ce468dbe0',
                'label' => 'Message to unauthorized users when they try to add items to their wishlist',
                'name' => 'message_to_unauthorized_users',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
            array(
                'key' => 'field_6196cfaf8dbe5',
                'label' => 'Appearance',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'left',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_6196d0988dbe8',
                'label' => 'default color for \'add to wishlist\' btn',
                'name' => 'default_color_for_add_to_wishlist_btn',
                'type' => 'color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '#8899a4',
            ),
            array(
                'key' => 'field_6196d0fb8dbe9',
                'label' => 'active color for \'add to wishlist\' btn',
                'name' => 'active_color_for_add_to_wishlist_btn',
                'type' => 'color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '#ff6161',
            ),
            array(
                'key' => 'field_6196cf848dbe4',
                'label' => 'Advanced',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'left',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_6196cfd58dbe6',
                'label' => 'pick up \'add to wishlist\' button to your own hook - store page (from developers only)',
                'name' => 'add_to_wishlist_btn_custom_hook_shop_page',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_6196d07b8dbe7',
                'label' => 'pick up \'add to wishlist\' button to your own hook - single product page (from developers only) (копия)',
                'name' => 'add_to_wishlist_btn_custom_hook_single_product',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-general-settings',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
    endif;

// Customize the url setting to fix incorrect asset URLs.
// add_filter('acf/settings/url', 'my_acf_settings_url');
// function my_acf_settings_url( $url ) {
//     return MY_ACF_URL;
// }

// (Optional) Hide the ACF admin menu item.
// add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
// function my_acf_settings_show_admin( $show_admin ) {
//     return false;
// }


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
        add_action( 'woocommerce_single_product_summary', [$this, 'ddWishlist_add_wishlist_button'], 15 );
        add_action( 'init', [$this, 'ddWishlist_generate_wishlist_archive_page'] );
        add_action( 'init', [$this, 'ddWishlist_set_wishlist_template_by_default'] );
        add_filter( 'display_post_states', [$this, 'ddWishlist_add_display_post_states'], 10, 2 );
        add_action( 'init', [$this, 'ddWishlist_create_settings_pages'] );
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
    public function ddWishlist_generate_wishlist_archive_page()
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
     * Create settings page for 'Wishlist' 
     */
    public function ddWishlist_create_settings_pages()
    {
        if( function_exists('acf_add_options_page') ) {
	
            acf_add_options_page(array(
                'page_title' 	=> 'ddWishlist Settings',
                'menu_title'	=> 'Wishlist Settings',
                'menu_slug' 	=> 'theme-general-settings',
                'capability'	=> 'edit_posts',
                'redirect'		=> false
            ));
            
            // acf_add_options_sub_page(array(
            //     'page_title' 	=> 'Theme Header Settings',
            //     'menu_title'	=> 'Header',
            //     'parent_slug'	=> 'theme-general-settings',
            // ));
            
            // acf_add_options_sub_page(array(
            //     'page_title' 	=> 'Theme Footer Settings',
            //     'menu_title'	=> 'Footer',
            //     'parent_slug'	=> 'theme-general-settings',
            // ));
            
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
        // $this->ddWishlist_generate_wishlist_archive_page();
        // $this->ddWishlist_set_wishlist_template_by_default();
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