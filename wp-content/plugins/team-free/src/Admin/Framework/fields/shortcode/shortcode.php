<?php
/**
 * Framework Shortcode field file.
 *
 * @link https://shapedplugin.com
 * @since 2.0.0
 *
 * @package team-free
 * @subpackage team-free/framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! class_exists( 'TEAMFW_Field_shortcode' ) ) {
	/**
	 *
	 * Field: Shortcode
	 *
	 * @since 2.0
	 * @version 2.0
	 */
	class TEAMFW_Field_shortcode extends TEAMFW_Fields {

		/**
		 * Field constructor.
		 *
		 * @param array  $field The field type.
		 * @param string $value The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where To where show the output CSS.
		 * @param string $parent The parent args.
		 */
		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		/**
		 * Render field
		 *
		 * @return statement
		 */
		public function render() {
			$post_id = get_the_ID();

			if ( empty( $post_id ) ) {
				return 'Post ID not found.';
			}
			echo '<div class="sptp-scode-wrap">
				<span class="sptp-sc-title">Shortcode:</span>
					<span class="sptp-shortcode-selectable">
						[wpteam id="' . esc_html( $post_id ) . '"]
					</span>
				</div>';
			echo '<div class="sptp-scode-wrap">
				<div class="sptp-after-copy-text">
					<i class="fa fa-check-circle"></i> ' . esc_html__( 'Shortcode Copied to Clipboard!', 'team-free' ) . '</div>
					<span class="sptp-sc-title">Template Include:</span>
					<span class="sptp-shortcode-selectable">
					&lt;?php echo do_shortcode( \'[wpteam id="' . esc_attr( $post_id ) . '"]\'); ?&gt;
					</span>
				</div>';
		}
	}

}
