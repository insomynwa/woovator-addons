<?php

namespace WooVator;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Assest Management
*/
class Assets_Management{
    
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

        // Register Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );

        // Frontend Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_scripts' ] );

    }

    // Register frontend scripts
    public function register_scripts(){
        
        // Register Css file
        wp_register_style(
            'htflexboxgrid',
            WOOVATOR_ADDONS_PL_URL . 'assets/css/htflexboxgrid.css',
            array(),
            WOOVATOR_VERSION
        );
        
        wp_register_style(
            'simple-line-icons',
            WOOVATOR_ADDONS_PL_URL . 'assets/css/simple-line-icons.css',
            array(),
            WOOVATOR_VERSION
        );

        wp_register_style(
            'woovator-widgets',
            WOOVATOR_ADDONS_PL_URL . 'assets/css/woovator-widgets.css',
            array(),
            WOOVATOR_VERSION
        );

        wp_register_style(
            'slick',
            WOOVATOR_ADDONS_PL_URL . 'assets/css/slick.css',
            array(),
            WOOVATOR_VERSION
        );

        // Register JS file
        wp_register_script(
            'slick',
            WOOVATOR_ADDONS_PL_URL . 'assets/js/slick.min.js',
            array('jquery'),
            WOOVATOR_VERSION,
            TRUE
        );

        wp_register_script(
            'countdown-min',
            WOOVATOR_ADDONS_PL_URL . 'assets/js/jquery.countdown.min.js',
            array('jquery'),
            WOOVATOR_VERSION,
            TRUE
        );

        wp_register_script(
            'woovator-widgets-scripts',
            WOOVATOR_ADDONS_PL_URL . 'assets/js/woovator-widgets-active.js',
            array( 'jquery', 'slick' ),
            WOOVATOR_VERSION,
            TRUE
        );

    }

    // Enqueue frontend scripts
    public function enqueue_frontend_scripts() {
        // CSS File
        wp_enqueue_style( 'htflexboxgrid' );
        wp_enqueue_style( 'font-awesome' );
        wp_enqueue_style( 'simple-line-icons' );
        wp_enqueue_style( 'slick' );
        wp_enqueue_style( 'woovator-widgets' );
        if ( is_rtl() ) {
          wp_enqueue_style(  'woovator-widgets-rtl',  WOOVATOR_ADDONS_PL_URL . 'assets/css/woovator-widgets-rtl.css', array(), WOOVATOR_VERSION );
        }

        //Localize Scripts
        $localizeargs = array(
            'woovatorajaxurl' => admin_url( 'admin-ajax.php' ),
            'ajax_nonce'       => wp_create_nonce( 'woovator_psa_nonce' ),
        );
        wp_localize_script( 'jquery', 'woovator_addons', $localizeargs );

        // Ajax Search
        if( woovator_get_option( 'ajaxsearch', 'woovator_others_tabs', 'off' ) == 'on' ){
            wp_enqueue_style(
                'woovator-ajax-search',
                WOOVATOR_ADDONS_PL_URL . 'assets/addons/ajax-search/css/ajax-search.css',
                WOOVATOR_VERSION
            );
            wp_enqueue_script(
                'jquery-nicescroll',
                WOOVATOR_ADDONS_PL_URL . 'assets/addons/ajax-search/js/jquery.nicescroll.min.js',
                array( 'jquery' ),
                WOOVATOR_VERSION,
                TRUE
            );
            wp_enqueue_script(
                'woovator-ajax-search',
                WOOVATOR_ADDONS_PL_URL . 'assets/addons/ajax-search/js/ajax-search.js',
                array('jquery'),
                WOOVATOR_VERSION,
                TRUE
            );
        }

        // Single Product Ajax Add to Cart
        if( woovator_get_option( 'ajaxcart_singleproduct', 'woovator_others_tabs', 'off' ) == 'on' ){
            if ( 'yes' === get_option('woocommerce_enable_ajax_add_to_cart') ) {
                wp_enqueue_script(
                    'jquery-single-product-ajax-cart',
                    WOOVATOR_ADDONS_PL_URL . 'assets/js/single_product_ajax_add_to_cart.js',
                    array( 'jquery' ),
                    WOOVATOR_VERSION,
                    TRUE
                );
            }
        }

    }


}

Assets_Management::instance();