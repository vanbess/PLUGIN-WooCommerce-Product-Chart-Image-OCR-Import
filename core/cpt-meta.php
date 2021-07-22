<?php
/**
 * Adds custom meta boxes to ocr_chart post type
 * 
 * @author WC Bessinger <dev@silverbackdev.co.za>
 */

/**
 * Add custom metaboxes to cpt
 */
function ocr_chart_custom_metabox() {

    // original size chart image
    add_meta_box( 'ocr_chart_metabox', __( 'Original Size Chart & Parsed Chart Data', 'woocommerce' ), 'ocr_original_chart_img', 'ocr_chart' );

    // parsed size chart (as in HTML Size Chart)
    add_meta_box( 'ocr_editable_chart', __( 'Editable Size Chart' ), 'ocr_editable_size_chart', 'ocr_chart' );
}

add_action( 'add_meta_boxes', 'ocr_chart_custom_metabox' );

/**
 * Render ocr_chart_metabox
 */
function ocr_original_chart_img($post) {

    // retrieve relevant post meta
    $chart_header_img = get_post_meta( $post->ID, 'ocr_chart_header_image', true );
    $chart_main_img   = get_post_meta( $post->ID, 'ocr_chart_main_image', true );

    // css
    wp_enqueue_style( 'ocr_cpt_css' );

    // media library js
    wp_enqueue_script( 'ocr_media_library' );

    // ajax scripts
    wp_enqueue_script( 'ocr_data_parse' );
    wp_enqueue_script( 'ocr_save_parsed' );

    // create nonce
    wp_nonce_field( 'ocr_check_nonce', 'ocr_nonce' );
    ?>

    <div class="ocr_chart_images_parsed_data_cont">

        <!-- chart images -->
        <div class="ocr_original_chart_img">

            <!-- product sku -->
            <div class="ocr_product_sku">
                <label for="ocr_product_sku"><?php _e( 'Product SKU', 'woocommerce' ); ?></label>
                <input type="text" name="ocr_product_sku" id="ocr_product_sku" value="<?php echo get_post_meta( $post->ID, 'ocr_product_sku', true ); ?>">
            </div>

            <!-- header image -->
            <div class="ocr_original_chart_header_img_cont">

                <!-- header image cont -->
                <div class="ocr_header_img_cont" style="<?php $chart_header_img ? print 'display: block;' : print 'display: none;' ?>">

                    <!-- remove header image -->
                    <a href="#" id="ocr_remove_header_img" title="<?php _e( 'Remove header image', 'woocommerce' ); ?>">x</a>

                    <label for="ocr_chart_header_image"><?php _e( 'Chart Header Image', 'woocommerce' ); ?></label>

                    <!-- header image actual -->
                    <img id="ocr_chart_header_image" src="<?php echo $chart_header_img; ?>" alt="<?php echo $post->post_title; ?>"/>

                    <!-- input hidden -->
                    <input type="hidden" id="ocr_chart_header_image_input" name="ocr_chart_header_image" value="<?php echo $chart_header_img; ?>">

                    <!-- parse image data -->
                    <button id="ocr_parse_header_image" class="button button-primary">
                        <?php _e( 'Parse Chart Header Image', 'woocommerce' ); ?>
                    </button>

                </div>

                <!-- add chart header image -->
                <div class="ocr_upload_header_img_cont" style="<?php $chart_header_img ? print 'display: none;' : print 'display: block;' ?>">
                    <label for="ocr_add_header_image"><?php _e( 'Upload Chart Header Image', 'woocommerce' ); ?></label>               
                    <a href="#" id="ocr_add_header_image" data-target="#ocr_chart_header_image">+</a>
                </div>

            </div>

            <!-- main image -->
            <div class="ocr_original_chart_main_img_cont">

                <!-- main chart image -->
                <div class="ocr_main_img_cont" style="<?php $chart_main_img ? print 'display: block;' : print 'display: none;' ?>">

                    <!-- remove main image -->
                    <a href="#" id="ocr_remove_main_img" title="<?php _e( 'Remove main image', 'woocommerce' ); ?>">x</a>

                    <!-- label -->
                    <label for="ocr_chart_main_image"><?php _e( 'Chart Main Image', 'woocommerce' ); ?></label>

                    <!-- main image actual -->
                    <img id="ocr_chart_main_image" src="<?php echo $chart_main_img; ?>" alt="<?php echo $post->post_title; ?>"/>

                    <!-- input hidden -->
                    <input type="hidden" id="ocr_chart_main_image_input" name="ocr_chart_main_image" value="<?php echo $chart_main_img; ?>">

                    <!-- parse image data -->
                    <button id="ocr_parse_header_image" class="button button-primary">
                        <?php _e( 'Parse Chart Main Image', 'woocommerce' ); ?>
                    </button>

                </div>

                <!-- add chart main image -->
                <div class="ocr_upload_main_img_cont" style="<?php $chart_main_img ? print 'display: none;' : print 'display: block;' ?>">
                    <label for="ocr_add_main_image"><?php _e( 'Upload Chart Main Image', 'woocommerce' ); ?></label>              
                    <a href="#" id="ocr_add_main_image" data-target="#ocr_chart_main_image">+</a>
                </div>


            </div>

        </div>

        <!-- parsed ocr data -->
        <div class="ocr_parsed_data">

            <!-- parsed header data -->
            <div class="ocr_parsed_header_data_cont">

                <label for="ocr_parsed_header_data"><?php _e( 'Parsed Chart Header Data', 'woocommerce' ); ?></label>

                <textarea id="ocr_parsed_header_data" name="ocr_parsed_header_data" rows="5" cols="100"><?php echo get_post_meta( $post->ID, 'ocr_parsed_header_data', true ); ?></textarea>

                <span class="ocr_help">
                    <?php _e( 'Parsed header data appears here. Edit as needed and click on the update button below to save.', 'woocommerce' ); ?>
                </span>

                <button id="ocr_parsed_header_data_update" class="button button-primary">
                    <?php _e( 'Update Header Data', 'woocommerce' ); ?>
                </button>

            </div>

            <!-- parsed main data -->        
            <div class="ocr_parsed_main_data_cont">

                <label for="ocr_parsed_main_data"><?php _e( 'Parsed Chart Main Data', 'woocommerce' ); ?></label>

                <textarea id="ocr_parsed_main_data" name="ocr_parsed_main_data" rows="5" cols="100"><?php echo get_post_meta( $post->ID, 'ocr_parsed_main_data', true ); ?></textarea>

                <span class="ocr_help">
                    <?php _e( 'Parsed main chart data appears here. Edit as needed and click on the update button below to save.', 'woocommerce' ); ?>
                </span>

                <button id="ocr_parsed_main_data_update" class="button button-primary">
                    <?php _e( 'Update Main Data', 'woocommerce' ); ?>
                </button>

            </div>

        </div>
    </div>
    <?php
}

