<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Shealth_Domain_Checker
 *
 * @since 1.0.0
 */
class Shealth_Domain_Checker {

	/**
	 * Shealth_Domain_Checker constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Shealth Shortcode.
		add_shortcode( 'shealth', array( $this, 'domain_checker_shortcode') );
	}

	/**
	 * ShortCode - Domain Checker
	 *
	 * @param array $atts Array of ShortCode Variables.
	 *
	 * @since 1.0.0
	 */
	public function domain_checker_shortcode( $atts ) {

		// Define ShortCode Variables.
		$atts = shortcode_atts(
			array(
				'title' => __( 'Find Your Name', 'shealth' ),
			), $atts, 'shealth' );

		$shealth_style = 'shealth-style-1';

		$html = '';
		$html .= '<div class="shealth-shortcode-wrap ' . $shealth_style . '">';
		$html .= '<h2 class="shealth-title">' . esc_html__( $atts['title'], 'shealth' ) . '</h2>';
		$html .= '<input class="shealth-domain-name" type="text" name="domain-name" placeholder="Domain Name" />';
		$html .= '<input class="shealth-submit" type="button" name="submit" value="' . __( 'Check Availability', 'shealth' ) . '" />';
		$html .= '<span class="shealth-spinner"></span>';
		$html .= '<div class="shealth-results">';
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}
}
