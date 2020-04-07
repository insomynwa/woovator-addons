<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WV_Product_Product_Data_Tabs_Element extends Widget_Base {

    public function get_name() {
        return 'wv-product-data-tabs';
    }

    public function get_title() {
        return __( 'WV: Product Data Tabs', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-product-tabs';
    }

    public function get_categories() {
        return array( 'woovator-addons' );
    }

    protected function _register_controls() {

        // Product Style
        $this->start_controls_section(
            'product_tabs_style_section',
            array(
                'label' => __( 'Tab Menu', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->start_controls_tabs( 'data_tabs_style' );

                $this->start_controls_tab( 'normal_data_tab_style',
                    [
                        'label' => __( 'Normal', 'woovator' ),
                    ]
                );

                    $this->add_control(
                        'tab_text_color',
                        [
                            'label' => __( 'Text Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'tab_background_color',
                        [
                            'label' => __( 'Background Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'tab_border_color',
                        [
                            'label' => __( 'Border Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'tab_typography',
                            'label' => __( 'Typography', 'woovator' ),
                            'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a',
                        ]
                    );

                    $this->add_control(
                        'tab_border_radius',
                        [
                            'label' => __( 'Border Radius', 'woovator' ),
                            'type' => Controls_Manager::SLIDER,
                            'selectors' => [
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'tab_text_align',
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
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs' => 'text-align: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Active Tab style
                $this->start_controls_tab( 'active_data_tab_style',
                    [
                        'label' => __( 'Active', 'woovator' ),
                    ]
                );

                    $this->add_control(
                        'active_tab_text_color',
                        [
                            'label' => __( 'Text Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'active_tab_background_color',
                        [
                            'label' => __( 'Background Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel, .woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'background-color: {{VALUE}}',
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-bottom-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'active_tab_border_color',
                        [
                            'label' => __( 'Border Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-color: {{VALUE}} {{VALUE}} {{active_tab_bg_color.VALUE}} {{VALUE}}',
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li:not(.active)' => 'border-bottom-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'active_tab_typography',
                            'label' => __( 'Typography', 'woovator' ),
                            'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a',
                        ]
                    );

                    $this->add_control(
                        'active_tab_border_radius',
                        [
                            'label' => __( 'Border Radius', 'woovator' ),
                            'type' => Controls_Manager::SLIDER,
                            'selectors' => [
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Content Style
        $this->start_controls_section(
            'product_data_tab_content_style',
            [
                'label' => __( 'Content', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'tab_description_typography',
                    'label' => __( 'Typography', 'woovator' ),
                    'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel',
                ]
            );

            $this->add_control(
                'tab_content_description_color',
                [
                    'label' => __( 'Text Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel' => 'color: {{VALUE}}',
                    ],
                    'separator' => 'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'content_heading_typography',
                    'label' => __( 'Heading Typography', 'woovator' ),
                    'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel h2',
                ]
            );

            $this->add_control(
                'content_heading_color',
                [
                    'label' => __( 'Heading Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel h2' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'content_heading_margin',
                [
                    'label' => __( 'Heading Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();

        if ( Plugin::instance()->editor->is_edit_mode() ) {
            echo '<div class="woocommerce-tabs wc-tabs-wrapper">'.__( 'Product Data Tabs', 'woovator' ).'</div>';
        }else{
            global $product;
            $product = wc_get_product();
            if ( empty( $product ) ) {
                return;
            }
            setup_postdata( $product->get_id() );
            wc_get_template( 'single-product/tabs/tabs.php' );
        }

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WV_Product_Product_Data_Tabs_Element() );
