jQuery( function ( $ ) {

    // add grey highlight to cell
    $( document ).on( 'click', '.ocr-chart-head th, .ocr-chart-main-data td', function (event) {
        if (event.ctrlKey === true) {
            $( this ).toggleClass( 'highlight' );
        }
    } );

} );