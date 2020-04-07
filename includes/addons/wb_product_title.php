<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WV_Product_Title_Element extends Widget_Base {

    public function get_name() {
        return 'wv-single-product-title';
    }

    public function get_title() {
        return __( 'WV: Product title', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-product-title';
    }

    public function get_categories() {
        return array( 'woovator-addons' );
    }

    protected function _register_controls() {


        // Slider Button stle
        $this->start_controls_section(
            'product_title_content',
            [
                'label' => __( 'Product Title', 'woovator' ),
            ]
        );
            $this->add_control(
                'product_title_html_tag',
                [
                    'label'   => __( 'Title HTML Tag', 'woovator' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => woovator_html_tag_lists(),
                    'default' => 'h1',
                ]
            );

        $this->end_controls_section();

        // Product Style
        $this->start_controls_section(
            'product_style_section',
            array(
                'label' => __( 'Product Title', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'product_title_color',
                [
                    'label'     => __( 'Title Color', 'woovator' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .product_title' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'product_title_typography',
                    'label'     => __( 'Typography', 'woovator' ),
                    'selector'  => '{{WRAPPER}} .product_title',
                )
            );

            $this->add_responsive_control(
                'product_title_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .product_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'product_title_align',
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
                    'prefix_class' => 'elementor-align-%s',
                    'default'      => 'left',
                ]
            );

        $this->end_controls_section();

    }

    protected function render( $instance = [] ) {
        $settings   = $this->get_settings_for_display();
        if( Plugin::instance()->editor->is_edit_mode() ){
            echo sprintf( '<%1$s class="product_title entry-title">' . __('Product Title', 'woovator' ). '</%1$s>', $settings['product_title_html_tag'] );
        }else{
            echo sprintf( the_title( '<%1$s class="product_title entry-title">', '</%1s>', false ), $settings['product_title_html_tag']  );
        }

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new WV_Product_Title_Element() );
