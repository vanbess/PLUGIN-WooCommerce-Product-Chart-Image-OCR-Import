//process images on button click

jQuery( document ).ready( function ( $ ) {

    // process header image
    $( 'button#ocr_parse_header_image' ).on( 'click', function ( e ) {

        e.preventDefault();

        // grab image
        var image = $( '#ocr_chart_header_image' ).attr( 'src' );

        // grab processing and original text
        var processing_t = $( this ).attr( 'data-processing' );
        var original_t = $( this ).text();

        // change button text
        $( this ).text( processing_t );

        Tesseract.recognize(
                image,
                'chi_sim',
                { logger: m => console.log( m ) }
        ).then( ( { data: { text } } ) => {
//            console.log( text );
            $( 'textarea#ocr_parsed_header_data' ).val( text );
            $( this ).text( original_t );
        } )

    } );

    // process main image
    $( 'button#ocr_parse_main_image' ).on( 'click', function ( e ) {

        e.preventDefault();

        // grab image
        var image = $( '#ocr_chart_main_image' ).attr( 'src' );

        // grab processing and original text
        var processing_t = $( this ).attr( 'data-processing' );
        var original_t = $( this ).text();

        // change button text
        $( this ).text( processing_t );

        Tesseract.recognize(
                image,
                'eng',
                { logger: m => console.log( m ) }
        ).then( ( { data: { text } } ) => {
//            console.log( text );
            $( 'textarea#ocr_parsed_main_data' ).val( text );
            $( this ).text( original_t );
        } )

    } );

} );


