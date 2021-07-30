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
    $chart_original_img = get_post_meta( $post->ID, 'ocr_chart_original_image', true );
    $chart_header_img   = get_post_meta( $post->ID, 'ocr_chart_header_image', true );
    $chart_main_img     = get_post_meta( $post->ID, 'ocr_chart_main_image', true );

    // css
    wp_enqueue_style( 'ocr-cpt-css' );

    // media library js
    wp_enqueue_script( 'ocr-media-library' );

    // ajax scripts
    wp_enqueue_script( 'ocr-process-parsed' );
    wp_enqueue_script( 'ocr-save-parsed' );

    // ocr/tesseract
    wp_enqueue_script( 'ocr-tesseract' );
    wp_enqueue_script( 'ocr-process' );

    // chart edits/highlights
    wp_enqueue_script( 'ocr-chart' );

    // create nonce for saving post data
    wp_nonce_field( 'ocr_check_nonce', 'ocr_nonce' );
    ?>

    <!-- ****************************** -->
    <!-- original chart image data cont -->
    <!-- ****************************** -->
    <div class="ocr_chart_original_image_data_cont">

        <!-- product sku -->
        <div class="ocr_product_sku">
            <label for="ocr_product_sku"><?php _e( 'Product SKU', 'woocommerce' ); ?></label>
            <input type="text" name="ocr_product_sku" id="ocr_product_sku" value="<?php echo get_post_meta( $post->ID, 'ocr_product_sku', true ); ?>">
        </div>

        <!-- original chart image -->
        <div class="ocr_original_chart_img_cont">

            <label for="ocr_chart_original_image"><?php _e( 'Original Chart Image Link', 'woocommerce' ); ?></label>

            <!-- original link input -->
            <input type="url" id="ocr_chart_original_image" name="ocr_chart_original_image" value="<?php echo $chart_original_img; ?>" data-error="<?php _e( 'please provide a valid image URL', 'woocommerce' ); ?>">

            <!-- original image actual -->
            <?php if ( !empty( $chart_original_img ) ): ?>
                <img id="ocr_chart_original_image" src="<?php echo $chart_original_img; ?>" alt="<?php echo $post->post_title; ?>"/>
            <?php else: ?>
                <img id="ocr_chart_original_image" src="<?php echo $chart_original_img; ?>" alt="<?php echo $post->post_title; ?>" style="display: none;"/>
            <?php endif; ?>

            <!-- retrieve original image -->
            <button id="ocr_retrieve_original_image" class="button button-primary">
                <?php _e( 'Retrieve Original Chart Image', 'woocommerce' ); ?>
            </button>

        </div><!-- .ocr_original_chart_img_cont -->

    </div><!-- .ocr_chart_original_image_data_cont -->

    <!-- *************************************** -->
    <!-- cropped images and parsed ocr data cont -->
    <!-- *************************************** -->
    <div class="ocr_chart_images_parsed_data_cont">

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
                <button id="ocr_parse_header_image" class="button button-primary" data-processing="<?php _e( 'Processing...', 'woocommerce' ); ?>">
                    <?php _e( 'Parse Chart Header Image', 'woocommerce' ); ?>
                </button>

            </div>

            <!-- add chart header image -->
            <div class="ocr_upload_header_img_cont" style="<?php $chart_header_img ? print 'display: none;' : print 'display: block;' ?>">
                <label for="ocr_add_header_image"><?php _e( 'Upload Chart Header Image', 'woocommerce' ); ?></label>               
                <a href="#" id="ocr_add_header_image" class="ocr_add_image" data-target="#ocr_chart_header_image" title="<?php _e( 'Upload chart header image', 'woocommerce' ); ?>">+</a>
            </div>

        </div>

        <!-- parsed header data -->
        <div class="ocr_parsed_header_data_cont">

            <label for="ocr_parsed_header_data"><?php _e( 'Parsed Chart Header Data', 'woocommerce' ); ?></label>

            <textarea id="ocr_parsed_header_data" name="ocr_parsed_header_data" rows="5" cols="100"><?php echo get_post_meta( $post->ID, 'ocr_parsed_header_data', true ); ?></textarea>

            <span class="ocr_help">
                <?php _e( 'Parsed header data appears here. Edit as needed and update post to save.', 'woocommerce' ); ?>
            </span>

        </div>

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
            <button id="ocr_parse_main_image" class="button button-primary" data-processing="<?php _e( 'Processing...', 'woocommerce' ); ?>">
                <?php _e( 'Parse Chart Main Image', 'woocommerce' ); ?>
            </button>

        </div>

        <!-- add chart main image -->
        <div class="ocr_upload_main_img_cont" style="<?php $chart_main_img ? print 'display: none;' : print 'display: block;' ?>">
            <label for="ocr_add_main_image"><?php _e( 'Upload Chart Main Image', 'woocommerce' ); ?></label>              
            <a href="#" id="ocr_add_main_image" class="ocr_add_image" data-target="#ocr_chart_main_image" title="<?php _e( 'Upload chart main image', 'woocommerce' ); ?>">+</a>
        </div>

        <!-- parsed main data -->        
        <div class="ocr_parsed_main_data_cont">

            <label for="ocr_parsed_main_data"><?php _e( 'Parsed Chart Main Data', 'woocommerce' ); ?></label>

            <textarea id="ocr_parsed_main_data" name="ocr_parsed_main_data" rows="5" cols="100"><?php echo get_post_meta( $post->ID, 'ocr_parsed_main_data', true ); ?></textarea>

            <span class="ocr_help">
                <?php _e( 'Parsed main chart data appears here. Edit as needed and update post to save.', 'woocommerce' ); ?>
            </span>

        </div>
    </div><!-- .ocr_chart_images_parsed_data_cont -->
    <?php
}

