jQuery(document).ready(function($) {

    console.log( 'scripts run' );

    function add_to_wishlist(el) {
        el.addClass("added");
    } 

    $(".dd_add_to_wishlist_btn").on("click", function() {
        var $this = $(this);
        
        add_to_wishlist($this);
    });

});