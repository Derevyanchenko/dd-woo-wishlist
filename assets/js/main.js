jQuery(document).ready(function($) {

    console.log( 'scripts run' );

    $(".dd_add_to_wishlist_btn").on( "click", function() {
        add_to_wishlist($(this));
    } );

    /**
     * add to wishlist ajax function 
    **/
    function add_to_wishlist(el) {

        $.ajax({
            url: ddwishlist_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'add_to_wishlist',
                nonce: ddwishlist_ajax.nonce,
                product_id: el.data('product_id'),
            },
            success: function(data) {
                console.log('success send');
                console.log(data);

                el.addClass("added");
            },
            error: function(error) {
                console.log(error);
            },

        });

    } 

});