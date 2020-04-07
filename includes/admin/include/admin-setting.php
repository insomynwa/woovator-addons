<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Woovator_Admin_Settings {

    private $settings_api;

    function __construct() {
        $this->settings_api = new Woovator_Settings_API();

        add_action( 'admin_init', [ $this, 'admin_init' ] );
        add_action( 'admin_menu', [ $this, 'admin_menu' ], 220 );
        add_action( 'wsa_form_bottom_woovator_general_tabs', [ $this, 'woovator_html_general_tabs' ] );
        add_action( 'wsa_form_top_woovator_elements_tabs', [ $this, 'woovator_html_popup_box' ] );
        add_action( 'wsa_form_bottom_woovator_themes_library_tabs', [ $this, 'woovator_html_themes_library_tabs' ] );
        
        add_action( 'wsa_form_bottom_woovator_buy_pro_tabs', [ $this, 'woovator_html_buy_pro_tabs' ] );

    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->woovator_admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->woovator_admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    // Plugins menu Register
    function admin_menu() {

        $menu = 'add_menu_' . 'page';
        $menu(
            'woovator_panel',
            esc_html__( 'WooVator', 'woovator' ),
            esc_html__( 'WooVator', 'woovator' ),
            'woovator_page',
            NULL,
            WOOVATOR_ADDONS_PL_URL.'includes/admin/assets/images/menu-icon.png',
            100
        );
        
        add_submenu_page(
            'woovator_page', 
            esc_html__( 'Settings', 'woovator' ),
            esc_html__( 'Settings', 'woovator' ), 
            'manage_options', 
            'woovator', 
            array ( $this, 'plugin_page' ) 
        );

    }

    // Options page Section register
    function woovator_admin_get_settings_sections() {
        $sections = array(
            
            array(
                'id'    => 'woovator_general_tabs',
                'title' => esc_html__( 'General', 'woovator' )
            ),

            array(
                'id'    => 'woovator_woo_template_tabs',
                'title' => esc_html__( 'WooCommerce Template', 'woovator' )
            ),

            array(
                'id'    => 'woovator_elements_tabs',
                'title' => esc_html__( 'Elements', 'woovator' )
            ),

            array(
                'id'    => 'woovator_themes_library_tabs',
                'title' => esc_html__( 'Theme Library', 'woovator' )
            ),

            array(
                'id'    => 'woovator_rename_label_tabs',
                'title' => esc_html__( 'Rename Label', 'woovator' )
            ),

            array(
                'id'    => 'woovator_sales_notification_tabs',
                'title' => esc_html__( 'Sales Notification', 'woovator' )
            ),

            array(
                'id'    => 'woovator_others_tabs',
                'title' => esc_html__( 'Other', 'woovator' )
            ),

            array(
                'id'    => 'woovator_buy_pro_tabs',
                'title' => esc_html__( 'Buy Pro', 'woovator' )
            ),

        );
        return $sections;
    }

    // Options page field register
    protected function woovator_admin_fields_settings() {

        $settings_fields = array(

            'woovator_general_tabs' => array(),

            'woovator_woo_template_tabs' => array(

                array(
                    'name'  => 'enablecustomlayout',
                    'label'  => __( 'Enable / Disable Template Builder', 'woovator' ),
                    'desc'  => __( 'Enable', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                ),

                array(
                    'name'  => 'shoppageproductlimit',
                    'label' => __( 'Product Limit', 'woovator' ),
                    'desc' => wp_kses_post( 'You can Handle Shop page product limit', 'woovator' ),
                    'min'               => 1,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'std'               => '10',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'    => 'singleproductpage',
                    'label'   => __( 'Single Product Template', 'woovator' ),
                    'desc'    => __( 'You can select Custom Product details layout', 'woovator' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woovator_elementor_template()
                ),

                array(
                    'name'    => 'productarchivepage',
                    'label'   => __( 'Product Archive Page Template', 'woovator' ),
                    'desc'    => __( 'You can select Custom Product Shop page layout', 'woovator' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woovator_elementor_template()
                ),

                array(
                    'name'    => 'productcartpagep',
                    'label'   => __( 'Cart Page Template', 'woovator' ),
                    'desc'    => __( 'You can select Custom cart page layout <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'productcheckoutpagep',
                    'label'   => __( 'Checkout Page Template', 'woovator' ),
                    'desc'    => __( 'You can select Custom checkout page layout <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'productthankyoupagep',
                    'label'   => __( 'Thank You Page Template', 'woovator' ),
                    'desc'    => __( 'You can select Custom thank you page layout <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'productmyaccountpagep',
                    'label'   => __( 'My Account Page Template', 'woovator' ),
                    'desc'    => __( 'You can select Custom my account page layout <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'productmyaccountloginpagep',
                    'label'   => __( 'My Account Login page Template', 'woovator' ),
                    'desc'    => __( 'You can select Custom my account login page layout <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => array(
                        'select'=>'Select Template',
                    ),
                    'class'=>'proelement',
                ),

            ),

            'woovator_elements_tabs' => array(

                array(
                    'name'  => 'product_tabs',
                    'label'  => __( 'Product Tab', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'universal_product',
                    'label'  => __( 'Universal Product', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'add_banner',
                    'label'  => __( 'Ads Banner', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'special_day_offer',
                    'label'  => __( 'Special Day Offer', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_archive_product',
                    'label'  => __( 'Product Archive', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_title',
                    'label'  => __( 'Product Title', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_related',
                    'label'  => __( 'Related Product', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_add_to_cart',
                    'label'  => __( 'Add To Cart Button', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_additional_information',
                    'label'  => __( 'Additional Information', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_data_tab',
                    'label'  => __( 'Product Data Tab', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_description',
                    'label'  => __( 'Product Description', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_short_description',
                    'label'  => __( 'Product Short Description', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_price',
                    'label'  => __( 'Product Price', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_rating',
                    'label'  => __( 'Product Rating', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_reviews',
                    'label'  => __( 'Product Reviews', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_image',
                    'label'  => __( 'Product Image', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wv_product_video_gallery',
                    'label'  => __( 'Product Video Gallery', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_upsell',
                    'label'  => __( 'Product Upsell', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_stock',
                    'label'  => __( 'Product Stock Status', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_meta',
                    'label'  => __( 'Product Meta Info', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_call_for_price',
                    'label'  => __( 'Call For Price', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wb_product_suggest_price',
                    'label'  => __( 'Suggest Price', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'wv_custom_archive_layoutp',
                    'label'  => __( 'Product Archive Layout <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_cart_tablep',
                    'label'  => __( 'Product Cart Table <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_cart_totalp',
                    'label'  => __( 'Product Cart Total <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_cartempty_messagep',
                    'label'  => __( 'Empty Cart Mes..<span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_cartempty_shopredirectp',
                    'label'  => __( 'Empty Cart Re.. Button <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_cross_sellp',
                    'label'  => __( 'Product Cross Sell <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_cross_sell_customp',
                    'label'  => __( 'Cross Sell ..( Custom ) <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_checkout_additional_formp',
                    'label'  => __( 'Checkout Additional.. <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_checkout_billingp',
                    'label'  => __( 'Checkout Billing Form <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_checkout_shipping_formp',
                    'label'  => __( 'Checkout Shipping Form <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_checkout_paymentp',
                    'label'  => __( 'Checkout Payment <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_checkout_coupon_formp',
                    'label'  => __( 'Checkout Co.. Form <span>( Pro )</span>', 'woovator-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_checkout_login_formp',
                    'label'  => __( 'Checkout lo.. Form <span>( Pro )</span>', 'woovator-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_order_reviewp',
                    'label'  => __( 'Checkout Order Review <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_myaccount_accountp',
                    'label'  => __( 'My Account <span>( Pro )</span>', 'woovator-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_myaccount_dashboardp',
                    'label'  => __( 'My Account Dashboard <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_myaccount_downloadp',
                    'label'  => __( 'My Account Download <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_myaccount_edit_accountp',
                    'label'  => __( 'My Account Edit<span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_myaccount_addressp',
                    'label'  => __( 'My Account Address <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_myaccount_login_formp',
                    'label'  => __( 'Login Form <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_myaccount_register_formp',
                    'label'  => __( 'Registration Form <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_myaccount_logoutp',
                    'label'  => __( 'My Account Logout <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_myaccount_orderp',
                    'label'  => __( 'My Account Order <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_thankyou_orderp',
                    'label'  => __( 'Thank You Order <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_thankyou_customer_address_detailsp',
                    'label'  => __( 'Thank You Cus.. Address <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_thankyou_order_detailsp',
                    'label'  => __( 'Thank You Order Details <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_product_advance_thumbnailsp',
                    'label'  => __( 'Advance Product Image <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_social_sherep',
                    'label'  => __( 'Product Social Share <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_stock_progress_barp',
                    'label'  => __( 'Stock Progressbar <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),
                array(
                    'name'  => 'wv_single_product_sale_schedulep',
                    'label'  => __( 'Product Sale Schedule <span>( Pro )</span>', 'woovator-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_related_productp',
                    'label'  => __( 'Related Pro..( Custom ) <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

                array(
                    'name'  => 'wv_product_upsell_customp',
                    'label'  => __( 'Upsell Pro..( Custom ) <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row pro',
                ),

            ),

            'woovator_themes_library_tabs' => array(),
            'woovator_rename_label_tabs' => array(
                
                array(
                    'name'  => 'enablerenamelabel',
                    'label'  => __( 'Enable / Disable Rename Label', 'woovator' ),
                    'desc'  => __( 'Enable', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'      => 'shop_page_heading',
                    'headding'  => __( 'Shop Page', 'woovator' ),
                    'type'      => 'title',
                ),
                
                array(
                    'name'        => 'wv_shop_add_to_cart_txt',
                    'label'       => __( 'Add to Cart Button Text', 'woovator' ),
                    'desc'        => __( 'You Can change the Add to Cart button text.', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Add to Cart', 'woovator' )
                ),

                array(
                    'name'      => 'product_details_page_heading',
                    'headding'  => __( 'Product Details Page', 'woovator' ),
                    'type'      => 'title',
                ),

                array(
                    'name'        => 'wv_add_to_cart_txt',
                    'label'       => __( 'Add to Cart Button Text', 'woovator' ),
                    'desc'        => __( 'You Can change the Add to Cart button text.', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Add to Cart', 'woovator' )
                ),

                array(
                    'name'        => 'wv_description_tab_menu_titlep',
                    'label'       => __( 'Description', 'woovator' ),
                    'desc'        => __( 'You Can change the description tab title. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Description', 'woovator' ),
                    'class'=>'proelement',
                ),
                
                array(
                    'name'        => 'wv_additional_information_tab_menu_titlep',
                    'label'       => __( 'Additional Information', 'woovator' ),
                    'desc'        => __( 'You Can change the additional information tab title. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Additiona information', 'woovator' ),
                    'class'=>'proelement',
                ),
                
                array(
                    'name'        => 'wv_reviews_tab_menu_titlep',
                    'label'       => __( 'Reviews', 'woovator' ),
                    'desc'        => __( 'You Can change the review tab title. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Reviews', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'      => 'checkout_page_headingp',
                    'headding'  => __( 'Checkout Page', 'woovator' ),
                    'type'      => 'title',
                ),

                array(
                    'name'        => 'wv_checkout_firstname_labelp',
                    'label'       => __( 'First name', 'woovator' ),
                    'desc'        => __( 'You can change the First name field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'First name', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_lastname_labelp',
                    'label'       => __( 'Last name', 'woovator' ),
                    'desc'        => __( 'You can change the Last name field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Last name', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_company_labelp',
                    'label'       => __( 'Company name', 'woovator' ),
                    'desc'        => __( 'You can change the company field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Company name', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_address_1_labelp',
                    'label'       => __( 'Street address', 'woovator' ),
                    'desc'        => __( 'You can change the Street address field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Street address', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_address_2_labelp',
                    'label'       => __( 'Address Optional', 'woovator' ),
                    'desc'        => __( 'You can change the Address Optional field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Address Optional', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_city_labelp',
                    'label'       => __( 'Town / City', 'woovator' ),
                    'desc'        => __( 'You can change the City field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Town / City', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_postcode_labelp',
                    'label'       => __( 'Postcode / ZIP', 'woovator' ),
                    'desc'        => __( 'You can change the Postcode / ZIP field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Postcode / ZIP', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_state_labelp',
                    'label'       => __( 'State', 'woovator' ),
                    'desc'        => __( 'You can change the state field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'State', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_phone_labelp',
                    'label'       => __( 'Phone', 'woovator' ),
                    'desc'        => __( 'You can change the phone field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Phone', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_email_labelp',
                    'label'       => __( 'Email address', 'woovator' ),
                    'desc'        => __( 'You can change the email address field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Email address', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_country_labelp',
                    'label'       => __( 'Country', 'woovator' ),
                    'desc'        => __( 'You can change the Country field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Country', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_ordernote_labelp',
                    'label'       => __( 'Order Note', 'woovator' ),
                    'desc'        => __( 'You can change the Order notes field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Order notes', 'woovator' ),
                    'class'=>'proelement',
                ),

                array(
                    'name'        => 'wv_checkout_placeorder_btn_txtp',
                    'label'       => __( 'Place order', 'woovator' ),
                    'desc'        => __( 'You can change the Place order field label. <span>( Pro )</span>', 'woovator' ),
                    'type'        => 'text',
                    'placeholder' => __( 'Place order', 'woovator' ),
                    'class'=>'proelement',
                ),

            ),
            
            'woovator_sales_notification_tabs'=>array(

                array(
                    'name'  => 'enableresalenotification',
                    'label'  => __( 'Enable / Disable Sales Notification', 'woovator' ),
                    'desc'  => __( 'Enable', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'    => 'notification_content_typep',
                    'label'   => __( 'Notification Content Type', 'woovator' ),
                    'desc'    => __( 'Select Content Type <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'radio',
                    'default' => 'actual',
                    'options' => array(
                        'actual' => __('Real','woovator'),
                        'fakes'  => __('Fakes','woovator'),
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'notification_posp',
                    'label'   => __( 'Position', 'woovator' ),
                    'desc'    => __( 'Sale Notification Position on frontend.( Top Left, Top Right, Bottom Right option are pro features ) <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => 'bottomleft',
                    'options' => array(
                        'bottomleft'    =>__( 'Bottom Left','woovator' ),
                    ),
                    'class'=>'proelement',
                ),

                array(
                    'name'    => 'notification_layoutp',
                    'label'   => __( 'Image Position', 'woovator' ),
                    'desc'    => __( 'Notification Layout. <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => 'imageleft',
                    'options' => array(
                        'imageleft'       =>__( 'Image Left','woovator' ),
                    ),
                    'class'       => 'notification_real proelement'
                ),

                array(
                    'name'    => 'notification_loadduration',
                    'label'   => __( 'Loading Time', 'woovator' ),
                    'desc'    => __( 'Notification Loading duration.', 'woovator' ),
                    'type'    => 'select',
                    'default' => '3',
                    'options' => array(
                        '2'       =>__( '2 seconds','woovator' ),
                        '3'       =>__( '3 seconds','woovator' ),
                        '4'       =>__( '4 seconds','woovator' ),
                        '5'       =>__( '5 seconds','woovator' ),
                        '6'       =>__( '6 seconds','woovator' ),
                        '7'       =>__( '7 seconds','woovator' ),
                        '8'       =>__( '8 seconds','woovator' ),
                        '9'       =>__( '9 seconds','woovator' ),
                        '10'       =>__( '10 seconds','woovator' ),
                        '20'       =>__( '20 seconds','woovator' ),
                        '30'       =>__( '30 seconds','woovator' ),
                        '40'       =>__( '40 seconds','woovator' ),
                        '50'       =>__( '50 seconds','woovator' ),
                        '60'       =>__( '1 minute','woovator' ),
                        '90'       =>__( '1.5 minutes','woovator' ),
                        '120'       =>__( '2 minutes','woovator' ),
                    ),
                ),

                array(
                    'name'    => 'notification_time_intp',
                    'label'   => __( 'Time Interval', 'woovator' ),
                    'desc'    => __( 'Time between notifications. <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => '4',
                    'options' => array(
                        '2'       =>__( '2 seconds','woovator' ),
                        '4'       =>__( '4 seconds','woovator' ),
                        '5'       =>__( '5 seconds','woovator' ),
                        '6'       =>__( '6 seconds','woovator' ),
                        '7'       =>__( '7 seconds','woovator' ),
                        '8'       =>__( '8 seconds','woovator' ),
                        '9'       =>__( '9 seconds','woovator' ),
                        '10'       =>__( '10 seconds','woovator' ),
                        '20'       =>__( '20 seconds','woovator' ),
                        '30'       =>__( '30 seconds','woovator' ),
                        '40'       =>__( '40 seconds','woovator' ),
                        '50'       =>__( '50 seconds','woovator' ),
                        '60'       =>__( '1 minute','woovator' ),
                        '90'       =>__( '1.5 minutes','woovator' ),
                        '120'       =>__( '2 minutes','woovator' ),
                    ),
                    'class' => 'proelement',
                ),

                array(
                    'name'              => 'notification_limit',
                    'label'             => __( 'Limit', 'woovator' ),
                    'desc'              => __( 'Order Limit for notification.', 'woovator' ),
                    'min'               => 1,
                    'max'               => 100,
                    'default'           => '5',
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'number',
                    'class'       => 'notification_real',
                ),

                array(
                    'name'    => 'notification_uptodatep',
                    'label'   => __( 'Order Upto', 'woovator' ),
                    'desc'    => __( 'Do not show purchases older than.( More Options are Pro features ) <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => '7',
                    'options' => array(
                        '7'   =>__( '1 week','woovator' ),
                    ),
                    'class'       => 'notification_real',
                ),

                array(
                    'name'    => 'notification_inanimationp',
                    'label'   => __( 'Animation In', 'woovator' ),
                    'desc'    => __( 'Notification Enter Animation. <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => 'fadeInLeft',
                    'options' => array(
                        'fadeInLeft'  =>__( 'fadeInLeft','woovator' ),
                    ),
                    'class' => 'proelement',
                ),

                array(
                    'name'    => 'notification_outanimationp',
                    'label'   => __( 'Animation Out', 'woovator' ),
                    'desc'    => __( 'Notification Out Animation. <span>( Pro )</span>', 'woovator' ),
                    'type'    => 'select',
                    'default' => 'fadeOutRight',
                    'options' => array(
                        'fadeOutRight'  =>__( 'fadeOutRight','woovator' ),
                    ),
                    'class' => 'proelement',
                ),
                
                array(
                    'name'  => 'background_colorp',
                    'label' => __( 'Background Color', 'woovator' ),
                    'desc' => wp_kses_post( 'Notification Background Color. <span>( Pro )</span>', 'woovator' ),
                    'type' => 'color',
                    'class'       => 'notification_real proelement',
                ),

                array(
                    'name'  => 'heading_colorp',
                    'label' => __( 'Heading Color', 'woovator' ),
                    'desc' => wp_kses_post( 'Notification Heading Color. <span>( Pro )</span>', 'woovator' ),
                    'type' => 'color',
                    'class'       => 'notification_real proelement',
                ),

                array(
                    'name'  => 'content_colorp',
                    'label' => __( 'Content Color', 'woovator' ),
                    'desc' => wp_kses_post( 'Notification Content Color. <span>( Pro )</span>', 'woovator' ),
                    'type' => 'color',
                    'class'       => 'notification_real proelement',
                ),

                array(
                    'name'  => 'cross_colorp',
                    'label' => __( 'Cross Icon Color', 'woovator' ),
                    'desc' => wp_kses_post( 'Notification Cross Icon Color. <span>( Pro )</span>', 'woovator' ),
                    'type' => 'color',
                    'class'       => 'proelement',
                ),

            ),

            'woovator_others_tabs'=>array(

                array(
                    'name'  => 'loadproductlimit',
                    'label' => __( 'Load Products in Elementor Addons', 'woovator' ),
                    'desc' => wp_kses_post( 'Load Products in Elementor Addons', 'woovator' ),
                    'min'               => 1,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'default'           => '20',
                    'sanitize_callback' => 'floatval',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'ajaxsearch',
                    'label'  => __( 'Ajax Search Widget', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row',
                ),

                array(
                    'name'  => 'ajaxcart_singleproduct',
                    'label'  => __( 'Single Product Ajax Add To Cart', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woovator_table_row',
                ),
                
                array(
                    'name'  => 'single_product_sticky_add_to_cartp',
                    'label'  => __( 'Single Product Sticky Add To Cart <span>( Pro )</span>', 'woovator' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'   => 'woovator_table_row pro',
                ),

            ),

            'woovator_buy_pro_tabs' => array(),

        );
        
        return array_merge( $settings_fields );
    }


    function plugin_page() {

        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'Woovator Settings','woovator' ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', 'woovator') ?></strong></p>
            </div>
            <?php
        }
    }

    // Custom Markup

    // General tab
    function woovator_html_general_tabs(){
        ob_start();
        ?>
            <div class="woovator-general-tabs">

                <!-- <div class="woovator-document-section">
                    <div class="woovator-column">
                        <a href="https://themeshas.com/blog-category/woovator/" target="_blank">
                            <img src="<?php //echo WOOVATOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/video-tutorial.jpg" alt="<?php //esc_attr_e( 'Video Tutorial', 'woovator' ); ?>">
                        </a>
                    </div>
                    <div class="woovator-column">
                        <a href="https://demo.themeshas.com/doc/woovator/index.html" target="_blank">
                            <img src="<?php //echo WOOVATOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/online-documentation.jpg" alt="<?php //esc_attr_e( 'Online Documentation', 'woovator' ); ?>">
                        </a>
                    </div>
                    <div class="woovator-column">
                        <a href="https://themeshas.com/contact-us/" target="_blank">
                            <img src="<?php //echo WOOVATOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/genral-contact-us.jpg" alt="<?php //esc_attr_e( 'Contact Us', 'woovator' ); ?>">
                        </a>
                    </div>
                </div> -->

                <div class="different-pro-free">
                    <h3 class="woovator-section-title"><?php echo esc_html__( 'WooVator Free VS WooVator Pro.', 'woovator' ); ?></h3>

                    <div class="woovator-admin-row">
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( 'WooVator Free', 'woovator' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( '18 Elements', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Shop Page Builder ( Default Layout )', 'woovator' ); ?></li>
                                <li class="wvdel"><del><?php echo esc_html__( 'Shop Page Builder ( Custom Design )', 'woovator' ); ?></del></li>
                                <li><?php echo esc_html__( '3 Product Custom Layout', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Single Product Template Builder', 'woovator' ); ?></li>
                                <li class="wvdel"><del><?php echo esc_html__( 'Single Product Individual Layout', 'woovator' ); ?></del></li>
                                <li class="wvdel"><del><?php echo esc_html__( 'Product Archive Category Wise Individual layout', 'woovator' ); ?></del></li>
                                <li class="wvdel"><del><?php echo esc_html__( 'Cart Page Builder', 'woovator' ); ?></del></li>
                                <li class="wvdel"><del><?php echo esc_html__( 'Checkout Page Builder', 'woovator' ); ?></del></li>
                                <li class="wvdel"><del><?php echo esc_html__( 'Thank You Page Builder', 'woovator' ); ?></del></li>
                                <li class="wvdel"><del><?php echo esc_html__( 'My Account Page Builder', 'woovator' ); ?></del></li>
                                <li class="wvdel"><del><?php echo esc_html__( 'My Account Login page Builder', 'woovator' ); ?></del></li>
                            </ul>
                            <a class="button button-primary" href="<?php echo esc_url( admin_url() ); ?>/plugin-install.php" target="_blank"><?php echo esc_html__( 'Install Now', 'woolenror' ); ?></a>
                        </div>
                        <div class="features-list-area">
                            <h3><?php echo esc_html__( 'WooVator Pro', 'woovator' ); ?></h3>
                            <ul>
                                <li><?php echo esc_html__( '41 Elements', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Shop Page Builder ( Default Layout )', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Shop Page Builder ( Custom Design )', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( '15 Product Custom Layout', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Single Product Template Builder', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Single Product Individual Layout', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Product Archive Category Wise Individual layout', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Cart Page Builder', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Checkout Page Builder', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'Thank You Page Builder', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'My Account Page Builder', 'woovator' ); ?></li>
                                <li><?php echo esc_html__( 'My Account Login page Builder', 'woovator' ); ?></li>
                            </ul>
                            <a class="button button-primary" href="http://bit.ly/2HObEeB" target="_blank"><?php echo esc_html__( 'Buy Now', 'woolenror' ); ?></a>
                        </div>
                    </div>

                </div>

            </div>
        <?php
        echo ob_get_clean();
    }

    // Pop up Box
    function woovator_html_popup_box(){
        ob_start();
        ?>
            <div id="woovator-dialog" title="<?php esc_html_e( 'Go Premium', 'woovator' ); ?>" style="display: none;">
                <div class="wvdialog-content">
                    <span><i class="dashicons dashicons-warning"></i></span>
                    <p>
                        <?php
                            echo __('Purchase our','woovator').' <strong><a href="'.esc_url( 'http://bit.ly/2HObEeB' ).'" target="_blank" rel="nofollow">'.__( 'premium version', 'woovator' ).'</a></strong> '.__('to unlock these pro elements!','woovator');
                        ?>
                    </p>
                </div>
            </div>

            <script>
                ( function( $ ) {
                    
                    $(function() {
                        $( '.woovator_table_row.pro,.proelement label' ).click(function() {
                            $( "#woovator-dialog" ).dialog({
                                modal: true,
                                minWidth: 500,
                                buttons: {
                                    Ok: function() {
                                      $( this ).dialog( "close" );
                                    }
                                }
                            });
                        });
                        $(".woovator_table_row.pro input[type='checkbox'],.proelement select,.proelement input[type='text'],.proelement input[type='radio']").attr("disabled", true);
                    });

                } )( jQuery );
            </script>
        <?php
        echo ob_get_clean();
    }

    // Theme Library
    function woovator_html_themes_library_tabs() {
        ob_start();
        ?>
        <div class="woovator-themes-laibrary">
            <p><?php echo esc_html__( 'Use Our WooCommerce Theme for your online Store.', 'woovator' ); ?></p>
            <div class="woovator-themes-area">
                <div class="woovator-themes-row">

                    <!-- <div class="woovator-single-theme"><img src="<?php //echo WOOVATOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/99fy.png" alt="">
                        <div class="woovator-theme-content">
                            <h3><?php //echo esc_html__( '99Fy - WooCommerce Theme', 'woovator' ); ?></h3>
                            <a href="https://demo.themeshas.com/99fy-preview/index.html" class="woovator-button" target="_blank"><?php //echo esc_html__( 'Preview', 'woovator' ); ?></a>
                            <a href="https://downloads.wordpress.org/theme/99fy.3.1.2.zip" class="woovator-button"><?php //echo esc_html__( 'Download', 'woovator' ); ?></a>
                        </div>
                    </div> -->
                    
                    <div class="woovator-single-theme"><img src="<?php echo WOOVATOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/parlo.png" alt="">
                        <div class="woovator-theme-content">
                            <h3><?php echo esc_html__( 'Parlo - WooCommerce Theme', 'woovator' ); ?></h3>
                            <a href="http://demo.shrimpthemes.com/1/parlo/" class="woovator-button" target="_blank"><?php echo esc_html__( 'Preview', 'woovator' ); ?></a>
                            <a href="https://freethemescloud.com/item/parlo-free-woocommerce-theme/" class="woovator-button"><?php echo esc_html__( 'Download', 'woovator' ); ?></a>
                        </div>
                    </div>

                    <div class="woovator-single-theme"><img src="<?php echo WOOVATOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/flone.png" alt="">
                        <div class="woovator-theme-content">
                            <h3><?php echo esc_html__( 'Flone – Minimal WooCommerce Theme', 'woovator' ); ?> <span><?php echo esc_html__( '( Pro )', 'woovator' ); ?></span></h3>
                            <a href="http://demo.shrimpthemes.com/2/flone/" class="woovator-button" target="_blank"><?php echo esc_html__( 'Preview', 'woovator' ); ?></a>
                        </div>
                    </div>

                    <div class="woovator-single-theme"><img src="<?php echo WOOVATOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/holmes.png" alt="">
                        <div class="woovator-theme-content">
                            <h3><?php echo esc_html__( 'Homes - Multipurpose WooCommerce Theme', 'woovator' ); ?> <span><?php echo esc_html__( '( Pro )', 'woovator' ); ?></span></h3>
                            <a href="http://demo.shrimpthemes.com/1/holmes/" class="woovator-button" target="_blank"><?php echo esc_html__( 'Preview', 'woovator' ); ?></a>
                        </div>
                    </div>
                    
                    <div class="woovator-single-theme"><img src="<?php echo WOOVATOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/daniel-home-1.png" alt="">
                        <div class="woovator-theme-content">
                            <h3><?php echo esc_html__( 'Daniel - WooCommerce Theme', 'woovator' ); ?> <span><?php echo esc_html__( '( Pro )', 'woovator' ); ?></span></h3>
                            <a href="http://demo.shrimpthemes.com/2/daniel/" class="woovator-button" target="_blank"><?php echo esc_html__( 'Preview', 'woovator' ); ?></a>
                        </div>
                    </div>
                    
                    <div class="woovator-single-theme"><img src="<?php echo WOOVATOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/hurst-home-1.png" alt="">
                        <div class="woovator-theme-content">
                            <h3><?php echo esc_html__( 'Hurst - WooCommerce Theme', 'woovator' ); ?> <span><?php echo esc_html__( '( Pro )', 'woovator' ); ?></span></h3>
                            <a href="http://demo.shrimpthemes.com/4/hurstem/" class="woovator-button" target="_blank"><?php echo esc_html__( 'Preview', 'woovator' ); ?></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        echo ob_get_clean();
    }

    // Buy Pro
    function woovator_html_buy_pro_tabs(){
        ob_start();
        ?>
            <div class="woovator-admin-tab-area">
                <ul class="woovator-admin-tabs">
                    <li><a href="#oneyear" class="wvactive"><?php echo esc_html__( 'One Year', 'woovator' ); ?></a></li>
                    <li><a href="#lifetime"><?php echo esc_html__( 'Life Time', 'woovator' ); ?></a></li>
                </ul>
            </div>
            
            <!-- <div id="oneyear" class="woovator-admin-tab-pane wvactive">
                <div class="woovator-admin-row">

                    <div class="woovator-price-plan">
                        <a href="http://bit.ly/2HObEeB" target="_blank"><img src="https://demo.themeshas.com/pricing-plan/one_year_single_website.png" alt="<?php //echo esc_attr__( 'One Year Single Website','woovator' );?>"></a>
                    </div>

                    <div class="woovator-price-plan">
                        <a href="http://bit.ly/2HObEeB" target="_blank"><img src="https://demo.themeshas.com/pricing-plan/one_year_elementor_guru.png" alt="<?php //echo esc_attr__( 'One Year Unlimited Website','woovator' );?>"></a>
                    </div>

                    <div class="woovator-price-plan">
                        <a href="http://bit.ly/2HObEeB" target="_blank"><img src="https://demo.themeshas.com/pricing-plan/one_year_wpbundle.png" alt="<?php //echo esc_attr__( 'One Year Unlimited Websites','woovator' );?>"></a>
                    </div>

                </div>
            </div>

            <div id="lifetime" class="woovator-admin-tab-pane">
                
                <div class="woovator-admin-row">
                    <div class="woovator-price-plan">
                        <a href="http://bit.ly/2HObEeB" target="_blank"><img src="https://demo.themeshas.com/pricing-plan/life_time_single_website.png" alt="<?php //echo esc_attr__( 'Life Time Single Website','woovator' );?>"></a>
                    </div>

                    <div class="woovator-price-plan">
                        <a href="http://bit.ly/2HObEeB" target="_blank"><img src="https://demo.themeshas.com/pricing-plan/life_time_elementor_guru.png" alt="<?php //echo esc_attr__( 'Life time Unlimited Website','woovator' );?>"></a>
                    </div>

                    <div class="woovator-price-plan">
                        <a href="http://bit.ly/2HObEeB" target="_blank"><img src="https://demo.themeshas.com/pricing-plan/life_time_wpbundle.png" alt="<?php //echo esc_attr__( 'Life Time Unlimited Websites','woovator' );?>"></a>
                    </div>
                </div>

            </div> -->

        <?php
        echo ob_get_clean();
    }
    

}

new Woovator_Admin_Settings();