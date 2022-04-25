<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bowo.io
 * @since             1.0.0
 * @package           Simple_File_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Simple File Manager
 * Plugin URI:        https://wordpress.org/plugins/simple-file-manager/
 * Description:       Lightweight file manager focusing as a code viewer and editor with syntax highlighting.
 * Version:           1.3.1
 * Author:            Bowo
 * Author URI:        https://bowo.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-file-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIMPLE_FILE_MANAGER_VERSION', '1.3.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-file-manager-activator.php
 */
function activate_simple_file_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-file-manager-activator.php';
	Simple_File_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-file-manager-deactivator.php
 */
function deactivate_simple_file_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-file-manager-deactivator.php';
	Simple_File_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_file_manager' );
register_deactivation_hook( __FILE__, 'deactivate_simple_file_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-file-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_file_manager() {

	$plugin = new Simple_File_Manager();
	$plugin->run();

}
run_simple_file_manager();
