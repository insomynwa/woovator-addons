<?php

    // add extra metabox tab to woocommerce
    if( !function_exists('woovator_add_wc_extra_metabox_tab')){
        function woovator_add_wc_extra_metabox_tab($tabs){
            $woovator_tab = array(
                'label'    => __( 'Product Badge', 'woovator' ),
                'target'   => 'woovator_product_data',
                'class'    => '',
                'priority' => 80,
            );
            $tabs[] = $woovator_tab;
            return $tabs;
        }
        add_filter( 'woocommerce_product_data_tabs', 'woovator_add_wc_extra_metabox_tab' );
    }

    // add metabox to general tab
    if( !function_exists('woovator_add_metabox_to_general_tab')){
        function woovator_add_metabox_to_general_tab(){
            echo '<div id="woovator_product_data" class="panel woocommerce_options_panel hidden">';
                woocommerce_wp_text_input( array(
                    'id'          => '_saleflash_text',
                    'label'       => __( 'Custom Product Badge Text', 'woovator' ),
                    'placeholder' => __( 'New', 'woovator' ),
                    'description' => __( 'Enter your prefered SaleFlash text. Ex: New / Free etc', 'woovator' ),
                ) );
            echo '</div>';
        }
        add_action( 'woocommerce_product_data_panels', 'woovator_add_metabox_to_general_tab' );
    }
    // Update data
    if( !function_exists('woovator_save_metabox_of_general_tab') ){
        function woovator_save_metabox_of_general_tab( $post_id ){
            $saleflash_text = wp_kses_post( stripslashes( $_POST['_saleflash_text'] ) );
            update_post_meta( $post_id, '_saleflash_text', $saleflash_text);
        }
        add_action( 'woocommerce_process_product_meta', 'woovator_save_metabox_of_general_tab');
    }

?>