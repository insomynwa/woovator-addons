<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WV_Product_Related_Element extends Widget_Base {

    public function get_name() {
        return 'wv-product-related';
    }

    public function get_title() {
        return __( 'WV: Related Product', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-product-related';
    }

    public function get_categories() {
        return array( 'woovator-addons' );
    }

    protected function _register_controls() {


        // Related Product Content
        $this->start_controls_section(
            'product_related_content',
            [
                'label' => __( 'Related Product', 'woovator' ),
            ]
        );
            $this->add_control(
                'posts_per_page',
                [
                    'label' => __( 'Products Per Page', 'woovator' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 4,
                    'range' => [
                        'px' => [
                            'max' => 20,
                        ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', 'woovator' ),
                    'type' => Controls_Manager::NUMBER,
                    'prefix_class' => 'woovatorducts-columns%s-',
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
                        'date' => __( 'Date', 'woovator' ),
                        'title' => __( 'Title', 'woovator' ),
                        'price' => __( 'Price', 'woovator' ),
                        'popularity' => __( 'Popularity', 'woovator' ),
                        'rating' => __( 'Rating', 'woovator' ),
                        'rand' => __( 'Random', 'woovator' ),
                        'menu_order' => __( 'Menu Order', 'woovator' ),
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
                ]
            );

            $this->add_control(
                'show_heading',
                [
                    'label' => __( 'Heading', 'woovator' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => __( 'Hide', 'woovator' ),
                    'label_on' => __( 'Show', 'woovator' ),
                    'default' => 'yes',
                    'return_value' => 'yes',
                    'prefix_class' => 'wvshow-heading-',
                ]
            );

        $this->end_controls_section();

        // Product Style
        $this->start_controls_section(
            'related_heading_style_section',
            array(
                'label' => __( 'Heading', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'related_heading_color',
                [
                    'label'     => __( 'Color', 'woovator' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-wv-product-related .products > h2' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'related_heading_typography',
                    'label'     => __( 'Typography', 'woovator' ),
                    'selector'  => '{{WRAPPER}}.elementor-widget-wv-product-related .products > h2',
                )
            );

            $this->add_responsive_control(
                'related_heading_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-wv-product-related .products > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'related_heading_align',
                [
                    'label'        => __( 'Alignment', 'woovator' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'woovator' ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'woovator' ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'woovator' ),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-wv-product-related .products > h2'   => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

    }


    protected function render( $instance = [] ) {

        $settings = $this->get_settings_for_display();

        global $product;
        $product = wc_get_product();

        if( Plugin::instance()->editor->is_edit_mode() ){
            echo '<div class="Related Product">'.__( 'Related Product','woovator' ).'</div>';
        } else{
            if ( ! $product ) { return; }
            $args = [
                'posts_per_page' => 4,
                'columns' => 4,
                'orderby' => $settings['orderby'],
                'order' => $settings['order'],
            ];
            if ( ! empty( $settings['posts_per_page'] ) ) {
                $args['posts_per_page'] = $settings['posts_per_page'];
            }
            if ( ! empty( $settings['columns'] ) ) {
                $args['columns'] = $settings['columns'];
            }

            // Get related Product
            $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), 
                $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
            $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
            wc_get_template( 'single-product/related.php', $args );
        }

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WV_Product_Related_Element() );
