<?php
/*
Template Name: Template Wishlist 
*/

get_header();


$wishlist_prods_id = ddWishlist_ajax::get_all_wishlist_products_ids(); 
pr( $wishlist_prods_id );
?>

<header class="entry-header">
    <h1 class="entry-title"><?php __('Your Wishlist', 'ddWishlist'); ?></h1>
</header>

<?php if ( ! empty( $wishlist_prods_id ) ) {
?>

<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
    <thead>
        <tr>
            <th class="product-thumbnail">&nbsp;</th>
            <th class="product-name"><?php __('Product', 'ddWishlist'); ?></th>
            <th class="product-description"><?php __('Description', 'ddWishlist'); ?></th>
            <th class="product-price"><?php __('Price', 'ddWishlist'); ?></th>
            <th class="product-remove">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $wishlist_prods_id as $wishlist_prod ) : ?>

            <?php echo get_the_permalink($wishlist_prod) . '<br>' ; ?>

            <tr class="woocommerce-cart-form__cart-item cart_item">
                <td class="product-thumbnail">
                    <a href="<?php echo get_the_permalink($wishlist_prod); ?>">
                        <img width="324" height="324" src="<?php // echo wp_get_attachment_url($wishlist_prod->get_image_id()); ?> " class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt=""></a>						
                </td>     
                <td class="product-name" data-title="<?php // echo $wishlist_prod->name; ?>">
                    <a href="<?php echo get_the_permalink($wishlist_prod); ?>"><?php // echo $wishlist_prod->name; ?></a>						
                </td>
                <td class="product-description">
                    <div class="description">
                    <p>
                        <?php // echo $wishlist_prod->short_description; ?>
                    </p>
                    </div>
                </td>
                <td class="product-price" data-title="Цена">
                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span><?php // echo $wishlist_prod->price; ?></span>
                </td>
                <td class="product-remove">
                    <button class="remove_from_wishlist" data-product_id="<?php echo $wishlist_prod; ?>">×</button>						
                </td>
            </tr>

        <?php endforeach; ?>    
    </tbody>
</table>

<?php
}
get_footer();