jQuery( document ).ready( function ( $ ) {

    // *************************************
    // parse OCR data to PHP array via ajax
    // *************************************
    $( '#ocr_parse_ocr_data_to_array' ).on( 'click', function ( e ) {

        e.preventDefault();
        
        // grab header data
        var header_data = $( '#ocr_parsed_header_data' ).val();

        // grab main data
        var main_data = $( '#ocr_parsed_main_data' ).val();

        var data = {
            '_ajax_nonce': ocr_process_parsed.nonce,
            'action': 'ocr_process_parsed_data',
            'header_data': header_data,
            'main_data': main_data
        }

        $.post( ocr_process_parsed.ajax_url, data, function ( response ) {
            
            $( 'a#ocr_parse_ocr_data_to_array' ).hide();
            $( '#ocr-chart-data-save' ).show();
            $( '#ocr-chart-container' ).css( 'border', 'none' );

            // retrieve parsed data
            var thead_data = response.title;
            var tbody_data = response.body;

            // header data
            if ( thead_data ) {
                // insert row for table header data
                $( '#ocr-parse-chart' ).prepend( '<tr class="ocr-chart-head"></tr>' );
                // append header data to row
                $( thead_data ).each( function ( index, element ) {
                    $( '.ocr-chart-head' ).append( '<th contenteditable="true">' + element + '</td>' );
                } );
            }

            // body data
            if ( tbody_data ) {
                $( tbody_data ).each( function ( index, element ) {

                    var line_data = element;
                    var target_index = index;

                    $( '#ocr-parse-chart' ).append( '<tr class="ocr-chart-main-data" id="ocr-chart-main-data-' + target_index + '"></tr>' );

                    $( line_data ).each( function ( index, element ) {
                        $( '#ocr-chart-main-data-' + target_index ).append( '<td contenteditable="true">' + element + '</td>' )
                    } );

                } );
            }
        } );
    } );
} );