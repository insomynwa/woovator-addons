<?php

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class Woovator_Admin_Setting{

    public function __construct(){
        add_action('admin_enqueue_scripts', array( $this, 'woovator_enqueue_admin_scripts' ) );
        $this->woovator_admin_settings_page();
    }

    /*
    *  Setting Page
    */
    public function woovator_admin_settings_page() {
        require_once('include/class.settings-api.php');
        require_once('include/template-library.php');
        if( is_plugin_active('woovator-addons-pro/woovator_addons_pro.php') ){
            require_once WOOVATOR_ADDONS_PL_PATH_PRO.'includes/admin/admin-setting.php';
        }else{
            require_once('include/admin-setting.php');
        }
    }

    /*
    *  Enqueue admin scripts
    */
    public function woovator_enqueue_admin_scripts( $hook ){
        
        wp_enqueue_style( 'woovator-admin', WOOVATOR_ADDONS_PL_URL . 'includes/admin/assets/css/admin_optionspanel.css', FALSE, WOOVATOR_VERSION );

        // wp core styles
        wp_enqueue_style( 'wp-jquery-ui-dialog' );
        // wp core scripts
        wp_enqueue_script( 'jquery-ui-dialog' );
        
        wp_enqueue_script( 'woovator-admin-main', WOOVATOR_ADDONS_PL_URL . 'includes/admin/assets/js/woovator-admin.js', array( 'jquery' ), WOOVATOR_VERSION, TRUE );
        $datalocalize = array(
            'contenttype' => woovator_get_option( 'notification_content_type','woovator_sales_notification_tabs', 'actual' ),
        );
        wp_localize_script( 'woovator-admin-main', 'admin_wvlocalize_data', $datalocalize );

    }

}

new Woovator_Admin_Setting();