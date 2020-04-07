<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WV_Product_Rating_Element extends Widget_Base {

    public function get_name() {
        return 'wv-single-product-rating';
    }

    public function get_title() {
        return __( 'WV: Product Rating', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-product-rating';
    }

    public function get_categories() {
        return array( 'woovator-addons' );
    }

    protected function _register_controls() {

        // Product Rating Style
        $this->start_controls_section(
            'product_rating_style_section',
            array(
                'label' => __( 'Style', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'product_rating_color',
                [
                    'label'     => __( 'Star Color', 'woovator' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .star-rating' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_rating_text_color',
                [
                    'label'     => __( 'Link Color', 'woovator' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} a.woocommerce-review-link' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'product_rating_link_typography',
                    'label'     => __( 'Link Typography', 'woovator' ),
                    'selector'  => '{{WRAPPER}} a.woocommerce-review-link',
                )
            );

            $this->add_control(
                'rating_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .woocommerce-product-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        global $product;
        $product = wc_get_product();

        if( Plugin::instance()->editor->is_edit_mode() ){
            echo '<div class="ratting">'.__( 'Product Rating','woovator' ).'</div>';
        } else{
            if ( empty( $product ) ) { return; }
            woocommerce_template_single_rating();
        }

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WV_Product_Rating_Element() );