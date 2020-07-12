<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://tahir.codes/
 * @since      1.0.0
 *
 * @package    Idldrvlicense
 * @subpackage Idldrvlicense/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Idldrvlicense
 * @subpackage Idldrvlicense/includes
 * @author     Tahir Iqbal <tahiriqbal09@gmail.com>
 */
class Idldrvlicense_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		$prefix = $wpdb->prefix;
        $wpdb->query( "DROP TABLE IF EXISTS `".$wpdb->prefix."licenses_data`" );
	}

}
