<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Scripts.
 *
 * @since 1.0.0
 */
function shealth_register_scripts() {

	// Use minified libraries if SCRIPT_DEBUG is turned off.
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// Localize AJAX vars.
	$localize_shealth_vars = apply_filters( 'shealth_global_script_vars', array(
		'ajaxUrl'        => shealth_get_ajax_url(),
		'ajaxSecurity'   => wp_create_nonce( 'shealth_ajax_nounce' ),
	) );

	wp_enqueue_script( 'shealth', SHEALTH_PLUGIN_URL . '/assets/js/shealth' . $suffix . '.js', '', SHEALTH_VERSION );
	wp_localize_script( 'shealth', 'ShealthVars', $localize_shealth_vars );
}

add_action( 'wp_enqueue_scripts', 'shealth_register_scripts' );

/**
 * Register Styles.
 *
 * @since 1.0.0
 */
function shealth_register_styles() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'shealth', SHEALTH_PLUGIN_URL . '/assets/css/shealth.min.css', array(), SHEALTH_VERSION, 'all' );
}

add_action( 'wp_enqueue_scripts', 'shealth_register_styles' );