<?php

/**
 * ddWishlist Class
 */

class ddWishlist 
{
    
    public function __construct()
    {
        session_start();
        add_action( 'wp_ajax_add_to_wishlist', [ $this, 'add_to_wishlist' ] );
        add_action( 'wp_ajax_nopriv_add_to_wishlist', [ $this, 'add_to_wishlist' ] );
        add_action( 'wp_ajax_remove_product_from_wishlist', [ $this, 'remove_product_from_wishlist' ] );
        add_action( 'wp_ajax_nopriv_remove_product_from_wishlist', [ $this, 'remove_product_from_wishlist' ] );
    }

    /**
     * method whitch add current product to wishlist
     */
    public function add_to_wishlist()
    {
        if ( ! empty( $_POST ) ) {
            check_ajax_referer('_wpnonce', 'nonce');       
            $product_id = $_POST['product_id'];

            // add to wishlist session
            if ( ! isset( $_SESSION['wishlist_product_ids'] ) ) {
                $_SESSION['wishlist_product_ids'] = array();
            }
            
            if ( ! isset( $_SESSION['wishlist_products_ids'][$product_id] ) ) {
                $_SESSION['wishlist_product_ids'][$product_id] = $product_id;
            }

            echo $_SESSION['wishlist_product_ids'][$product_id];

            wp_die();
        }
    }

    /**
     * method whitch remove current product from wishlist
     */
    public function remove_product_from_wishlist()
    {
        if ( ! empty( $_POST ) ) {
            check_ajax_referer('_wpnonce', 'nonce');       

            $product_id = $_POST['product_id'];
            unset( $_SESSION['wishlist_product_ids'][$product_id] );

            wp_die();
        }
    }

    /**
     * method whitch check if current product exist in wishlist
     */
    public static function check_if_product_exists_in_wishlist($prod_id) 
    {

        $btn_classes = '';

        if ( isset( $_SESSION['wishlist_product_ids'][$prod_id] ) ) {
            $btn_classes = 'added';
        } else $btn_classes = '';

        return $btn_classes;
    }

    /**
     * return wishlist products ids array
     */
    public static function get_all_wishlist_products_ids()
    {
            $products_ids = $_SESSION['wishlist_product_ids'];
            return $products_ids;
        }

}

$ddWishlist = new ddWishlist();