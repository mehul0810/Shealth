<?php
/**
 * Plugin Name: Shealth - Domain Checker WordPress Plugin
 * Plugin URI:  https://www.mehulgohil.in/shealth-domain-checker-wordpress-plugin/
 * Version: 1.0.0
 * Description: This plugin will help bloggers to have a domain checker tool in their website to improve domain purchases.
 * Author: Mehul Gohil
 * Author URI: https://www.mehulgohil.in/
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: shealth
 * Domain Path: /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare Shealth Class, if doesnt exists.
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'Shealth' ) ) :

	/**
	 * Main class of Shealth.
	 *
	 * @since 1.0.0
	 */
	final class Shealth {

		/**
		 * Create an Instance
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected static $_instance;

		/**
		 * Domain Checker Variable.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public $domain_checker;

		/**
		 * DB Manager Variable.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public $db_manager;

		/**
		 * Shealth Settings Variable.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public $shealth_settings;

		/**
		 * Main Instance of Shealth.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return Shealth Instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Create a Constructor.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function __construct() {
			// Define Constants.
			$this->define_constants();

			// Include required files.
			$this->includes();

			// Initialize Hooks.
			$this->initialize_hooks();
		}

		/**
		 * Throw error on object clone
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'shealth' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function __wakeup() {
			// Un-serializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'shealth' ), '1.0' );
		}

		/**
		 * Setup plugin constants
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @return void
		 */
		private function define_constants() {

			// Plugin version.
			if ( ! defined( 'SHEALTH_VERSION' ) ) {
				define( 'SHEALTH_VERSION', '1.0.0' );
			}

			// Plugin Folder Path.
			if ( ! defined( 'SHEALTH_PLUGIN_DIR' ) ) {
				define( 'SHEALTH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL.
			if ( ! defined( 'SHEALTH_PLUGIN_URL' ) ) {
				define( 'SHEALTH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File.
			if ( ! defined( 'SHEALTH_PLUGIN_FILE' ) ) {
				define( 'SHEALTH_PLUGIN_FILE', __FILE__ );
			}

		}

		/**
		 * Include required files
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @return void
		 */
		private function includes() {
			// Include required files.
			if( is_admin() ) {
				require_once SHEALTH_PLUGIN_DIR . 'admin/class-settings-api.php';
				require_once SHEALTH_PLUGIN_DIR . 'admin/settings.php';
			}
			require_once SHEALTH_PLUGIN_DIR . 'includes/install.php';
			require_once SHEALTH_PLUGIN_DIR . 'includes/scripts.php';
			require_once SHEALTH_PLUGIN_DIR . 'includes/actions.php';
			require_once SHEALTH_PLUGIN_DIR . 'includes/ajax-functions.php';
			require_once SHEALTH_PLUGIN_DIR . 'includes/misc-functions.php';
			require_once SHEALTH_PLUGIN_DIR . 'includes/shortcode.php';
			require_once SHEALTH_PLUGIN_DIR . 'includes/class-shealth-db.php';
			require_once SHEALTH_PLUGIN_DIR . 'includes/class-shealth-manager.php';
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @return void
		 */
		private function initialize_hooks() {
			//register_activation_hook( __FILE__, 'shealth_install' );
			add_action( 'plugins_loaded', array( $this, 'initialize_core' ), 0 );
		}

		/**
		 * Initialize Core
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function initialize_core() {

			// Set up localization.
			$this->load_textdomain();

			// Initialize Required Assets.
			$this->shealth_settings = new Shealth_Admin_Settings();
			$this->domain_checker   = new Shealth_Domain_Checker();
			$this->db_manager       = new Shealth_DB_Manager();

		}

		/**
		 * Loads the plugin language files.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function load_textdomain() {

			// Set filter for languages directory
			$shealth_lang_dir = dirname( plugin_basename( SHEALTH_PLUGIN_FILE ) ) . '/languages/';
			$shealth_lang_dir = apply_filters( 'shealth_languages_directory', $shealth_lang_dir );

			// Traditional WordPress plugin locale filter.
			$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
			$locale = apply_filters( 'plugin_locale', $locale, 'shealth' );

			unload_textdomain( 'shealth' );
			load_textdomain( 'shealth', WP_LANG_DIR . '/shealth/shealth-' . $locale . '.mo' );
			load_plugin_textdomain( 'shealth', false, $shealth_lang_dir );

		}

	}

endif;


/**
 * Power up Shealth instance.
 *
 * @since  1.0.0
 *
 * @return object
 */
function Shealth() {
	return Shealth::instance();
}

// Call the Shealth function to initialize plugin.
Shealth();