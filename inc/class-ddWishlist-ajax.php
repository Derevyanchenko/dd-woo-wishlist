<?php

/**
 * ddWishlist_ajax Class
 */

class ddWishlist_ajax 
{
    
    public function __construct()
    {
        // $this->allow_wishlist_unauthorized = get_field('allow_wishlist_unauthorized', 'option');
        // $this->cur_user_id = get_current_user_id();

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
        $allow_wishlist_unauthorized = get_field('allow_wishlist_unauthorized', 'option');
        $cur_user_id = get_current_user_id();
        var_dump( $cur_user_id, $allow_wishlist_unauthorized );
        wp_die();

        if ( is_user_logged_in() ) {

            return 'if - user logged in';

            $this->db_add_to_wishlist();
        } else if ( true == $allow_wishlist_unauthorized &&  false == is_user_logged_in()  ) {
            return 'else if = user NOT logged in, but allow_wishlist_unauthorized = true';
            
            $this->session_add_to_wishlist();
        } else {
            return 'else -  user NOT logged in, and allow_wishlist_unauthorized = false';
            wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
        }

    }

    /**
     * method whitch add current product to wishlist - with DB
     */
    public function db_add_to_wishlist()
    {
        $allow_wishlist_unauthorized = get_field('allow_wishlist_unauthorized', 'theme-general-settings');
        $cur_user_id = get_current_user_id();

        if ( ! empty( $_POST ) ) {
            check_ajax_referer('_wpnonce', 'nonce');       
            $product_id = $_POST['product_id'];

            // add to wishlist db

            if ( $product_id > 0 && $cur_user_id > 0 ) {
                if ( add_user_meta( $cur_user_id, 'ddwishlist_products', $product_id ) ) {
                    echo 'DB_add_to_wishlist -  Succesful added to wishlist';
                } else {
                    echo 'Failed';
                }
            }

            wp_die();
        }
    } 

    /**
     * method whitch add current product to wishlist - with session
     */
    public function session_add_to_wishlist()
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

            echo 'session_add_to_wishlist <br>';
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
     * method whitch check if current product exist in wishlist
     */
    public static function db_check_if_product_exists_in_wishlist($user_id, $prod_id)
    {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE meta_key='ddwishlist_products' AND meta_value=". $prod_id ." AND user_id=". $user_id);

        if ( isset( $result[0]->meta_value) && $result[0]->meta_value == $prod_id ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * return wishlist products ids array
     */
    public static function get_all_wishlist_products_ids()
    {
        // $allow_wishlist_unauthorized = get_field('allow_wishlist_unauthorized', 'theme-general-settings');
        $cur_user_id = get_current_user_id();

        if ( is_user_logged_in() ) {
            $products_ids = get_user_meta( $cur_user_id, 'ddwishlist_products' );
        } else {
            $products_ids = $_SESSION['wishlist_product_ids'];
        }

        return $products_ids;
    }

}

$ddWishlist_ajax = new ddWishlist_ajax();