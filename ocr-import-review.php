<?php

/**
 * Plugin Name: SBWC OCR Chart Import & Review
 * Description: Allows the import and review of product chart images and assignment of imported data to HTML Chart data.
 * Author: WC Bessinger
 * Version: 1.0.0
 */
// prevent direct access
defined( 'ABSPATH' ) ?: exit();

// init
add_action( 'plugins_loaded', 'ocr_import' );

function ocr_import() {

    // globals
    define( 'OCR_PATH', plugin_dir_path( __FILE__ ) );
    define( 'OCR_URL', plugin_dir_url( __FILE__ ) );

    // custom post type
    include OCR_PATH . 'core/cpt.php';

    // custom post type metadata and metaboxes
    include OCR_PATH . 'core/cpt-meta.php';

    // Function to process initial OCR data AJAX
    include OCR_PATH . 'ajax/process-ocr.php';

    // Function to save OCR data to product via AJAX
    include OCR_PATH . 'ajax/save-ocr.php';

    // JS/CSS/AJAX
    add_action( 'admin_enqueue_scripts', 'ocr_scripts' );

    function ocr_scripts() {

        $ajax_url = admin_url( 'admin-ajax.php' );

        // AJAX
        wp_register_script( 'ocr-process-parsed', OCR_URL . 'assets/ajax/ocr.process.parsed.js', [ 'jquery' ], '1.0.0', true );
        wp_localize_script( 'ocr-process-parsed', 'ocr_process_parsed', [
                'ajax_url' => $ajax_url,
                'nonce'    => wp_create_nonce( 'ocr process parsed' )
        ] );

        wp_register_script( 'ocr-save-parsed', OCR_URL . 'assets/ajax/ocr.save.parsed.js', [ 'jquery' ], '1.0.0', true );
        wp_localize_script( 'ocr-save-parsed', 'ocr_save_parsed', [
                'ajax_url' => $ajax_url,
                'nonce'    => wp_create_nonce( 'ocr save parsed' )
        ] );

        // Media Library JS
        wp_register_script( 'ocr-media-library', OCR_URL . 'assets/js/ml-upload-imgs.js', [ 'jquery' ], '1.0.0', true );

        // Chart editing JS
        wp_register_script( 'ocr-chart', OCR_URL . 'assets/js/chart.js', [ 'jquery' ], '1.0.0', true );

        // CSS
        wp_register_style( 'ocr-cpt-css', OCR_URL . 'assets/css/cpt.css', [], '1.0.0' );

        // TESSERACT/OCR
        wp_register_script( 'ocr-tesseract', OCR_URL . 'assets/tesseract/tesseract.min.js', [], '2.1.0', true );
        wp_register_script( 'ocr-process', OCR_URL . 'assets/tesseract/process.js', [ 'jquery' ], '1.0.0', true );
    }

}
