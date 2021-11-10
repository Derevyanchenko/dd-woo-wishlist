<?php

class ddWishlist_Template_Loader extends Gamajo_Template_Loader {

    protected $filter_prefix = 'ddWishlist';

    protected $theme_template_directory = 'dd-woo-wishlist';

    protected $plugin_directory = DDWISHLIST_PATH;

    protected $plugin_template_directory = 'templates';

    public $templates;

    // custom functions

    public function register() {

        $this->templates = array(
            'templates/template-wishlist.php' => 'Template Wishlist',
        );
        add_filter('theme_page_templates', [$this, 'custom_template']);
        add_filter('template_include', [$this, 'load_template']);
    }

    public function load_template($template) {
        global $post;
        $template_name = get_post_meta( $post->ID, '_wp_page_template', true);

        if ( $template_name ) {
            if ( $this->templates[$template_name] ) {
                $file = DDWISHLIST_PATH . $template_name; 
                if ( file_exists( $file ) ) {
                    return $file;
                }
            }  else {
                
            }
        }

        return $template;
    }

    public function custom_template($templates) {
        $templates = array_merge($templates, $this->templates);
        return $templates;
    }

}

$ddWishlist_Template_Loader = new ddWishlist_Template_Loader();
$ddWishlist_Template_Loader->register();