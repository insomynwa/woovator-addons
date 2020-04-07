<?php

namespace WooVator;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Widgets Control
*/
class Widgets_Control{
    
    private static $instance = null;
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct(){
        $this->init();
    }

    public function init() {

        // Register custom category
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );

        // Init Widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

    }

    // Add custom category.
    public function add_category( $elements_manager ) {
        $elements_manager->add_category(
            'woovator-addons',
            [
               'title'  => __( 'Woovator Addons','woovator'),
                'icon' => 'font',
            ]
        );
    }

    // Widgets Register
    public function init_widgets(){

        $wv_element_manager = array(
            'product_tabs',
            'add_banner',
            'special_day_offer'
        );
        if( !is_plugin_active('woovator-addons-pro/woovator_addons_pro.php') ){
            $wv_element_manager[] = 'universal_product';
        }

        // WooCommerce Builder
        if( woovator_get_option( 'enablecustomlayout', 'woovator_woo_template_tabs', 'on' ) == 'on' ){
            $wvb_element  = array(
                'wb_archive_product',
                'wb_product_title',
                'wb_product_related',
                'wb_product_add_to_cart',
                'wb_product_additional_information',
                'wb_product_data_tab',
                'wb_product_description',
                'wb_product_short_description',
                'wb_product_price',
                'wb_product_rating',
                'wb_product_reviews',
                'wb_product_image',
                'wv_product_video_gallery',
                'wb_product_upsell',
                'wb_product_stock',
                'wb_product_meta',
                'wb_product_call_for_price',
                'wb_product_suggest_price',
            );
        }else{ $wvb_element  = array(); }
        $wv_element_manager = array_merge( $wv_element_manager, $wvb_element );

        foreach ( $wv_element_manager as $element ){
            if (  ( woovator_get_option( $element, 'woovator_elements_tabs', 'on' ) === 'on' ) && file_exists( WOOVATOR_ADDONS_PL_PATH.'includes/addons/'.$element.'.php' ) ){
                require( WOOVATOR_ADDONS_PL_PATH.'includes/addons/'.$element.'.php' );
            }
        }
        
    }


}

Widgets_Control::instance();