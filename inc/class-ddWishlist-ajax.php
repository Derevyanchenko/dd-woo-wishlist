<?php

/**
 * ddWishlist_ajax Class
 */


class ddWishlist_ajax 
{
    
    public function __construct()
    {
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

        if ( ! empty( $_POST ) ) {
            check_ajax_referer('_wpnonce', 'nonce');       
            $product_id = $_POST['product_id'];

            if ( is_user_logged_in() ) {

                $this->db_add_to_wishlist($cur_user_id, $product_id);

            } else if ( true == $allow_wishlist_unauthorized &&  false == is_user_logged_in()  ) {

                $this->session_add_to_wishlist($product_id);

            } else {

                $data_arr = array(
                    'type' => 'redirect',
                    'url' => get_permalink( get_option('woocommerce_myaccount_page_id') ),
                );
                $data_arr = json_encode( $data_arr);
        
                echo $data_arr;

            }

        }

        wp_die();
    }

    /**
     * method whitch add current product to wishlist - with DB
     */
    public function db_add_to_wishlist( $cur_user_id, $product_id )
    {
        if ( $product_id > 0 && $cur_user_id > 0 ) {
            if ( add_user_meta( $cur_user_id, 'ddwishlist_products', $product_id ) ) {
                echo 'DB_add_to_wishlist -  Succesful added to wishlist';
            } else {
                echo 'Failed';
                wp_die('Failed');
            }
        }
    } 

    /**
     * method whitch add current product to wishlist - with session
     */
    public function session_add_to_wishlist($product_id)
    {
        session_start();
        if ( ! isset( $_SESSION['wishlist_product_ids'] ) ) {
            $_SESSION['wishlist_product_ids'] = array();
        }
        
        if ( ! isset( $_SESSION['wishlist_products_ids'][$product_id] ) ) {
            $_SESSION['wishlist_product_ids'][$product_id] = $product_id;
        }

        echo 'session_add_to_wishlist <br>';
        echo $_SESSION['wishlist_product_ids'][$product_id];
    } 

    /**
     * method whitch remove current product from wishlist
     */
    public function remove_product_from_wishlist()
    {

        $allow_wishlist_unauthorized = get_field('allow_wishlist_unauthorized', 'option');
        $cur_user_id = get_current_user_id();

        if ( ! empty( $_POST ) ) {
            check_ajax_referer('_wpnonce', 'nonce');       
            $product_id = $_POST['product_id'];

            if ( is_user_logged_in() ) {

                $this->db_remove_product_from_wishlist($cur_user_id, $product_id );

            } else if ( true == $allow_wishlist_unauthorized &&  false == is_user_logged_in()  ) {

                $this->session_remove_product_from_wishlist( $product_id );

            } else {
                wp_die();
            }

        }

        wp_die();
    }

    /**
     * method whitch remove current product from wishlist - with DB
     */
    public function db_remove_product_from_wishlist($cur_user_id, $product_id)
    {
        if ( $product_id > 0 && $cur_user_id > 0 ) {
            if ( delete_user_meta( $cur_user_id, 'ddwishlist_products', $product_id ) ) {
                echo 'DB_remove_from_wishlist -  Succesful removed from wishlist';
            } else {
                echo 'Failed';
                wp_die('Failed');
            }
        }

    }

    /**
     * method whitch remove current product from wishlist - with session
     */
    public function session_remove_product_from_wishlist($product_id)
    {   
        session_start();

        $product_id = $_POST['product_id'];
        unset( $_SESSION['wishlist_product_ids'][$product_id] );

        echo 'session_remove_from_wishlist <br>';
    }


    /**
     * return wishlist products ids array
     */
    public static function get_all_wishlist_products_ids()
    {
        $cur_user_id = get_current_user_id();

        if ( is_user_logged_in() ) {
            $products_ids = get_user_meta( $cur_user_id, 'ddwishlist_products' );

            return $products_ids;
        } else {
            session_start();
            $products_ids = $_SESSION['wishlist_product_ids'];

            return $products_ids;
        }

    }

}

$ddWishlist_ajax = new ddWishlist_ajax();