/**
 * Render ocr_editable_size_chart
 */
function ocr_editable_size_chart($post) {

    // retrieve saved/parsed ocr chart data
    $parsed_ocr_chart_data = get_post_meta( $post->ID, 'ocr_chart_data', true );
    ?>

    <!-- help text -->
    <span class="ocr_help">
        <?php
        _e(
            '<p><i><b>Once chart OCR data has been parsed it will be displayed in table format below.<br> Edit/check table data for correctness as needed and, once done, save to supplied product SKU for use/display on the product page. <br><br> <u>Toggle table cell highlight/bold text:</u> CTRL + Left Click</b></i></p>',
            'woocommerce'
        );
        ?>
    </span>

    <!-- chart container -->
    <div id="ocr-chart-container" style="<?php $parsed_ocr_chart_data ? print 'border: none;' : ''; ?>">

        <!-- chart table -->
        <table id="ocr-parse-chart" data-product-id="">

            <?php
            if ( $parsed_ocr_chart_data ):

                // unserialize chart data
                $chart_data  = maybe_unserialize( $parsed_ocr_chart_data );
                $arr_counter = 0;

                // chart data loop
                foreach ( $chart_data as $data_arr ):
                    if ( $arr_counter === 0 ):
                        ?>
                        <tr class="ocr-chart-head">
                            <?php foreach ( $data_arr as $h_data ): ?>
                                <th contenteditable="true" class="<?php echo $h_data[ 'class' ] ?>" colspan="<?php echo $h_data[ 'colspan' ]; ?>"><?php echo $h_data[ 'value' ]; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    <?php else: ?>
                        <tr class="ocr-chart-main-data">
                            <?php foreach ( $data_arr as $b_data ): ?>
                                <td contenteditable="true" class="<?php echo $b_data[ 'class' ] ?>" colspan="<?php echo $b_data[ 'colspan' ]; ?>"><?php echo $b_data[ 'value' ]; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php
                    endif;
                    $arr_counter++;
                endforeach;
            endif;
            ?>

        </table>

        <?php if ( $parsed_ocr_chart_data ): ?>
            <!-- save chart data to db -->
            <button id="ocr-chart-data-save" class="button button-primary">
                <?php _e( 'Save Chart Data to Product', 'woocommerce' ); ?>
            </button>
        <?php else: ?>
            <!-- parse ocr data -->
            <a id="ocr_parse_ocr_data_to_array" title="<?php _e( 'Parse OCR data', 'woocommerce' ); ?>">
                <?php _e( 'Click Here to Parse OCR Size Chart Data to Editable Size Chart', 'woocommerce' ); ?>
            </a>
            <!-- save chart data to db -->
            <button id="ocr-chart-data-save" class="button button-primary" style="display: none">
                <?php _e( 'Save Chart Data to Product', 'woocommerce' ); ?>
            </button>
        <?php endif; ?>
    </div>
    <?php
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
    $original_img       = isset( $_POST[ 'ocr_chart_original_image' ] ) ? $_POST[ 'ocr_chart_original_image' ] : '';
    $header_img         = isset( $_POST[ 'ocr_chart_header_image' ] ) ? $_POST[ 'ocr_chart_header_image' ] : '';
    $main_img           = isset( $_POST[ 'ocr_chart_main_image' ] ) ? $_POST[ 'ocr_chart_main_image' ] : '';
    $parsed_header_data = isset( $_POST[ 'ocr_parsed_header_data' ] ) ? $_POST[ 'ocr_parsed_header_data' ] : '';
    $parsed_main_data   = isset( $_POST[ 'ocr_parsed_main_data' ] ) ? $_POST[ 'ocr_parsed_main_data' ] : '';

    update_post_meta( $post_id, 'ocr_product_sku', $product_sku );
    update_post_meta( $post_id, 'ocr_chart_original_image', $original_img );
    update_post_meta( $post_id, 'ocr_chart_header_image', $header_img );
    update_post_meta( $post_id, 'ocr_chart_main_image', $main_img );
    update_post_meta( $post_id, 'ocr_parsed_header_data', $parsed_header_data );
    update_post_meta( $post_id, 'ocr_parsed_main_data', $parsed_main_data );
}

add_action( 'save_post', 'ocr_save_post_meta' );

