<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WV_Product_Short_Description_Element extends Widget_Base {

    public function get_name() {
        return 'wv-single-product-short-description';
    }

    public function get_title() {
        return __( 'WV: Product Short Description', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-product-description';
    }

    public function get_categories() {
        return array( 'woovator-addons' );
    }

    protected function _register_controls() {


        // Style
        $this->start_controls_section(
            'product_content_style_section',
            array(
                'label' => __( 'Style', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_responsive_control(
                'text_align',
                [
                    'label' => __( 'Alignment', 'woovator' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'woovator' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'woovator' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'woovator' ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'woovator' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'text_color',
                [
                    'label' => __( 'Text Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .woocommerce-product-details__short-description' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'text_typography',
                    'label' => __( 'Typography', 'woovator' ),
                    'selector' => '.woocommerce {{WRAPPER}} .woocommerce-product-details__short-description',
                ]
            );

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {
        global $product;
        $product = wc_get_product();
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            echo '<div class="woocommerce-product-details__short-description"><p>This is a simple product.</p></div>';
        }else{
            if ( empty( $product ) ) {
                return;
            }
            wc_get_template( 'single-product/short-description.php' );
        }
    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WV_Product_Short_Description_Element() );
