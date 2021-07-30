<?php

/**
 * Process submitted OCR data and adds to product meta
 */
add_action( 'wp_ajax_ocr_process_parsed_data', 'ocr_process_parsed_data' );
add_action( 'wp_ajax_nopriv_ocr_process_parsed_data', 'ocr_process_parsed_data' );

function ocr_process_parsed_data() {

    check_ajax_referer( 'ocr process parsed' );

    // ***************************************
    // Perform initial processing of OCR data
    // ***************************************
    // setup main data array
    $data_array = [
            'title' => [],
            'body'  => []
    ];

    // header data
    $header_data = $_POST[ 'header_data' ];

    // main data
    $main_data = $_POST[ 'main_data' ];

    // initial main data split
    $init_main_data_split = array_filter( explode( PHP_EOL, $main_data ) );

    foreach ( $init_main_data_split as $main_data_item ):
        $main_data_item_array = explode( ' ', $main_data_item );
        array_push( $data_array[ 'body' ], $main_data_item_array );
    endforeach;

    // parse header data to array
    $header_arr            = explode( ' ', $header_data );
    $data_array[ 'title' ] = $header_arr;

    // if data exists and isn't empty, send back response
    if ( $data_array && !empty( $data_array ) ):
        wp_send_json( $data_array );
    endif;

    wp_die();
}
