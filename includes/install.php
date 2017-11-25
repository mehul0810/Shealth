<?php
/**
 * Install Function
 *
 * @package     Shealth
 * @subpackage  Functions/Install
 * @copyright   Copyright (c) 2017, Mehul Gohil
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Install Shealth Plugin
 *
 * @param bool $network_wide Check Status whether site is single site or multisite.
 *
 * @since 1.0.0
 *
 * @return void
 */
function shealth_install( $network_wide = false ) {

	global $wpdb;

	if ( is_multisite() && $network_wide ) {

		foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs LIMIT 100" ) as $blog_id ) {

			switch_to_blog( $blog_id );
			shealth_process_installation();
			restore_current_blog();

		}

	} else {

		shealth_process_installation();

	}

}

/**
 * Execute Process for Shealth Installation.
 *
 * @since  1.0.0
 *
 * @return void
 */
function shealth_process_installation() {

	// Create required tables.
	shealth_create_required_tables();

	$shealth_options = shealth_get_settings();

	// Clear the permalinks.
	flush_rewrite_rules( false );

	// Add Upgraded From Option.
	$current_version = get_option( 'shealth_version' );
	if ( $current_version ) {
		update_option( 'shealth_version_upgraded_from', $current_version );
	}

	// Setup some default options.
	$options = array();

	//Fresh Install? Setup Basic Settings.
	if ( empty( $current_version ) ) {
		$options = array_merge( $options, shealth_get_default_settings() );
	}

	// Populate the default values.
	update_option( 'shealth_settings', array_merge( $shealth_options, $options ) );

	/**
	 * Run plugin upgrades.
	 *
	 * @since 1.0.0
	 */
	do_action( 'shealth_upgrades' );

	if ( SHEALTH_VERSION !== get_option( 'shealth_version' ) ) {
		update_option( 'shealth_version', SHEALTH_VERSION );
	}

	// Bail if activating from network, or bulk.
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}

}

/**
 * Network Activated New Site Setup.
 *
 * When a new site is created and Shealth is network activated this function runs the appropriate install function to set up.
 *
 * @param int    $blog_id The Blog ID created.
 * @param int    $user_id The User ID set as the admin.
 * @param string $domain  The URL.
 * @param string $path    Site Path.
 * @param int    $site_id The Site ID.
 * @param array  $meta    Blog Meta.
 *
 * @since 1.0.0
 */
function shealth_on_create_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

	if ( is_plugin_active_for_network( GIVE_PLUGIN_BASENAME ) ) {

		switch_to_blog( $blog_id );
		shealth_install();
		restore_current_blog();

	}

}

add_action( 'wpmu_new_blog', 'shealth_on_create_blog', 10, 6 );

/**
 * Create Required Tables.
 *
 * @since 1.0.0
 *
 * @return void
 */
function shealth_create_required_tables() {

	// Bail Out, if not is admin.
//	if ( ! is_admin() ) {
//		return;
//	}
//
//	global $wpdb;
//
//	$charset_collate = $wpdb->get_charset_collate();
//
//	$sql = "CREATE TABLE $table_name (
//  id mediumint(9) NOT NULL AUTO_INCREMENT,
//  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
//  name tinytext NOT NULL,
//  text text NOT NULL,
//  url varchar(55) DEFAULT '' NOT NULL,
//  PRIMARY KEY  (id)
//) $charset_collate;";
//
//	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//	dbDelta( $sql );

}
