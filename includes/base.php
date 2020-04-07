<?php

namespace WooVator;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Base
*/
class Base {

    const MINIMUM_PHP_VERSION = '5.4';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        if ( ! function_exists('is_plugin_active') ){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );

        // Register Plugin Active Hook
        register_activation_hook( WOOVATOR_ADDONS_PL_ROOT, [ $this, 'plugin_activate_hook' ] );

        // Support WooCommerce
        add_action( 'after_setup_theme', [ $this, 'woocommerce_setup' ] );

    }

    /*
    * Load Text Domain
    */
    public function i18n() {
        load_plugin_textdomain( 'woovator', false, dirname( plugin_basename( WOOVATOR_ADDONS_PL_ROOT ) ) . '/languages/' );
    }

    /*
    * Init Hook in Init
    */
    public function init() {

        // Check for required PHP version
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        // Check WooCommerce
        if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            add_action('admin_notices', [ $this, 'admin_notic_missing_woocommerce' ] );
            return ;
        }

        // Plugins Setting Page
        add_filter('plugin_action_links_'.WOOVATOR_PLUGIN_BASE, [ $this, 'plugins_setting_links' ] );

        // Include File
        $this->include_files();

        // After Active Plugin then redirect to setting page
        $this->plugin_redirect_option_page();

        // Promo Banner
        if( is_admin() ){
            if( !is_plugin_active('woovator-addons-pro/woovator_addons_pro.php') && ( \Woovator_Template_Library::instance()->get_templates_info( true )['notices'][0]['status'] == 1 ) ){
                if ( isset( $_GET['woovator-dismiss'] ) && check_admin_referer( 'woovator-dismiss-' . get_current_user_id() ) ) {
                    add_action( 'admin_head', [ $this, 'dismiss' ] );
                }
                register_deactivation_hook( WOOVATOR_ADDONS_PL_ROOT, [ $this, 'update_dismiss'] );
                add_action( 'admin_notices', [ $this, 'admin_promo_notice' ] );
                return ;
            }
        }

        // Elementor Preview Action
        if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
            add_action( 'admin_action_elementor', [ $this, 'wc_fontend_includes' ], 5 );
        } 

    }

    /**
     * Admin notice.
     * For missing elementor.
     */
    public function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $elementor = 'elementor/elementor.php';
        if( $this->is_plugins_active( $elementor ) ) {
            if( ! current_user_can( 'activate_plugins' ) ) {
                return;
            }
            $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );
            $message = sprintf( __( '%1$sWooVator Addons for Elementor%2$s requires %1$s"Elementor"%2$s plugin to be active. Please activate Elementor to continue.', 'woovator' ), '<strong>', '</strong>' );
            $button_text = esc_html__( 'Activate Elementor', 'woovator' );
        } else {
            if( ! current_user_can( 'activate_plugins' ) ) {
                return;
            }
            $activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
            $message = sprintf( __( '%1$sWooVator Addons for Elementor%2$s requires %1$s"Elementor"%2$s plugin to be installed and activated. Please install Elementor to continue.', 'woovator' ), '<strong>', '</strong>' );
            $button_text = esc_html__( 'Install Elementor', 'woovator' );
        }
        $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
        printf( '<div class="error"><p>%1$s</p>%2$s</div>', $message, $button );
    }

    /**
     * Admin notice.
     * For WooCommerce.
     */
    public function admin_notic_missing_woocommerce(){
        $woocommerce = 'woocommerce/woocommerce.php';
        if( $this->is_plugins_active( $woocommerce ) ) {
            if( ! current_user_can( 'activate_plugins' ) ) {
                return;
            }
            $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $woocommerce . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $woocommerce );
            $message = sprintf( __( '%1$sWooVator Addons for Elementor%2$s requires %1$s"WooCommerce"%2$s plugin to be active. Please activate WooCommerce to continue.', 'woovator' ), '<strong>', '</strong>');
            $button_text = __( 'Activate WooCommerce', 'woovator' );
        } else {
            if( ! current_user_can( 'activate_plugins' ) ) {
                return;
            }
            $activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
            $message = sprintf( __( '%1$sWooVator Addons for Elementor%2$s requires %1$s"WooCommerce"%2$s plugin to be installed and activated. Please install WooCommerce to continue.', 'woovator' ), '<strong>', '</strong>' );
            $button_text = __( 'Install WooCommerce', 'woovator' );
        }
        $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
        printf( '<div class="error"><p>%1$s</p>%2$s</div>', __( $message ), $button );
    }

    /**
     * Admin notice.
     * PHP required version.
     */
    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'woovator' ),
            '<strong>' . esc_html__( 'WooVator', 'woovator' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'woovator' ) . '</strong>',
             self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Admin notice.
     * Promo Banner
     */
    public function dismiss() {
        update_user_meta( get_current_user_id(), 'woovator_dismissed_notice_id', 1 );
    }
    public function update_dismiss() {
        delete_metadata( 'user', null, 'woovator_dismissed_notice_id', null, true );
    }
    public function admin_promo_notice(){
        if( get_user_meta( get_current_user_id(), 'woovator_dismissed_notice_id', true ) ){
            return;
        }
        if( \Woovator_Template_Library::instance()->get_templates_info( true )['notices'] ){
            $dismissbtn = '<a href="'.esc_url( wp_nonce_url( add_query_arg( 'woovator-dismiss', 'dismiss_admin_notices' ), 'woovator-dismiss-' . get_current_user_id() ) ).'">
                <button type="button" class="notice-dismiss"><span class="screen-reader-text">'.esc_html__( 'Dismiss this notice.', 'woovator' ).'</span></button>
            </a>';
            foreach ( \Woovator_Template_Library::instance()->get_templates_info( true )['notices'] as $notices ) {
               printf( '<div class="woovator-admin-notice notice notice-warning"><a href="%1$s" target="_blank"><img src="%2$s" alt="%3$s"></a><p>%4$s</p>%5$s</div>', $notices['bannerlink'], $notices['bannerimage'], $notices['title'], $notices['description'], $dismissbtn );
            }
        }
    }

    /*
    * Check Plugins is Installed or not
    */
    public function is_plugins_active( $pl_file_path = NULL ){
        $installed_plugins_list = get_plugins();
        return isset( $installed_plugins_list[$pl_file_path] );
    }

    /* 
    * Add settings link on plugin page.
    */
    public function plugins_setting_links( $links ) {
        $settings_link = '<a href="'.admin_url('admin.php?page=woovator').'">'.esc_html__( 'Settings', 'woovator' ).'</a>'; 
        array_unshift( $links, $settings_link );
        if( !is_plugin_active('woovator-addons-pro/woovator_addons_pro.php') ){
            $links['woovatorgo_pro'] = sprintf('<a href="https://themeshas.com/plugins/woovator-pro/" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro','woovator') . '</a>');
        }
        return $links; 
    }

    /* 
    * Plugins After Install
    * Redirect Setting page
    */
    public function plugin_activate_hook() {
        add_option('woovator_do_activation_redirect', TRUE);
    }
    public function plugin_redirect_option_page() {
        if ( get_option( 'woovator_do_activation_redirect', FALSE ) ) {
            delete_option('woovator_do_activation_redirect');
            if( !isset( $_GET['activate-multi'] ) ){
                wp_redirect( admin_url("admin.php?page=woovator") );
            }
        }
    }

    // Support WooCommerce
    public function woocommerce_setup() {
        if( function_exists('woovator_get_option') ){
            if( woovator_get_option( 'enablecustomlayout', 'woovator_woo_template_tabs', 'on' ) == 'on' ){
                add_theme_support( 'woocommerce' );
                add_theme_support( 'wc-product-gallery-zoom' );
                add_theme_support( 'wc-product-gallery-lightbox' );
                add_theme_support( 'wc-product-gallery-slider' );
            }
        }
    }

    /*
    * Load WC Files in Editor Mode
    */
    public function wc_fontend_includes() {
        \WC()->frontend_includes();
        if ( is_null( \WC()->cart ) ) {
            global $woocommerce;
            $session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
            $woocommerce->session = new $session_class();
            $woocommerce->session->init();

            $woocommerce->cart     = new \WC_Cart();
            $woocommerce->customer = new \WC_Customer( get_current_user_id(), true );
        }
    }

    /*
    * Include File
    */
    public function include_files(){
        require( WOOVATOR_ADDONS_PL_PATH.'includes/helper-function.php' );
        require( WOOVATOR_ADDONS_PL_PATH.'classes/class.assest_management.php' );
        require( WOOVATOR_ADDONS_PL_PATH.'classes/class.widgets_control.php' );

        // Admin Setting file
        if( is_admin() ){
            require( WOOVATOR_ADDONS_PL_PATH.'includes/custom-metabox.php' );
            require( WOOVATOR_ADDONS_PL_PATH.'includes/admin/admin-init.php' );
        }

        // Builder File
        if( woovator_get_option( 'enablecustomlayout', 'woovator_woo_template_tabs', 'on' ) == 'on' ){
            require( WOOVATOR_ADDONS_PL_PATH.'includes/wv_woo_shop.php' );
            require( WOOVATOR_ADDONS_PL_PATH.'includes/archive_product_render.php' );
            require( WOOVATOR_ADDONS_PL_PATH.'includes/class.product_video_gallery.php' );
            if( !is_admin() && !is_plugin_active('woovator-addons-pro/woovator_addons_pro.php') && woovator_get_option( 'enablerenamelabel', 'woovator_rename_label_tabs', 'off' ) == 'on' ){
                require( WOOVATOR_ADDONS_PL_PATH.'includes/rename_label.php' );
            }
        }

        // Search
        if( woovator_get_option( 'ajaxsearch', 'woovator_others_tabs', 'off' ) == 'on' ){
            require( WOOVATOR_ADDONS_PL_PATH. 'includes/widgets/ajax-search/base.php' );
        }

        // Sale Notification
        if( !is_plugin_active('woovator-addons-pro/woovator_addons_pro.php') && woovator_get_option( 'enableresalenotification', 'woovator_sales_notification_tabs', 'off' ) == 'on' ){
            require( WOOVATOR_ADDONS_PL_PATH. 'includes/class.sale_notification.php' );
        }

        // Single Product Ajax cart
        if( woovator_get_option( 'ajaxcart_singleproduct', 'woovator_others_tabs', 'off' ) == 'on' ){
            require( WOOVATOR_ADDONS_PL_PATH. 'classes/class.single_product_ajax_add_to_cart.php' );
        }


    }
    

}