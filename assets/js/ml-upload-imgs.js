jQuery( document ).ready( function ( $ ) {

    // ********************
    // upload header image
    // ********************
    $( 'a#ocr_add_header_image' ).click( function ( e ) {

        e.preventDefault();

        // get target input id
        var target_input = $( this ).attr( 'data-target' );

        // call media library
        var upload = wp.media( {
            title: 'Choose Image', //Title for Media Box
            multiple: false //For limiting multiple image
        } ).on( 'select', function () {
            var select = upload.state().get( 'selection' );
            var attach = select.first().toJSON();
            $( '.ocr_header_img_cont' ).show();
            $( target_input ).attr( 'src', attach.url );
            $( '#ocr_chart_header_image_input' ).val( attach.url );
            $( '.ocr_upload_header_img_cont' ).hide();
        } ).open();
    } );

    // ******************
    // upload main image
    // ******************
    $( 'a#ocr_add_main_image' ).click( function ( e ) {

        e.preventDefault();

        // get target input id
        var target_input = $( this ).attr( 'data-target' );

        // call media library
        var upload = wp.media( {
            title: 'Choose Image', //Title for Media Box
            multiple: false //For limiting multiple image
        } ).on( 'select', function () {
            var select = upload.state().get( 'selection' );
            var attach = select.first().toJSON();
            $( '.ocr_main_img_cont' ).show();
            $( target_input ).attr( 'src', attach.url );
            $( '#ocr_chart_main_image_input' ).val( attach.url );
            $( '.ocr_upload_main_img_cont' ).hide();
        } ).open();
    } );

    // ********************
    // remove header image
    // ********************
    $( 'a#ocr_remove_header_img' ).on( 'click', function () {
        $( '.ocr_header_img_cont' ).hide();
        $( '#ocr_chart_header_image' ).attr( 'src', '' );
        $( '#ocr_chart_header_image_input' ).val( '' );
        $( '.ocr_upload_header_img_cont' ).show();
    } );

    // ********************
    // remove main image
    // ********************
    $( 'a#ocr_remove_main_img' ).on( 'click', function () {
        $( '.ocr_main_img_cont' ).hide();
        $( '#ocr_chart_main_image' ).attr( 'src', '' );
        $( '#ocr_chart_main_image_input' ).val( '' );
        $( '.ocr_upload_main_img_cont' ).show();
    } );

} );