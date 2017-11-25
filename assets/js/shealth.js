jQuery( document ).ready( function( $ ) {

	$( 'body' ).on( 'click', '.shealth-submit', function( e ) {
		var $wrap           = $(this).parent('.shealth-shortcode-wrap');
		var domainName      = $wrap.find( '.shealth-domain-name' ).val();

		if( ! domainName ) {
			$wrap.find( '.shealth-domain-name' ).css( 'border', '1px solid red' );
			return false;
		}

		var data = {
			'action'         : 'shealth_check_domain',
			'security'       : ShealthVars.ajaxSecurity,
			'domainName'     : domainName,
		};

		$wrap.find( '.shealth-spinner' ).show();
		$.post( ShealthVars.ajaxUrl , data, function( response ) {
			$wrap.find( '.shealth-spinner' ).hide();
			$wrap.find( '.shealth-results' ).html( response ).slideDown( 'slow' );
		});

	});

});