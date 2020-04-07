<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WV_Product_Additional_Info_Element extends Widget_Base {

    public function get_name() {
        return 'wv-product-additional-information';
    }

    public function get_title() {
        return __( 'WV: Product Additional Information', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-product-info';
    }

    public function get_categories() {
        return array( 'woovator-addons' );
    }

    protected function _register_controls() {


        // Slider Button stle
        $this->start_controls_section(
            'addition_info_content',
            [
                'label' => __( 'Heading', 'woovator' ),
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
                ]
            );

        $this->end_controls_section();

        // Content Style
        $this->start_controls_section(
            'content_style_section',
            array(
                'label' => __( 'Content', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'content_color',
                [
                    'label' => __( 'Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .shop_attributes' => 'color: {{VALUE}}',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_typography',
                    'label' => __( 'Typography', 'woovator' ),
                    'selector' => '.woocommerce {{WRAPPER}} .shop_attributes',
                ]
            ); 

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            echo '<div class="woocommerce-tabs-list"><div class="panel--additional_information panel entry-content" id="additional_information">
                    <h2>Additional information</h2>
                    <table class="woocommerce-product-attributes shop_attributes">
                        <tbody>
                            <tr>
                                <th>Color</th>
                                <td>Red</td>
                            </tr>
                        </tbody>
                    </table>
                </div></div>';
        } else{
            global $product;
            $product = wc_get_product();
            if ( empty( $product ) ) {
                return;
            }
            wc_get_template( 'single-product/tabs/additional-information.php' );
        }

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WV_Product_Additional_Info_Element() );
