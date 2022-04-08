<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    Simple_File_Manager
 * @subpackage Simple_File_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_File_Manager
 * @subpackage Simple_File_Manager/admin
 * @author     Bowo <hello@bowo.io>
 */
class Simple_File_Manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_File_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_File_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-file-manager-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_File_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_File_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-file-manager-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add file manager page in wp-admin
	 *
	 * @since 1.0.0
	 */
	public function sfm_main_page() {

		if ( class_exists( 'CSF' ) ) {

			// Set a unique slug-like ID

			$prefix = 'simple-file-manager';

			CSF::createOptions ( $prefix, array(

				'menu_title' 		=> 'File Manager',
				'menu_slug' 		=> 'simple-file-manager',
				'menu_type'			=> 'submenu',
				'menu_parent'		=> 'tools.php',
				'menu_position'		=> 1,
				// 'menu_icon'			=> 'dashicons-arrow-up-alt2',
				'framework_title' 	=> 'Simple File Manager <small>by <a href="https://bowo.io" target="_blank">bowo.io</a></small>',
				'framework_class' 	=> 'sfm-options',
				'show_bar_menu' 	=> false,
				'show_search' 		=> false,
				'show_reset_all' 	=> false,
				'show_reset_section' => false,
				'show_form_warning' => false,
				'sticky_header'		=> false,
				'save_defaults'		=> true,
				'show_footer' 		=> false,
				'footer_credit'		=> '<a href="https://wordpress.org/plugins/simple-file-manager/" target="_blank">Simple File Manager</a> (<a href="https://github.com/qriouslad/simple-file-manager" target="_blank">github</a>) is built with the <a href="https://github.com/devinvinson/WordPress-Plugin-Boilerplate/" target="_blank">WordPress Plugin Boilerplate</a>, <a href="https://wppb.me" target="_blank">wppb.me</a> and <a href="https://github.com/Codestar/codestar-framework" target="_blank">CodeStar</a>.',

			) );

			CSF::createSection( $prefix, array(

				'title'		=> 'The File Manager',
				'fields'	=> array(

					array(
						'type'	=> 'content',
						'title'	=> 'The File Manager',
						'content'	=> 'Will go here...',
						// 'content'	=> $this->sfm_index(),
					),

				),

			) );

		}

	}

	/**
	 * Add "Access Now" plugin action link
	 *
	 * @since 1.0.0
	 */
	public function sfm_plugin_action_links( $links ) {

		$action_link = '<a href="tools.php?page=' . $this->plugin_name . '">Access Now</a>';

		array_unshift( $links, $action_link );

		return $links;

	}

	/**
	 * Register a submenu directly with WP core function
	 *
	 * @since 1.0.0
	 */
	public function sfm_register_submenu() {

		add_submenu_page(
			'tools.php',
			'File Manager',
			'File Manager',
			'manage_options',
			'simple-file-manager',
			'sfm_register_submenu_callback'
		);
	}

	/**
	 * Skeleton callback function for submenu registration
	 *
	 * @since 1.0.0
	 */
	public function sfm_register_submenu_callback() {

		echo 'Nothing to show here...';

	}

	/**
	 * Remove CodeStar framework welcome / ads page
	 *
	 * @since 1.0.0
	 */
	public function sfm_remove_codestar_submenu() {

		remove_submenu_page( 'tools.php', 'csf-welcome' );

	}

}
