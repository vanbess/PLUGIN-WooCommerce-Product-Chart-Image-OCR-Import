<?php

// custom post type for handling OCR data
function cptui_register_my_cpts_ocr_chart() {

    /**
     * Post Type: OCR Charts.
     */
    $labels = [
            "name"                     => __( "OCR Charts", "woocommerce" ),
            "singular_name"            => __( "OCR Chart", "woocommerce" ),
            "menu_name"                => __( "OCR Charts", "woocommerce" ),
            "all_items"                => __( "All OCR Charts", "woocommerce" ),
            "add_new"                  => __( "Add new", "woocommerce" ),
            "add_new_item"             => __( "Add new OCR Chart", "woocommerce" ),
            "edit_item"                => __( "Edit OCR Chart", "woocommerce" ),
            "new_item"                 => __( "New OCR Chart", "woocommerce" ),
            "view_item"                => __( "View OCR Chart", "woocommerce" ),
            "view_items"               => __( "View OCR Charts", "woocommerce" ),
            "search_items"             => __( "Search OCR Charts", "woocommerce" ),
            "not_found"                => __( "No OCR Charts found", "woocommerce" ),
            "not_found_in_trash"       => __( "No OCR Charts found in trash", "woocommerce" ),
            "parent"                   => __( "Parent OCR Chart:", "woocommerce" ),
            "featured_image"           => __( "Featured image for this OCR Chart", "woocommerce" ),
            "set_featured_image"       => __( "Set featured image for this OCR Chart", "woocommerce" ),
            "remove_featured_image"    => __( "Remove featured image for this OCR Chart", "woocommerce" ),
            "use_featured_image"       => __( "Use as featured image for this OCR Chart", "woocommerce" ),
            "archives"                 => __( "OCR Chart archives", "woocommerce" ),
            "insert_into_item"         => __( "Insert into OCR Chart", "woocommerce" ),
            "uploaded_to_this_item"    => __( "Upload to this OCR Chart", "woocommerce" ),
            "filter_items_list"        => __( "Filter OCR Charts list", "woocommerce" ),
            "items_list_navigation"    => __( "OCR Charts list navigation", "woocommerce" ),
            "items_list"               => __( "OCR Charts list", "woocommerce" ),
            "attributes"               => __( "OCR Charts attributes", "woocommerce" ),
            "name_admin_bar"           => __( "OCR Chart", "woocommerce" ),
            "item_published"           => __( "OCR Chart published", "woocommerce" ),
            "item_published_privately" => __( "OCR Chart published privately.", "woocommerce" ),
            "item_reverted_to_draft"   => __( "OCR Chart reverted to draft.", "woocommerce" ),
            "item_scheduled"           => __( "OCR Chart scheduled", "woocommerce" ),
            "item_updated"             => __( "OCR Chart updated.", "woocommerce" ),
            "parent_item_colon"        => __( "Parent OCR Chart:", "woocommerce" ),
    ];

    $args = [
            "label"                 => __( "OCR Charts", "woocommerce" ),
            "labels"                => $labels,
            "description"           => "Handles data for image based charts imported using OCR",
            "public"                => true,
            "publicly_queryable"    => false,
            "show_ui"               => true,
            "show_in_rest"          => false,
            "rest_base"             => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "has_archive"           => false,
            "show_in_menu"          => true,
            "show_in_nav_menus"     => false,
            "delete_with_user"      => false,
            "exclude_from_search"   => true,
            "capability_type"       => "post",
            "map_meta_cap"          => true,
            "hierarchical"          => false,
            "rewrite"               => [ "slug" => "ocr_chart", "with_front" => false ],
            "query_var"             => true,
            "menu_position"         => 5,
            "menu_icon"             => "dashicons-chart-bar",
            "supports"              => [ "title" ],
            "show_in_graphql"       => false,
    ];

    register_post_type( "ocr_chart", $args );
}

add_action( 'init', 'cptui_register_my_cpts_ocr_chart' );
