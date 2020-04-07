<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Woovator_Elementor_Widget_Archive_Product extends Widget_Base {

    public function get_name() {
        return 'woovator-product-archive-addons';
    }
    
    public function get_title() {
        return __( 'WV: Product Archive Layout (Default)', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_categories() {
        return [ 'woovator-addons' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'product-archive-conent',
            [
                'label' => __( 'Archive Product', 'woovator' ),
            ]
        );
            
            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', 'woovator' ),
                    'type' => Controls_Manager::NUMBER,
                    'prefix_class' => 'woovatorproducts-columns%s-',
                    'min' => 1,
                    'max' => 12,
                    'default' => 4,
                    'required' => true,
                    'device_args' => [
                        Controls_Stack::RESPONSIVE_TABLET => [
                            'required' => false,
                        ],
                        Controls_Stack::RESPONSIVE_MOBILE => [
                            'required' => false,
                        ],
                    ],
                    'min_affected_device' => [
                        Controls_Stack::RESPONSIVE_DESKTOP => Controls_Stack::RESPONSIVE_TABLET,
                        Controls_Stack::RESPONSIVE_TABLET => Controls_Stack::RESPONSIVE_TABLET,
                    ],
                ]
            );

            $this->add_control(
                'rows',
                [
                    'label' => __( 'Rows', 'woovator' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 4,
                    'render_type' => 'template',
                    'range' => [
                        'px' => [
                            'max' => 20,
                        ],
                    ],
                ]
            );

            $this->add_control(
                'paginate',
                [
                    'label' => __( 'Pagination', 'woovator' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                ]
            );

            $this->add_control(
                'allow_order',
                [
                    'label' => __( 'Allow Order', 'woovator' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                    'condition' => [
                        'paginate' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'show_result_count',
                [
                    'label' => __( 'Show Result Count', 'woovator' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                    'condition' => [
                        'paginate' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => __( 'Order by', 'woovator' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'date',
                    'options' => [
                        'date' => __( 'Date', 'woovator' ),
                        'title' => __( 'Title', 'woovator' ),
                        'price' => __( 'Price', 'woovator' ),
                        'popularity' => __( 'Popularity', 'woovator' ),
                        'rating' => __( 'Rating', 'woovator' ),
                        'rand' => __( 'Random', 'woovator' ),
                        'menu_order' => __( 'Menu Order', 'woovator' ),
                    ],
                    'condition' => [
                        'paginate!' => 'yes',
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
                        'asc' => __( 'ASC', 'woovator' ),
                        'desc' => __( 'DESC', 'woovator' ),
                    ],
                    'condition' => [
                        'paginate!' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'query_post_type',
                [
                    'type' => 'hidden',
                    'default' => 'current_query',
                ]
            );

        $this->end_controls_section();

        // Item Style Section
        $this->start_controls_section(
            'product-item-section',
            [
                'label' => esc_html__( 'Item', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'item_border',
                    'label' => __( 'Border', 'woovator' ),
                    'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product',
                ]
            );

            $this->add_responsive_control(
                'item_border_radius',
                [
                    'label' => __( 'Border Radius', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'item_padding',
                [
                    'label' => __( 'Padding', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'item_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'item_box_shadow',
                    'label' => __( 'Box Shadow', 'woovator' ),
                    'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product',
                ]
            );

            $this->add_responsive_control(
                'item_alignment',
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
                    'prefix_class' => 'woovator-product-loop-item-align-',
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // image Style Section
        $this->start_controls_section(
            'product-image-section',
            [
                'label' => esc_html__( 'Image', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'image_border',
                    'label' => __( 'Border', 'woovator' ),
                    'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons .attachment-woocommerce_thumbnail',
                ]
            );

            $this->add_responsive_control(
                'image_border_radius',
                [
                    'label' => __( 'Border Radius', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons .attachment-woocommerce_thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'image_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons .attachment-woocommerce_thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // Title Style Section
        $this->start_controls_section(
            'product-title-section',
            [
                'label' => esc_html__( 'Title', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->start_controls_tabs('product_title_style_tabs');

                // Title Normal Style
                $this->start_controls_tab(
                    'product_title_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'woovator' ),
                    ]
                );
                    $this->add_control(
                        'product_title_color',
                        [
                            'label' => __( 'Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Scheme_Color::get_type(),
                                'value' => Scheme_Color::COLOR_1,
                            ],
                            'default'=>'#000000',
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .woocommerce-loop-product__title' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'product_title_typography',
                            'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .woocommerce-loop-product__title',
                        ]
                    );

                    $this->add_responsive_control(
                        'product_title_padding',
                        [
                            'label' => __( 'Padding', 'woovator' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .woocommerce-loop-product__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_title_margin',
                        [
                            'label' => __( 'Margin', 'woovator' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Title Hover Style
                $this->start_controls_tab(
                    'product_title_style_hover_tab',
                    [
                        'label' => __( 'Normal', 'woovator' ),
                    ]
                );
                    
                    $this->add_control(
                        'product_title_hover_color',
                        [
                            'label' => __( 'Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Scheme_Color::get_type(),
                                'value' => Scheme_Color::COLOR_1,
                            ],
                            'default'=>'#000000',
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .woocommerce-loop-product__title:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Price Style Section
        $this->start_controls_section(
            'product-price-section',
            [
                'label' => esc_html__( 'Price', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control(
                'sell_price_heading',
                [
                    'label' => __( 'Sale Price', 'woovator' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_price_color',
                [
                    'label' => __( 'Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#000000',
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .price' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .price ins' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .price ins .amount' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_price_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .price',
                ]
            );

            // Regular Price
            $this->add_control(
                'regular_price_heading',
                [
                    'label' => __( 'Regular Price', 'woovator' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_regular_price_color',
                [
                    'label' => __( 'Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default'=>'#000000',
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .price del' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .price del .amount' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_regular_price_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .price del .amount  ',
                    'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .price del ',
                ]
            );

        $this->end_controls_section();

        // Rating Style Section
        $this->start_controls_section(
            'product-rating-section',
            [
                'label' => esc_html__( 'Rating', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'product_rating_color',
                [
                    'label' => __( 'Rating Start Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .star-rating' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'product_empty_rating_color',
                [
                    'label' => __( 'Empty Rating Start Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .star-rating::before' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'product_rating_star_size',
                [
                    'label' => __( 'Star Size', 'woovator' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_rating_start_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .star-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // Add to Cart Button Style Section
        $this->start_controls_section(
            'product-addtocartbutton-section',
            [
                'label' => esc_html__( 'Add To Cart Button', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->start_controls_tabs('product_addtocartbutton_style_tabs');

                // Add to cart normal style
                $this->start_controls_tab(
                    'product_addtocartbutton_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'woovator' ),
                    ]
                );
                    $this->add_control(
                        'atc_button_text_color',
                        [
                            'label' => __( 'Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '',
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'atc_button_background_color',
                        [
                            'label' => __( 'Background Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'atc_button_border',
                            'label' => __( 'Border', 'woovator' ),
                            'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button',
                        ]
                    );

                    $this->add_responsive_control(
                        'atc_button_border_radius',
                        [
                            'label' => __( 'Border Radius', 'woovator' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'atc_button_typography',
                            'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                            'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button',
                        ]
                    );

                    $this->add_responsive_control(
                        'atc_button_margin',
                        [
                            'label' => __( 'Margin', 'woovator' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'atc_button_padding',
                        [
                            'label' => __( 'Padding', 'woovator' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Add to cart hover style
                $this->start_controls_tab(
                    'product_addtocartbutton_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'woovator' ),
                    ]
                );
                    $this->add_control(
                        'atc_button_hover_color',
                        [
                            'label' => __( 'Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'atc_button_hover_background_color',
                        [
                            'label' => __( 'Background Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button:hover' => 'background-color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'atc_button_hover_border',
                            'label' => __( 'Border', 'woovator' ),
                            'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product .button:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();


        // Pagination Style Section
        $this->start_controls_section(
            'product-pagination-section',
            [
                'label' => esc_html__( 'Pagination', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'paginate' => 'yes',
                ],
            ]
        );
            $this->start_controls_tabs('product_pagination_style_tabs');

                // Pagination normal style
                $this->start_controls_tab(
                    'product_pagination_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'woovator' ),
                    ]
                );
                    
                    $this->add_control(
                        'product_pagination_border_color',
                        [
                            'label' => __( 'Border Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul' => 'border-color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul li' => 'border-right-color: {{VALUE}}; border-left-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_pagination_padding',
                        [
                            'label' => __( 'Padding', 'woovator' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul li a, {{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul li span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_pagination_link_color',
                        [
                            'label' => __( 'Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul li a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_pagination_link_bg_color',
                        [
                            'label' => __( 'Background Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul li a' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Pagination Active style
                $this->start_controls_tab(
                    'product_pagination_style_active_tab',
                    [
                        'label' => __( 'Active', 'woovator' ),
                    ]
                );
                    
                    $this->add_control(
                        'product_pagination_link_color_hover',
                        [
                            'label' => __( 'Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul li a:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul li span.current' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_pagination_link_bg_color_hover',
                        [
                            'label' => __( 'Background Color', 'woovator' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul li a:hover' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons nav.woocommerce-pagination ul li span.current' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

         // Sale Flash Style Section
        $this->start_controls_section(
            'product-saleflash-style-section',
            [
                'label' => esc_html__( 'Sale Tag', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'product_show_onsale_flash',
                [
                    'label' => __( 'Sale Flash', 'woovator' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => __( 'Hide', 'woovator' ),
                    'label_on' => __( 'Show', 'woovator' ),
                    'separator' => 'before',
                    'default' => 'yes',
                    'return_value' => 'yes',
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product span.onsale' => 'display: block',
                    ],
                ]
            );

            $this->add_control(
                'product_onsale_text_color',
                [
                    'label' => __( 'Text Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product span.onsale' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'product_show_onsale_flash' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'product_onsale_background_color',
                [
                    'label' => __( 'Background Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product span.onsale' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'product_show_onsale_flash' => 'yes',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_onsale_typography',
                    'selector' => '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product span.onsale',
                    'condition' => [
                        'product_show_onsale_flash' => 'yes',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_onsale_padding',
                [
                    'label' => __( 'Padding', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                    'condition' => [
                        'product_show_onsale_flash' => 'yes',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_onsale_border_radius',
                [
                    'label' => __( 'Border Radius', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                    'condition' => [
                        'product_show_onsale_flash' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'product_onsale_position',
                [
                    'label' => __( 'Position', 'woovator' ),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => false,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'woovator' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'woovator' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-woovator-product-archive-addons ul.products li.product span.onsale' => '{{VALUE}}',
                    ],
                    'selectors_dictionary' => [
                        'left' => 'right: auto; left: 0',
                        'right' => 'left: auto; right: 0',
                    ],
                    'condition' => [
                        'product_show_onsale_flash' => 'yes',
                    ],
                ]
            );

        $this->end_controls_section();

    }

    public function woovator_custom_product_limit( $limit = 3 ) {
        $limit = ( $this->get_settings_for_display('columns')*$this->get_settings_for_display('row') );
        return $limit;
    }

    protected function render( $instance = [] ) {

        $settings = $this->get_settings_for_display();
       
        if ( WC()->session ) {
            wc_print_notices();
        }

        if ( ! isset( $GLOBALS['post'] ) ) {
            $GLOBALS['post'] = null;
        }

        $settings = $this->get_settings();
        $settings['editor_mode'] = Plugin::instance()->editor->is_edit_mode();
        add_filter( 'product_custom_limit', array( $this, 'woovator_custom_product_limit' ) );
        $shortcode = new \Archive_Products_Render( $settings );

        $content = $shortcode->get_content();
        if ( $content ) {
            echo $content;
        } else{
            echo '<div class="products-not-found">' . esc_html__( 'Product Not Available','woovator' ) . '</div>';
        }

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Woovator_Elementor_Widget_Archive_Product() );

