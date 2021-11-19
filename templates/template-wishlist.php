<?php
/*
Template Name: Template Wishlist 
*/

get_header();


$wishlist_prods_id = ddWishlist_ajax::get_all_wishlist_products_ids(); 
// pr( $wishlist_prods_id );
?>

<header class="entry-header">
    <h1 class="entry-title"><?php _e('Your Wishlist', 'ddWishlist'); ?></h1>
</header>

<?php if ( ! empty( $wishlist_prods_id ) ) {

?>

<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
    <thead>
        <tr>
            <th class="product-thumbnail">&nbsp;</th>
            <th class="product-name"><?php _e('Product', 'ddWishlist'); ?></th>
            <th class="product-description"><?php _e('Description', 'ddWishlist'); ?></th>
            <th class="product-price"><?php _e('Price', 'ddWishlist'); ?></th>
            <th class="product-remove">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $wishlist_prods_id as $wishlist_prod ) : $product = wc_get_product( $wishlist_prod ); ?>

            <tr class="woocommerce-cart-form__cart-item cart_item">
                <td class="product-thumbnail">
                    <a href="<?php echo get_the_permalink($wishlist_prod); ?>">
                        <?php echo get_the_post_thumbnail($wishlist_prod); ?>
                    </a>						
                </td>     
                <td class="product-name" data-title="<?php echo get_the_title($wishlist_prod); ?>">
                    <a href="<?php echo get_the_permalink($wishlist_prod); ?>"><?php echo get_the_title($wishlist_prod); ?></a>						
                </td>
                <td class="product-description">
                    <div class="description">
                    <p>
                        <?php echo get_the_excerpt($wishlist_prod); ?>
                    </p>
                    </div>
                </td>
                <td class="product-price" data-title="Цена">
                    <span class="woocommerce-Price-amount amount">
                        <span class="woocommerce-Price-currencySymbol"><?php echo get_woocommerce_currency_symbol(); ?></span>
                        <?php echo $product->get_price(); ?>
                    </span>
                </td>
                <td class="product-remove">
                    <button class="remove_from_wishlist" data-product_id="<?php echo $wishlist_prod; ?>">×</button>						
                </td>
            </tr>

        <?php endforeach; ?>    
    </tbody>
</table>

<?php
} else {
    _e('Your Wishlist is empty.', 'ddWishlist'); 
}
get_footer();