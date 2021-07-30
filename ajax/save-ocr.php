<?php

/**
 * Save OCR data to product meta
 * 
 * @author WC Bessinger <dev@silverbackdev.co.za>
 */
add_action( 'wp_ajax_ocr_save_parsed_data', 'ocr_save_parsed_data' );
add_action( 'wp_ajax_nopriv_ocr_save_parsed_data', 'ocr_save_parsed_data' );

function ocr_save_parsed_data() {

    check_ajax_referer( 'ocr save parsed' );

    // retrieve data
    $title_data_arr = $_POST[ 'title_data' ];
    $body_data_arr  = $_POST[ 'body_data' ];
    $product_sku    = $_POST[ 'product_sku' ];
    $product_id     = wc_get_product_id_by_sku( $product_sku );
    $ocr_post_id    = $_POST[ 'ocr_post_id' ];

    // setup condensed data array
    $condensed_data = [];

    // push header data to $condensed_data
    array_push( $condensed_data, $title_data_arr );

    // push body data to $condensed_data
    foreach ( $body_data_arr as $body_data ):
        array_push( $condensed_data, $body_data );
    endforeach;

    if ( is_array( $condensed_data ) && !empty( $condensed_data ) ):

        // json return array
        $json_return_arr = [];

        // save chart header data
        $header_meta                       = update_post_meta( $product_id, 'sb_chart_pre_header', maybe_serialize( $title_data_arr ) );
        $json_return_arr[ 'header_saved' ] = $header_meta;

        // save chart body data
        $body_meta                       = update_post_meta( $product_id, 'sb_chart_pre_body', maybe_serialize( $body_data_arr ) );
        $json_return_arr[ 'body_saved' ] = $body_meta;

        // save chart data all
        $chart_meta                       = update_post_meta( $product_id, 'sbarray_chart_data', maybe_serialize( $condensed_data ) );
        $json_return_arr[ 'chart_saved' ] = $chart_meta;

        // update ocr post
        $ocr_post_chart_meta                  = update_post_meta( $ocr_post_id, 'ocr_chart_data', maybe_serialize( $condensed_data ) );
        $json_return_arr[ 'ocr_chart_saved' ] = $ocr_post_chart_meta;

        // send json response back so that it can be saved to ocr chart meta
        wp_send_json_success( $json_return_arr );

    endif;

    wp_die();
}
