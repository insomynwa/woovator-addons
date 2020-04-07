<?php
/**
 * Plugin Name: WooVator - WooCommerce Elementor Addons + Builder
 * Description: The WooCommerce elements library for Elementor page builder plugin for WordPress.
 * Version: 	1.5.5
 * Author: 		Mr. Lorem
 * Text Domain: woovator
 * Domain Path: /languages
 * WC tested up to: 4.0.1
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WOOVATOR_VERSION', '1.5.5' );
define( 'WOOVATOR_ADDONS_PL_ROOT', __FILE__ );
define( 'WOOVATOR_ADDONS_PL_URL', plugins_url( '/', WOOVATOR_ADDONS_PL_ROOT ) );
define( 'WOOVATOR_ADDONS_PL_PATH', plugin_dir_path( WOOVATOR_ADDONS_PL_ROOT ) );
define( 'WOOVATOR_ADDONS_DIR_URL', plugin_dir_url( WOOVATOR_ADDONS_PL_ROOT ) );
define( 'WOOVATOR_PLUGIN_BASE', plugin_basename( WOOVATOR_ADDONS_PL_ROOT ) );
define( 'WOOVATOR_ITEM_NAME', 'WooVator - WooCommerce Elementor Addons + Builder' );

// Required File
require_once ( WOOVATOR_ADDONS_PL_PATH.'includes/base.php' );
\WooVator\Base::instance();