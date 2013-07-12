jQuery( document ).ready( function( $ ) {
	$( document ).keydown( function( e ) {
		var url = false;
		if ( e.which == 37 ) {  // Left arrow key code
			url = $( '.previous a' ).attr( 'href' );
		}
		else if ( e.which == 39 ) {  // Right arrow key code
			url = $( '.next a' ).attr( 'href' );
		}
		else if ( e.which == 40 ) {  // Down arrow key code
			if ( e.altKey ) { // Alt modifier key
				url = $( '.random-images a' ).attr( 'href' );
			}
		}
		else if ( e.which == 38 ) {  // Up arrow key code
			if ( e.altKey ) { // Alt modifier key
				url = $( 'a.post-parent' ).attr( 'href' );
			}
		}
		if ( url && ( !$( 'textarea, input' ).is( ':focus' ) ) ) {
			window.location = url;
		}
		// Find key codes at http://www.scripttheweb.com/js/ref/javascript-key-codes/
	} );
} );
