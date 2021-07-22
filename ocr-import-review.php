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
add_action('plugins_loaded', 'ocr_import');

function ocr_import(){
    
    // globals
    define('OCR_PATH', plugin_dir_path(__FILE__));
    define('OCR_URL', plugin_dir_url(__FILE__));
    
    // custom post type
    include OCR_PATH.'core/cpt.php';
    
    // custom post type metadata and metaboxes
    include OCR_PATH.'core/cpt-meta.php';
    
    // JS/CSS/AJAX
    add_action('admin_enqueue_scripts', 'ocr_scripts');
    
    function ocr_scripts() {
        
        // AJAX
        wp_register_script('ocr_data_parse', OCR_URL.'assets/ajax/ajax-ocr-parse.js', ['jquery'], '1.0.0', true);
        wp_register_script('ocr_save_parsed', OCR_URL.'assets/ajax/ajax-save-parsed.js', ['jquery'], '1.0.0', true);
        
        // Media Library JS
        wp_register_script('ocr_media_library', OCR_URL.'assets/js/ml-upload-imgs.js', ['jquery'], '1.0.0', true);
        
        // CSS
        wp_register_style('ocr_cpt_css', OCR_URL.'assets/css/cpt.css', [], '1.0.0');
        
        
    }
}