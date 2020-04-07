<?php
/*
* Shop Page
*/

// Add to Cart Button Text
add_filter( 'woocommerce_product_add_to_cart_text', 'woovator_custom_add_cart_button_shop_page', 99, 2 );
function woovator_custom_add_cart_button_shop_page( $label ) {
   return __( woovator_get_option_label_text( 'wv_shop_add_to_cart_txt', 'woovator_rename_label_tabs', 'Add to Cart' ), 'woovator' );
}

/*
* Product Details Page
*/

// Add to Cart Button Text
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woovator_custom_add_cart_button_single_product' );
function woovator_custom_add_cart_button_single_product( $label ) {
   return __( woovator_get_option_label_text( 'wv_add_to_cart_txt', 'woovator_rename_label_tabs', 'Add to Cart' ), 'woovator-pro' );
}

// Translate
add_filter( 'gettext', 'woovator_translate_text', 20, 3 );
function woovator_translate_text( $translated, $untranslated, $domain ) {
    $wvtext = '';

    // Checkout Page
    if( is_checkout() ){
        switch ( $untranslated ) {

            case 'Billing details':
                $wvtext = woovator_get_option_label_text( 'wv_checkout_billig_form_title', 'woovator_rename_label_tabs', 'Billing details' );
                $translated = $wvtext;
                break;
                
        }
    }

    return $translated;
}