<?php
/**
 * Get the current page URL.
 *
 * @since 1.0.0
 *
 * @return string $current_url Current page URL.
 */
function shealth_get_current_page_url() {

	global $wp;

	if ( get_option( 'permalink_structure' ) ) {
		$base = trailingslashit( home_url( $wp->request ) );
	} else {
		$base = add_query_arg( $wp->query_string, '', trailingslashit( home_url( $wp->request ) ) );
		$base = remove_query_arg( array( 'post_type', 'name' ), $base );
	}

	$scheme      = is_ssl() ? 'https' : 'http';
	$current_uri = set_url_scheme( $base, $scheme );

	if ( is_front_page() ) {
		$current_uri = home_url( '/' );
	}

	return apply_filters( 'shealth_get_current_page_url', $current_uri );

}
