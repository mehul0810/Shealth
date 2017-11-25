<?php
/**
 * Defined Required Actions.
 *
 * @since 1.0.0
 */

function shealth_check_domain_callback() {

	// Check nonce and verify that data received is correct.
	check_ajax_referer( 'shealth_ajax_nounce', 'security' );

	$domain_name      = $_POST['domainName'];
	$domain_keyword   = '';
	$domain_extension = '';

	// Identify current Domain Extension.
	$domain_split = explode( '.', $domain_name );
	if( ! empty( $domain_split[1] ) ) {
		$domain_keyword   = $domain_split[0];
		$domain_extension = $domain_split[1];
	}

	$addon_extensions = array_unique(
		array_merge(
			array( $domain_extension ),
			array( 'com', 'in', 'net' )
		)
	);

	$html = '';
	$html .= '<table class="table">';
	$html .= '<tbody>';
	$html .= '<tr>';
	$html .= '<th>' . __( '#', 'shealth' ) . '</th>';
	$html .= '<th>' . __( 'Domain Name', 'shealth' ) . '</th>';
	$html .= '<th>' . __( 'Availability', 'shealth' ) . '</th>';
	$html .= '<th>' . __( 'Hosting', 'shealth' ) . '</th>';
	$html .= '</tr>';

	foreach ( $addon_extensions as $extension ) {
		$domain = $domain_keyword . '.' . $extension;

		$html .= '<tr>';
		$html .= '<td><input type="checkbox"/></td>';
		$html .= '<td>' . $domain . '</td>';

		// Check whether the domain is booked or available.
		if ( gethostbyname( $domain ) !== $domain ) {
			$html .= '<td><i class="dashicons dashicons-no"></i></td>';
		}
		else {
			$html .= '<td><i class="dashicons dashicons-yes"></i></td>';
		}
		$html .= '<td>';
		$html .= '<a href="https://www.bluehost.com/track/mehulgohil0810/NPWidget?page=/web-hosting/signup&domain=' . $domain . '&cpanel_plan=starter">';
		$html .= __( 'BlueHost', 'shealth' );
		$html .= '</a>';
		$html .= '</td>';
		$html .= '</tr>';
	}

	$html .= '</tbody>';
	$html .= '</table>';
	echo $html;



	die();
}

add_action( 'wp_ajax_shealth_check_domain', 'shealth_check_domain_callback' );
add_action( 'wp_ajax_nopriv_shealth_check_domain', 'shealth_check_domain_callback' );