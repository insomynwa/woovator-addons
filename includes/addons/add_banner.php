<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Woovator_Elementor_Widget_Add_Banner extends Widget_Base {

    public function get_name() {
        return 'woovator-addbanner-addons';
    }
    
    public function get_title() {
        return __( 'WV: Add Banner', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-photo-library';
    }

    public function get_categories() {
        return [ 'woovator-addons' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'banner-conent',
            [
                'label' => __( 'Banner', 'woovator' ),
            ]
        );
            
            $this->add_control(
                'banner_layout',
                [
                    'label' => __( 'Style', 'woovator' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'  => __( 'Style One', 'woovator' ),
                        '2'  => __( 'Style Two', 'woovator' )
                    ],
                ]
            );

            $this->add_control(
                'content_alignment',
                [
                    'label' => __( 'Content Alignment', 'woovator' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'left',
                    'options' => [
                        'left'  => __( 'Left', 'woovator' ),
                        'right' => __( 'Right', 'woovator' ),
                        'bottom' => __( 'Bottom', 'woovator' ),
                    ]
                ]
            );

            $this->add_control(
                'bannerimage',
                [
                    'label' => __( 'Banner image', 'woovator' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'bannerimagesize',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

            $this->add_control(
                'bannertitle',
                [
                    'label' => __( 'Banner Title', 'woovator' ),
                    'type' => Controls_Manager::TEXTAREA,
                ]
            );

            $this->add_control(
                'bannersubtitle',
                [
                    'label' => __( 'Banner Sub Title', 'woovator' ),
                    'type' => Controls_Manager::TEXTAREA,
                ]
            );

            $this->add_control(
                'buttontxt',
                [
                    'label' => __( 'Button Text', 'woovator' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'buttonlink',
                [
                    'label' => __( 'Button Link', 'woovator' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'woovator' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );

        $this->end_controls_section();

        // Slider Button stle
        $this->start_controls_section(
            'banner-style-section',
            [
                'label' => esc_html__( 'Style', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'title_style_heading',
                [
                    'label' => __( 'Title', 'woovator' ),
                    'type' => Controls_Manager::HEADING,
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#404040',
                    'selectors' => [
                        '{{WRAPPER}} .woovator-banner .banner_title' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'title_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woovator-banner .banner_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __( 'Typography', 'woovator' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .woovator-banner .banner_title',
                ]
            );

            $this->add_control(
                'sub_title_style_heading',
                [
                    'label' => __( 'Sub Title', 'woovator' ),
                    'type' => Controls_Manager::HEADING,
                    'separator'=>'before',
                ]
            );

            $this->add_control(
                'sub_title_color',
                [
                    'label' => __( 'Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#404040',
                    'selectors' => [
                        '{{WRAPPER}} .woovator-banner .banner_subtitle' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'sub_title_typography',
                    'label' => __( 'Typography', 'woovator' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .woovator-banner .banner_subtitle',
                ]
            );

            $this->add_responsive_control(
                'sub_title_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woovator-banner .banner_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'button_style_heading',
                [
                    'label' => __( 'Button', 'woovator' ),
                    'type' => Controls_Manager::HEADING,
                    'separator'=>'before',
                ]
            );

            $this->add_control(
                'button_color',
                [
                    'label' => __( 'Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#404040',
                    'selectors' => [
                        '{{WRAPPER}} .woovator-banner .banner_button' => 'color: {{VALUE}};border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'button_hover_color',
                [
                    'label' => __( 'Hover Color', 'woovator' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'default' => '#404040',
                    'selectors' => [
                        '{{WRAPPER}} .woovator-banner .banner_button:hover' => 'color: {{VALUE}};border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'button_typography',
                    'label' => __( 'Typography', 'woovator' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .woovator-banner .banner_button',
                ]
            );

        $this->end_controls_section(); // Tab option end

    }

    protected function render( $instance = [] ) {

        $settings   = $this->get_settings_for_display();
        $this->add_render_attribute( 'area_attr', 'class', 'woovator-banner' );
        $this->add_render_attribute( 'area_attr', 'class', 'woovator-content-align-'.$settings['content_alignment'] );
        $this->add_render_attribute( 'area_attr', 'class', 'woovator-banner-layout-'.$settings['banner_layout'] );

        // Button Link
        $target = $settings['buttonlink']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['buttonlink']['nofollow'] ? ' rel="nofollow"' : '';
       
        ?>
            <div <?php echo $this->get_render_attribute_string( 'area_attr' ); ?> >
                <div class="woovator-content">
                    <?php
                        if( !empty( $settings['bannersubtitle'] ) ){
                            echo '<h3 class="banner_subtitle">'.$settings['bannersubtitle'].'</h3>';
                        }
                        if( !empty( $settings['bannertitle'] ) ){
                            echo '<h2 class="banner_title">'.$settings['bannertitle'].'</h2>';
                        }
                        if( !empty( $settings['buttontxt'] ) ){
                            echo '<a class="banner_button" href="'.esc_url( $settings['buttonlink']['url'] ).'" '.$target.$nofollow.'>'.esc_html__( $settings['buttontxt'], 'woovator' ).'</a>';
                        }
                    ?>
                </div>
                <div class="woovator-banner-img">
                    <a href="<?php echo esc_url( $settings['buttonlink']['url'] );?>" <?php echo $target.$nofollow; ?> >
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'bannerimagesize', 'bannerimage' );?>
                    </a>
                </div>
            </div>
        <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Woovator_Elementor_Widget_Add_Banner() );

