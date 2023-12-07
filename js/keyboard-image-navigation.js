jQuery( document ).ready( function( $ ) {
	$( document ).keydown( function( e ) {
		var url = false;
		if ( e.which == 37 ) {  // 37 left arrow
			url = $( '.previous a' ).attr( 'href' );
		}
		else if ( e.which == 39 ) {  // 39 right arrow
			url = $( '.next a' ).attr( 'href' );
		}
		else if ( e.which == 75 ) {  // 75 k
			url = $( '.previous a' ).attr( 'href' );
		}
		else if ( e.which == 74 ) {  // 74 j
			url = $( '.next a' ).attr( 'href' );
		}
		else if ( e.which == 69 ) {  // 69 e
			if (document.getElementById('wp-admin-bar-edit') != null) {
				if ( e.metaKey ) { // command modifier key
					window.location.assign(document.getElementById('wp-admin-bar-edit').firstChild.href);
				}
			} 
		}
		else if ( e.which == 72 ) {  // 72 h
				url = '/';
		}
		else if ( e.which == 82 ) {  // 82 r
			if ( e.altKey ) { // alt modifier key
					url = $( 'a#rollthedice' ).attr( 'href' );
			}
		}
		else if ( e.which == 80 ) {  // 80 p
			if ( e.altKey ) { // alt modifier key
				if ( e.ctrlKey ) { // control modifier key
					url = $( 'a.post-parent' ).attr( 'href' );
				}
			}
		}
		else if ( e.which == 76 ) {  // 76 l
			if ( e.shiftKey ) { // shift modifier key
				if ( e.ctrlKey ) { // control modifier key
					window.location = keyboard_navigation_args.home_url + '/wp-login.php?redirect_to='+document.URL;
				}
			}
		}
		if ( url && ( !$( 'textarea, input' ).is( ':focus' ) ) ) {
			window.location = url;
		}
		// Find keycodes at https://gcctech.org/csc/javascript/javascript_keycodes.htm
		// Keycode checker https://gcctech.org/csc/javascript/keycodeExample.html
	} );
} );

