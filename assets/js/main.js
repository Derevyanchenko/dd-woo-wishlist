function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

jQuery(document).ready(function($) {


    $(".dd_add_to_wishlist_btn").on( "click", function() {
        var that = $(this);

        if ( that.hasClass('added') ) {
            remove_from_wishlist(that);
        } else {
            add_to_wishlist(that);
        }
    } );

    $('button.remove_from_wishlist').on("click", function() {
        var that = $(this);

        remove_from_wishlist(that);
    });

    /**
     * add product to wishlist ajax function 
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

                if ( IsJsonString(data) ) {
                    var data_json =  JSON.parse(data);

                    if ( data_json.type == 'redirect' ) {
                        window.location.href = data_json.url;
                    }
                }
                console.log(data);

                el.addClass("added");
            },
            error: function(error) {
                console.log(error);
            },

        });
    } 

    /**
     * remove product from wishlist ajax function 
    **/
    function remove_from_wishlist(el) {

        $.ajax({
            url: ddwishlist_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'remove_product_from_wishlist',
                nonce: ddwishlist_ajax.nonce,
                product_id: el.data('product_id'),
            },
            success: function(data) {
                console.log('success remove');
                console.log(data);

                el.removeClass("added");
                if ( el.hasClass( 'remove_from_wishlist' ) ) {
                    el.closest('.cart_item').remove();
                }        
            },
            error: function(error) {
                console.log(error);
            },

        });
        } 

});