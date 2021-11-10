<?php
/*
Template Name: Template Wishlist 
*/

get_header();

$products_ids = ddWishlist::get_all_wishlist_products_ids();
pr( $products_ids );

echo '<h1>Wishlist page Template Custom</h1>';

get_footer();