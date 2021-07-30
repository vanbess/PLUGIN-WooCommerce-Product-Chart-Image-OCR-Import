jQuery( document ).ready( function ( $ ) {

    // *************************
    // save chart data on click
    // *************************
    $( 'button#ocr-chart-data-save' ).on( 'click', function ( e ) {

        e.preventDefault();

        // ajax data object
        var save_data = {
            'action': 'ocr_save_parsed_data',
            '_ajax_nonce': ocr_save_parsed.nonce,
            'title_data': [ ],
            'body_data': [ ],
            'product_sku': $( 'input#ocr_product_sku' ).val(),
            'ocr_post_id': $( 'input#post_ID' ).val()
        };

        // retrieve table head data
        $( '.ocr-chart-head th' ).each( function ( ) {

            var title_arr = { };

            title_arr.class = $( this ).attr( 'class' ) ? $( this ).attr( 'class' ) : '';
            title_arr.colspan = '';
            title_arr.value = $( this ).text();

            save_data.title_data.push( title_arr );

        } );

        // retrieve table body data
        $( '.ocr-chart-main-data' ).each( function ( ) {

            var body_data_arr = [ ];

            $( 'td', $( this ) ).each( function () {

                var data_arr = { };

                data_arr.class = $( this ).attr( 'class' ) ? $( this ).attr( 'class' ) : '';
                data_arr.colspan = '';
                data_arr.value = $( this ).text();

                body_data_arr.push( data_arr );

            } );

            save_data.body_data.push( body_data_arr );

        } );

        // send ajax request to save chart data to product
        $.post( ocr_save_parsed.ajax_url, save_data, function ( response ) {

            // chart header data message
            var h_message = response.data.header_saved === false ? 'Header data not updated (current already data exists) \n' : 'Chart body data updated \n';

            // chart body data message
            var b_message = response.data.body_saved === false ? 'Body data not updated (current already data exists) \n' : 'Chart body data updated \n';

            // chart data message
            var c_message = response.data.chart_saved === false ? 'Chart not updated (current chart data already exists) \n' : 'Chart updated \n';
            
            // ocr post message
            var ocr_message = response.data.ocr_chart_saved === false ? 'OCR post chart not updated (current chart data already exists) \n' : 'OCR post chart updated \n';

            // combined message
            var msg = h_message + b_message + c_message + ocr_message;

            // display alert
            alert( msg );

            // update post by triggering publish button
            $( 'input#publish' ).trigger( 'click' );

        } );

    } );
} );


