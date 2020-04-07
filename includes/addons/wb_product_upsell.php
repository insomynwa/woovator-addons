<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WV_Product_Upsell_Element extends Widget_Base {

    public function get_name() {
        return 'wv-single-product-upsell';
    }

    public function get_title() {
        return __( 'WV: Product Upsell', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-product-upsell';
    }

    public function get_categories() {
        return array( 'woovator-addons' );
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'product_upsell_content',
            [
                'label' => __( 'Upsells', 'woovator' ),
            ]
        );

            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', 'woovator' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 4,
                    'min' => 1,
                    'max' => 12,
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => __( 'Order By', 'woovator' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'date',
                    'options' => [
                        'date'          => __( 'Date', 'woovator' ),
                        'title'         => __( 'Title', 'woovator' ),
                        'price'         => __( 'Price', 'woovator' ),
                        'popularity'    => __( 'Popularity', 'woovator' ),
                        'rating'        => __( 'Rating', 'woovator' ),
                        'rand'          => __( 'Random', 'woovator' ),
                        'menu_order'    => __( 'Menu Order', 'woovator' ),
                    ],
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'Order', 'woovator' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'desc',
                    'options' => [
                        'asc'   => __( 'ASC', 'woovator' ),
                        'desc'  => __( 'DESC', 'woovator' ),
                    ],
                ]
            );

            $this->add_control(
                'wv_show_heading',
                [
                    'label' => __( 'Heading', 'woovator' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'woovator' ),
                    'label_off' => __( 'Hide', 'woovator' ),
                    'render_type' => 'ui',
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'prefix_class' => 'wv-show-heading-',
                ]
            );

        $this->end_controls_section();

        // Heading Style
        $this->start_controls_section(
            'heading_style_section',
            array(
                'label' => __( 'Heading', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'heading_color',
                [
                    'label' => __( 'Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} h2' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'wv_show_heading!' => '',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'heading_typography',
                    'label' => __( 'Typography', 'woovator' ),
                    'selector' => '.woocommerce {{WRAPPER}} h2',
                    'condition' => [
                        'wv_show_heading!' => '',
                    ],
                ]
            );

            $this->add_responsive_control(
                'heading_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'wv_show_heading!' => '',
                    ],
                ]
            );

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {

        $settings = $this->get_settings_for_display();
        $product_per_page   = '-1';
        $columns            = 4;
        $orderby            = 'rand';
        $order              = 'desc';
        if ( ! empty( $settings['columns'] ) ) {
            $columns = $settings['columns'];
        }
        if ( ! empty( $settings['orderby'] ) ) {
            $orderby = $settings['orderby'];
        }
        if ( ! empty( $settings['order'] ) ) {
            $order = $settings['order'];
        }
        if( Plugin::instance()->editor->is_edit_mode() ){
            echo '<div class="upsell product">'.__( 'Upsell Product default Layout','woovator-pro' ).'</div>';
        }else{
            woocommerce_upsell_display( $product_per_page, $columns, $orderby, $order );
        }

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WV_Product_Upsell_Element() );
