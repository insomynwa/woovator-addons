<?php
    /**
    *  Single Product Custom Layout
    */
    class Woovator_Woo_Custom_Template_Layout{


        public static $wv_woo_elementor_template = array();

        private static $_instance = null;
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        function __construct(){
            add_action('init', array( $this, 'init' ) );
        }

        public function init(){

            // Product details page
            add_filter( 'wc_get_template_part', array( $this, 'wv_get_product_page_template' ), 99, 3 );
            add_filter( 'template_include', array( $this, 'wv_get_product_elementor_template' ), 100 );
            add_action( 'woovator_woocommerce_product_content', array( $this, 'wv_get_product_content_elementor' ), 5 );
            add_action( 'woovator_woocommerce_product_content', array( $this, 'wv_get_default_product_data' ), 10 );

            // Product Archive Page
            add_action('template_redirect', array($this, 'woovator_product_archive_template'), 999);
            add_filter('template_include', array($this, 'woovator_redirect_product_archive_template'), 999);
            add_action( 'woovator_woocommerce_archive_product_content', array( $this, 'woovator_archive_product_page_content') );
        }

        public function wv_get_product_page_template( $template, $slug, $name ) {
            if ( 'content' === $slug && 'single-product' === $name ) {
                if ( Woovator_Woo_Custom_Template_Layout::wv_woo_custom_product_template() ) {
                    $template = WOOVATOR_ADDONS_PL_PATH . 'wv-woo-templates/single-product.php';
                }
            }
            return $template;
        }

        //Based on elementor template
        public function wv_get_product_elementor_template( $template ) {
            if ( is_embed() ) {
                return $template;
            }
            if ( is_singular( 'product' ) ) {
                $templateid = get_page_template_slug( woovator_get_option( 'singleproductpage', 'woovator_woo_template_tabs', '0' ) );
                if ( 'elementor_header_footer' === $templateid ) {
                    $template = WOOVATOR_ADDONS_PL_PATH . 'wv-woo-templates/single-product-fullwidth.php';
                } elseif ( 'elementor_canvas' === $templateid ) {
                    $template = WOOVATOR_ADDONS_PL_PATH . 'wv-woo-templates/single-product-canvas.php';
                }
            }
            return $template;
        }

        public static function wv_get_product_content_elementor( $post ) {
            if ( Woovator_Woo_Custom_Template_Layout::wv_woo_custom_product_template() ) {
                $wvtemplateid = woovator_get_option( 'singleproductpage', 'woovator_woo_template_tabs', '0' );
                $wvindividualid = get_post_meta( get_the_ID(), '_selectproduct_layout', true ) ? get_post_meta( get_the_ID(), '_selectproduct_layout', true ) : '0';
                if( $wvindividualid != '0' ){ $wvtemplateid = $wvindividualid; }
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $wvtemplateid );
            } else {
                the_content();
            }
        }

        // product data
        public function wv_get_default_product_data() {
            WC()->structured_data->generate_product_data();
        }

        public static function wv_woo_custom_product_template() {
            $templatestatus = false;
            if ( is_product() ) {
                global $post;
                if ( ! isset( self::$wv_woo_elementor_template[ $post->ID ] ) ) {
                    $single_product_default = woovator_get_option( 'singleproductpage', 'woovator_woo_template_tabs', '0' );
                    if ( ! empty( $single_product_default ) && 'default' !== $single_product_default ) {
                        $templatestatus                              = true;
                        self::$wv_woo_elementor_template[ $post->ID ] = true;
                    }
                } else {
                    $templatestatus = self::$wv_woo_elementor_template[ $post->ID ];
                }
            }
            return apply_filters( 'wv_woo_custom_product_template', $templatestatus );
        }

        /*
        * Archive Page
        */
        public function woovator_product_archive_template() {
            $archive_template_id = 0;
            if ( defined('WOOCOMMERCE_VERSION') ) {
                $termobj = get_queried_object();
                if ( is_shop() || ( is_tax('product_cat') && is_product_category() ) || ( is_tax('product_tag') && is_product_tag() ) || ( isset( $termobj->taxonomy ) && is_tax( $termobj->taxonomy ) ) ) {
                    $product_achive_custom_page_id = woovator_get_option( 'productarchivepage', 'woovator_woo_template_tabs', '0' );

                    // Meta value
                    $wvtermlayoutid = 0;
                    if(( is_tax('product_cat') && is_product_category() ) || ( is_tax('product_tag') && is_product_tag() )){
                        $wvtermlayoutid = get_term_meta( $termobj->term_id, 'wooletor_selectcategory_layout', true ) ? get_term_meta( $termobj->term_id, 'wooletor_selectcategory_layout', true ) : '0';
                    }
                    if( $wvtermlayoutid != '0' ){ 
                        $archive_template_id = $wvtermlayoutid; 
                    }else{
                        if (!empty($product_achive_custom_page_id)) {
                            $archive_template_id = $product_achive_custom_page_id;
                        }
                    }
                    return $archive_template_id;
                }
                return $archive_template_id;
            }
        }

        public function woovator_redirect_product_archive_template($template){
            $archive_template_id = $this->woovator_product_archive_template();
            $templatefile   = array();
            $templatefile[] = 'wv-woo-templates/archive-product.php';
            if( $archive_template_id != '0' ){
                $template = locate_template( $templatefile );
                if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) ){
                    $template = WOOVATOR_ADDONS_PL_PATH . '/wv-woo-templates/archive-product.php';
                }
                $page_template_slug = get_page_template_slug( $archive_template_id );
                if ( 'elementor_header_footer' === $page_template_slug ) {
                    $template = WOOVATOR_ADDONS_PL_PATH . '/wv-woo-templates/archive-product-fullwidth.php';
                } elseif ( 'elementor_canvas' === $page_template_slug ) {
                    $template = WOOVATOR_ADDONS_PL_PATH . '/wv-woo-templates/archive-product-canvas.php';
                }
            }
            return $template;
        }

        // Element Content
        public function woovator_archive_product_page_content( $post ){
            $archive_template_id = $this->woovator_product_archive_template();
            if( $archive_template_id != '0' ){
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $archive_template_id );
            }else{ the_content(); }
        }

    }

    Woovator_Woo_Custom_Template_Layout::instance();