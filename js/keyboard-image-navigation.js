jQuery( document ).ready( function( $ ) {
	$( document ).keydown( function( e ) {
		var url = false;
		if ( e.which == 37 ) {  // Left arrow key code
			url = $( '.previous a' ).attr( 'href' );
		}
		else if ( e.which == 39 ) {  // Right arrow key code
			url = $( '.next a' ).attr( 'href' );
		}
		else if ( e.which == 192 ) {  // Backslash key code
			url = $( '.first-random-image' ).attr( 'href' );
		}
		else if ( e.which == 191 ) {  // Forward slash key code
			url = $( '.post-parent' ).attr( 'href' );
		}
		if ( url && ( !$( 'textarea, input' ).is( ':focus' ) ) ) {
			window.location = url;
		}
		// Find key codes at http://www.scripttheweb.com/js/ref/javascript-key-codes/
	} );
} );
