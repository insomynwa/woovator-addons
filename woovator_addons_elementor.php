<?php
/**
 * Plugin Name: WooLentor - WooCommerce Elementor Addons + Builder
 * Description: The WooCommerce elements library for Elementor page builder plugin for WordPress.
 * Version: 	1.5.5
 * Author: 		Mr. Lorem
 * Text Domain: woolentor
 * Domain Path: /languages
 * WC tested up to: 4.0.1
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WOOLENTOR_VERSION', '1.5.5' );
define( 'WOOLENTOR_ADDONS_PL_ROOT', __FILE__ );
define( 'WOOLENTOR_ADDONS_PL_URL', plugins_url( '/', WOOLENTOR_ADDONS_PL_ROOT ) );
define( 'WOOLENTOR_ADDONS_PL_PATH', plugin_dir_path( WOOLENTOR_ADDONS_PL_ROOT ) );
define( 'WOOLENTOR_ADDONS_DIR_URL', plugin_dir_url( WOOLENTOR_ADDONS_PL_ROOT ) );
define( 'WOOLENTOR_PLUGIN_BASE', plugin_basename( WOOLENTOR_ADDONS_PL_ROOT ) );
define( 'WOOLENTOR_ITEM_NAME', 'WooLentor - WooCommerce Elementor Addons + Builder' );

// Required File
require_once ( WOOLENTOR_ADDONS_PL_PATH.'includes/base.php' );
\WooLentor\Base::instance();