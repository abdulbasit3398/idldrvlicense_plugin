<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://tahir.codes/
 * @since      1.0.0
 *
 * @package    Idldrvlicense
 * @subpackage Idldrvlicense/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Idldrvlicense
 * @subpackage Idldrvlicense/includes
 * @author     Tahir Iqbal <tahiriqbal09@gmail.com>
 */
class Idldrvlicense_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'idldrvlicense',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