/**
 * Render ocr_editable_size_chart
 */
function ocr_editable_size_chart($post) {

    echo 'ocr editable size chart here';
}

/**
 * Save ocr_chart post meta
 */
function ocr_save_post_meta($post_id) {

    // ****************
    // SECURITY CHECKS
    // ****************
    // nonce check
    $nonce        = isset( $_POST[ 'ocr_nonce' ] ) ? $_POST[ 'ocr_nonce' ] : '';
    $nonce_action = 'ocr_check_nonce';
    if ( !wp_verify_nonce( $nonce, $nonce_action ) ):
        return;
    endif;

    // Check if user has permissions to save data.
    if ( !current_user_can( 'edit_post', $post_id ) ):
        return;
    endif;

    // Check if not an autosave.
    if ( wp_is_post_autosave( $post_id ) ) :
        return;
    endif;

    // Check if not a revision.
    if ( wp_is_post_revision( $post_id ) ) :
        return;
    endif;

    // check for correct post type
    if ( get_post_type( $post_id ) !== 'ocr_chart' ):
        return;
    endif;

    // **********
    // SAVE DATA
    // **********
    $product_sku        = isset( $_POST[ 'ocr_product_sku' ] ) ? $_POST[ 'ocr_product_sku' ] : '';
    $header_img         = isset( $_POST[ 'ocr_chart_header_image' ] ) ? $_POST[ 'ocr_chart_header_image' ] : '';
    $main_img           = isset( $_POST[ 'ocr_chart_main_image' ] ) ? $_POST[ 'ocr_chart_main_image' ] : '';
    $parsed_header_data = isset( $_POST[ 'ocr_parsed_header_data' ] ) ? $_POST[ 'ocr_parsed_header_data' ] : '';
    $parsed_main_data   = isset( $_POST[ 'ocr_parsed_main_data' ] ) ? $_POST[ 'ocr_parsed_main_data' ] : '';
    
    update_post_meta($post_id, 'ocr_product_sku', $product_sku);
    update_post_meta($post_id, 'ocr_chart_header_image', $header_img);
    update_post_meta($post_id, 'ocr_chart_main_image', $main_img);
    update_post_meta($post_id, 'ocr_parsed_header_data', $parsed_header_data);
    update_post_meta($post_id, 'ocr_parsed_main_data', $parsed_main_data);
}

add_action( 'save_post', 'ocr_save_post_meta' );

