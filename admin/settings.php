<?php
/**
 * Shealth Settings
 *
 * @author Tareq Hasan
 */
if ( ! class_exists('Shealth_Admin_Settings' ) ):

	class Shealth_Admin_Settings {

		/**
		 * @var Shealth_Settings_API
		 */
		private $shealth_settings;

		/**
		 * Shealth_Settings constructor.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function __construct() {
			$this->shealth_settings = new Shealth_Settings_API;

			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		/**
		 * Initialize Admin.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_init() {

			// Set the settings.
			$this->shealth_settings->set_sections( $this->get_settings_sections() );
			$this->shealth_settings->set_fields( $this->get_settings_fields() );

			// Initialize settings.
			$this->shealth_settings->admin_init();
		}

		/**
		 * Define Admin Menus.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_menu() {
			add_menu_page(
				__( 'Shealth', 'shealth' ),
				__( 'Shealth', 'shealth' ),
				'manage_options',
				'shealth-admin-settings',
				array( $this, 'admin_settings_page') );
		}

		/**
		 * Define Sections for Admin Settings.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return array
		 */
		public function get_settings_sections() {
			$sections = array(
				array(
					'id'    => 'shealth_general',
					'title' => __( 'General', 'shealth' )
				),
				array(
					'id'    => 'shealth_advanced',
					'title' => __( 'Advanced', 'shealth' )
				)
			);
			return $sections;
		}

		/**
		 * Define Form Fields for Admin Settings.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return array Admin Form Fields
		 */
		public function get_settings_fields() {
			$settings_fields = array(
				'shealth_general' => array(
					array(
						'name'              => 'text_val',
						'label'             => __( 'Text Input', 'shealth' ),
						'desc'              => __( 'Text input description', 'shealth' ),
						'placeholder'       => __( 'Text Input placeholder', 'shealth' ),
						'type'              => 'text',
						'default'           => 'Title',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name'              => 'number_input',
						'label'             => __( 'Number Input', 'shealth' ),
						'desc'              => __( 'Number field with validation callback `floatval`', 'shealth' ),
						'placeholder'       => __( '1.99', 'shealth' ),
						'min'               => 0,
						'max'               => 100,
						'step'              => '0.01',
						'type'              => 'number',
						'default'           => 'Title',
						'sanitize_callback' => 'floatval'
					),
					array(
						'name'        => 'textarea',
						'label'       => __( 'Textarea Input', 'shealth' ),
						'desc'        => __( 'Textarea description', 'shealth' ),
						'placeholder' => __( 'Textarea placeholder', 'shealth' ),
						'type'        => 'textarea'
					),
					array(
						'name'        => 'html',
						'desc'        => __( 'HTML area description. You can use any <strong>bold</strong> or other HTML elements.', 'shealth' ),
						'type'        => 'html'
					),
					array(
						'name'  => 'checkbox',
						'label' => __( 'Checkbox', 'shealth' ),
						'desc'  => __( 'Checkbox Label', 'shealth' ),
						'type'  => 'checkbox'
					),
					array(
						'name'    => 'radio',
						'label'   => __( 'Radio Button', 'shealth' ),
						'desc'    => __( 'A radio button', 'shealth' ),
						'type'    => 'radio',
						'options' => array(
							'yes' => 'Yes',
							'no'  => 'No'
						)
					),
					array(
						'name'    => 'selectbox',
						'label'   => __( 'A Dropdown', 'shealth' ),
						'desc'    => __( 'Dropdown description', 'shealth' ),
						'type'    => 'select',
						'default' => 'no',
						'options' => array(
							'yes' => 'Yes',
							'no'  => 'No'
						)
					),
					array(
						'name'    => 'password',
						'label'   => __( 'Password', 'shealth' ),
						'desc'    => __( 'Password description', 'shealth' ),
						'type'    => 'password',
						'default' => ''
					),
					array(
						'name'    => 'file',
						'label'   => __( 'File', 'shealth' ),
						'desc'    => __( 'File description', 'shealth' ),
						'type'    => 'file',
						'default' => '',
						'options' => array(
							'button_label' => 'Choose Image'
						)
					)
				),
				'shealth_advanced' => array(
					array(
						'name'    => 'color',
						'label'   => __( 'Color', 'shealth' ),
						'desc'    => __( 'Color description', 'shealth' ),
						'type'    => 'color',
						'default' => ''
					),
					array(
						'name'    => 'password',
						'label'   => __( 'Password', 'shealth' ),
						'desc'    => __( 'Password description', 'shealth' ),
						'type'    => 'password',
						'default' => ''
					),
					array(
						'name'    => 'wysiwyg',
						'label'   => __( 'Advanced Editor', 'shealth' ),
						'desc'    => __( 'WP_Editor description', 'shealth' ),
						'type'    => 'wysiwyg',
						'default' => ''
					),
					array(
						'name'    => 'multicheck',
						'label'   => __( 'Multile checkbox', 'shealth' ),
						'desc'    => __( 'Multi checkbox description', 'shealth' ),
						'type'    => 'multicheck',
						'default' => array('one' => 'one', 'four' => 'four'),
						'options' => array(
							'one'   => 'One',
							'two'   => 'Two',
							'three' => 'Three',
							'four'  => 'Four'
						)
					),
				)
			);

			return $settings_fields;
		}

		/**
		 * Define HTML markup for Admin Settings Page.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_settings_page() {
			echo '<div class="wrap">';
			echo '<h2>' . __( 'Shealth Settings', 'shealth' ) . '</h2>';

			$this->shealth_settings->show_navigation();
			$this->shealth_settings->show_forms();

			echo '</div>';
		}

		/**
		 * Get all the pages.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return array page names with key value pairs
		 */
		public function get_pages() {
			$pages = get_pages();
			$pages_options = array();
			if ( $pages ) {
				foreach ($pages as $page) {
					$pages_options[$page->ID] = $page->post_title;
				}
			}

			return $pages_options;
		}

	}
endif;