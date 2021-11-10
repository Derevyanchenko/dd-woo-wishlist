<?php

class ddWishlist_ajax 
{
    
    public function __construct()
    {
        add_action( 'wp_ajax_add_to_wishlist', [ $this, 'add_to_wishlist' ] );
        add_action( 'wp_ajax_nopriv_add_to_wishlist', [ $this, 'add_to_wishlist' ] );
    }

    public function add_to_wishlist()
    {
        if ( ! empty( $_POST ) ) {
            check_ajax_referer('_wpnonce', 'nonce');       

            $product_id = $_POST['product_id'];

            // add to wishlist session
            session_start();

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

    public static function check_if_product_exists_in_wishlist($prod_id) 
    {
        session_start();

        $btn_classes = '';

        if ( isset( $_SESSION['wishlist_product_ids'][$prod_id] ) ) {
            $btn_classes = 'added';
        } else $btn_classes = '';

        return $btn_classes;
    }

    public static function get_all_wishlist_products_ids()
    {
            session_start();

            $products = $_SESSION['wishlist_product_ids'];
            pr( $products );

            wp_die();
        }

}

$ddWishlist_ajax = new ddWishlist_ajax();