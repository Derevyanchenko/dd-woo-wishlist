<?php
session_start();
/*
Template Name: Template Wishlist 
*/

get_header();

// unset( $_SESSION['wishlist_product_ids'] );

$products = $_SESSION['wishlist_product_ids'];
pr( $products );

echo '<h1>Wishlist page Template Custom</h1>';

get_footer();