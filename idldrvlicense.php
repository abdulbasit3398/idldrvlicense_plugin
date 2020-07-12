<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tahir.codes/
 * @since             1.0.0
 * @package           Idldrvlicense
 *
 * @wordpress-plugin
 * Plugin Name:       Driving License
 * Plugin URI:        https://basit.codes/
 * Description:       This plugin is to create a form for drving license booking.
 * Version:           1.0.0
 * Author:            Abdul Basit
 * Author URI:        https://basit.codes/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       idldrvlicense
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
define( 'IDLDRVLICENSE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-idldrvlicense-activator.php
 */
function activate_idldrvlicense() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-idldrvlicense-activator.php';
	Idldrvlicense_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-idldrvlicense-deactivator.php
 */
function deactivate_idldrvlicense() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-idldrvlicense-deactivator.php';
	Idldrvlicense_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_idldrvlicense' );
register_deactivation_hook( __FILE__, 'deactivate_idldrvlicense' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-idldrvlicense.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_idldrvlicense() {

	$plugin = new Idldrvlicense();
	$plugin->run();

}
run_idldrvlicense();
