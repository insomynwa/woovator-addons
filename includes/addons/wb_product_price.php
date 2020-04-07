<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WV_Product_Price_Element extends Widget_Base {

    public function get_name() {
        return 'wv-single-product-price';
    }

    public function get_title() {
        return __( 'WV: Product Price', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-product-price';
    }

    public function get_categories() {
        return array( 'woovator-addons' );
    }

    protected function _register_controls() {

        // Product Price Style
        $this->start_controls_section(
            'product_price_regular_style_section',
            array(
                'label' => __( 'Regular Price', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'product_price_color',
                [
                    'label'     => __( 'Price Color', 'woovator' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .price del' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'product_price_typography',
                    'label'     => __( 'Typography', 'woovator' ),
                    'selector'  => '{{WRAPPER}} .price del, {{WRAPPER}} .price del .amount',
                )
            );

            $this->add_control(
                'price_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'product_price_sale_style_section',
            array(
                'label' => __( 'Sale Price', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'product_sale_price_color',
                [
                    'label'     => __( 'Price Color', 'woovator' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .price' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'product_sale_price_typography',
                    'label'     => __( 'Typography', 'woovator' ),
                    'selector'  => '{{WRAPPER}} .price, {{WRAPPER}} .price .amount',
                )
            );

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        global $product;
        $product = wc_get_product();

        if( Plugin::instance()->editor->is_edit_mode() ){
            echo '<p class="price"><del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>20.00</span></del> <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>18.00</span></ins></p>';
        }else{
            if ( empty( $product ) ) { return; }
            woocommerce_template_single_price();
        }

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WV_Product_Price_Element() );
