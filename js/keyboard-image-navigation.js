jQuery( document ).ready( function( $ ) {
	$( document ).keydown( function( e ) {
		var url = false;
		if ( e.which == 37 ) {  // Left arrow key code
			url = $( '.previous a' ).attr( 'href' );
		}
		else if ( e.which == 39 ) {  // Right arrow key code
			url = $( '.next a' ).attr( 'href' );
		}
		else if ( e.which == 18 ) {  // alt key code
			url = $( '.first-random-image' ).attr( 'href' );
		}
		else if ( e.which == 191 ) {  // Forward slash key code
			url = $( '.post-parent' ).attr( 'href' );
		}
		if ( url && ( !$( 'textarea, input' ).is( ':focus' ) ) ) {
			window.location = url;
		}
	} );
} );