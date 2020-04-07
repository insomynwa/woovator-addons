<?php
    /**
    *  Product Video Gallery
    */
    class Wv_Product_Video_Gallery{
        
        private static $_instance = null;
        public static function instance(){
            if( is_null( self::$_instance ) ){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        function __construct(){

            // Meta data
            add_filter( 'attachment_fields_to_edit', array( $this, 'woovator_attachment_field_video' ), 10, 2 );
            add_filter( 'attachment_fields_to_save', array( $this, 'woovator_attachment_field_video_save'), 10, 2 );

        }

        // Add Custom Meta Field
        function woovator_attachment_field_video( $form_fields, $post ) {

            $form_fields['woovator-product-video-url'] = array(
                'label' => esc_html__( 'Video', 'woovator' ),
                'input' => 'text',
                'value' => get_post_meta( $post->ID, 'woovator_video_url', true ),
                'helps' => esc_html__( 'Add Youtube / Vimeo URL', 'woovator' )
            );
            return $form_fields;

        }

        // Save Custom Meta Field data
        function woovator_attachment_field_video_save( $post, $attachment ) {
            if ( isset( $attachment['woovator-product-video-url'] ) ) {
                update_post_meta( $post['ID'], 'woovator_video_url', esc_url( $attachment['woovator-product-video-url'] ) );
            }else{
                delete_post_meta( $post['ID'], 'woovator_video_url' );
            }
            return $post;
        }

    }

    Wv_Product_Video_Gallery::instance();