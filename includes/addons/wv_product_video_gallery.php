<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WV_Product_Video_Gallery_ELement extends Widget_Base {

    public function get_name() {
        return 'wv-product-video-gallery';
    }

    public function get_title() {
        return __( 'WV: Product Video Gallery', 'woovator' );
    }

    public function get_icon() {
        return 'eicon-video-camera';
    }

    public function get_categories() {
        return array( 'woovator-addons' );
    }

    public function get_script_depends() {
        return [
            'woovator-widgets-scripts',
        ];
    }

    protected function _register_controls() {

         $this->start_controls_section(
            'product_thumbnails_content',
            array(
                'label' => __( 'Video Thumbanails', 'woovator' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            )
        );
            
            $this->add_control(
                'tab_thumbnails_position',
                [
                    'label'   => __( 'Thumbnails Position', 'woovator' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'woovator' ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'woovator' ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'top' => [
                            'title' => __( 'Top', 'woovator' ),
                            'icon'  => 'eicon-v-align-top',
                        ],
                        'bottom' => [
                            'title' => __( 'Bottom', 'woovator' ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => 'bottom',
                    'toggle'      => false,
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();
        
        // Product Main Image Style
        $this->start_controls_section(
            'product_image_style_section',
            [
                'label' => __( 'Main Video Area', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'main_video_height',
                [
                    'label' => __( 'Height', 'plugin-domain' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 550,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .embed-responsive' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_image_border',
                    'label' => __( 'Product image border', 'woovator' ),
                    'selector' => '{{WRAPPER}} .woovator-product-gallery-video',
                ]
            );

            $this->add_responsive_control(
                'product_image_border_radius',
                [
                    'label' => __( 'Border Radius', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woovator-product-gallery-video img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .woovator-product-gallery-video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .embed-responsive' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_margin',
                [
                    'label' => __( 'Margin', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woovator-product-gallery-video' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // Product Thumbnails Image Style
        $this->start_controls_section(
            'product_image_thumbnails_style_section',
            [
                'label' => __( 'Thumbnails', 'woovator' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_thumbnais_image_border',
                    'label' => __( 'Product image border', 'woovator' ),
                    'selector' => '{{WRAPPER}} .woovator-product-video-tabs li a',
                ]
            );

            $this->add_responsive_control(
                'product_thumbnais_image_border_radius',
                [
                    'label' => __( 'Border Radius', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woovator-product-video-tabs li a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .woovator-product-video-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_product_thumbnais_padding',
                [
                    'label' => __( 'Padding', 'woovator' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woovator-product-video-tabs li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();

    }

    protected function render() {
        $settings  = $this->get_settings_for_display();

        $this->add_render_attribute( 'wv_product_thumbnails_attr', 'class', 'wvpro-product-videothumbnails thumbnails-tab-position-'.$settings['tab_thumbnails_position'] );

        global $product;
        $product = wc_get_product();
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            echo '<div class="product-image">'.__('Product Video Gallery','woovator').'</div>';
        }else{

            if ( empty( $product ) ) { return; }
            $gallery_images_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
            if ( has_post_thumbnail() ){
                array_unshift( $gallery_images_ids, $product->get_image_id() );
            }

            ?>

            <div <?php echo $this->get_render_attribute_string( 'wv_product_thumbnails_attr' ); ?>>
                <div class="wv-thumbnails-image-area">

                        <?php if( $settings['tab_thumbnails_position'] == 'left' || $settings['tab_thumbnails_position'] == 'top' ): ?>
                            <ul class="woovator-product-video-tabs">
                                <?php
                                    $j=0;
                                    foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) {
                                        $j++;
                                        if( $j == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                        $video_url = get_post_meta( $gallery_attachment_id, 'woovator_video_url', true );
                                        ?>
                                        <li class="<?php if( !empty( $video_url ) ){ echo 'wvvideothumb'; }?>">
                                            <a class="<?php echo $tabactive; ?>" href="#wvvideo-<?php echo $j; ?>">
                                                <?php
                                                    if( !empty( $video_url ) ){
                                                        echo '<span class="wvvideo-button"><i class="sli sli-control-play"></i></span>';
                                                        echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                    }else{
                                                        echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                    }
                                                ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        <?php endif; ?>

                        <div class="woovator-product-gallery-video">
                            <?php
                                $i = 0;
                                foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) {
                                    $i++;
                                    if( $i == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                    $video_url = get_post_meta( $gallery_attachment_id, 'woovator_video_url', true );
                                    ?>
                                    <div class="video-cus-tab-pane <?php echo $tabactive; ?>" id="wvvideo-<?php echo $i; ?>">
                                        <?php
                                            if( !empty( $video_url ) ){
                                                ?>
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <?php echo wp_oembed_get( $video_url ); ?>
                                                    </div>
                                                <?php
                                            }else{
                                                echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_single' );
                                            }
                                        ?>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>

                        <?php if( $settings['tab_thumbnails_position'] == 'right' || $settings['tab_thumbnails_position'] == 'bottom' ): ?>

                            <ul class="woovator-product-video-tabs">
                                <?php
                                    $j=0;
                                    foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) {
                                        $j++;
                                        if( $j == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                        $video_url = get_post_meta( $gallery_attachment_id, 'woovator_video_url', true );
                                        ?>
                                        <li class="<?php if( !empty( $video_url ) ){ echo 'wvvideothumb'; }?>">
                                            <a class="<?php echo $tabactive; ?>" href="#wvvideo-<?php echo $j; ?>">
                                                <?php
                                                    if( !empty( $video_url ) ){
                                                        echo '<span class="wvvideo-button"><i class="sli sli-control-play"></i></span>';
                                                        echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                    }else{
                                                        echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                    }
                                                ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                ?>
                            </ul>

                        <?php endif; ?>
                        
                </div>
            </div>

            <?php
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new WV_Product_Video_Gallery_ELement() );