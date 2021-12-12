<?php
namespace ShapedPlugin\WPTeam\Admin\GutenbergBlock;

/**
 * The plugin gutenberg block Initializer.
 *
 * @link       https://shapedplugin.com/
 * @since      2.1.8
 *
 * @package    WP_Team
 * @subpackage WP_Team/Admin
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Team_Gutenberg_Block_Init' ) ) {
	/**
	 * Team_Pro_Gutenberg_Block_Init class.
	 */
	class WP_Team_Gutenberg_Block_Init {
		/**
		 * Custom Gutenberg Block Initializer.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'sptf_gutenberg_shortcode_block' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'sptf_block_editor_assets' ) );
		}

		/**
		 * Register block editor script for backend.
		 */
		public function sptf_block_editor_assets() {
			wp_enqueue_script(
				'team-free-shortcode-block',
				plugins_url( '/GutenbergBlock/build/index.js', dirname( __FILE__ ) ),
				array( 'jquery', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ),
				SPT_PLUGIN_VERSION,
				true
			);

			/**
			 * Register block editor css file enqueue for backend.
			 */
			$min = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
			wp_register_style( 'team-free-fontawesome-fa5', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/all' . $min . '.css', array(), '5.15.3', 'all' );
			wp_register_style( 'team-free-fontawesome-fa5-v4-shims', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/v4-shims' . $min . '.css', array(), '5.15.3', 'all' );
			wp_register_style( 'team-free-swiper', SPT_PLUGIN_ROOT . 'src/Frontend/css/swiper.min.css', array(), SPT_PLUGIN_VERSION, 'all' );
			wp_register_style( SPT_PLUGIN_SLUG, SPT_PLUGIN_ROOT . 'src/Frontend/css/public.min.css', array(), SPT_PLUGIN_VERSION, 'all' );

			$sptp_settings    = get_option( '_sptp_settings' );
			$sptp_fontawesome = isset( $sptp_settings['enqueue_fontawesome'] ) ? $sptp_settings['enqueue_fontawesome'] : true;
			$sptp_swiper_css  = isset( $sptp_settings['enqueue_swiper'] ) ? $sptp_settings['enqueue_swiper'] : true;
			$sptp_custom_css  = isset( $sptp_settings['custom_css'] ) ? $sptp_settings['custom_css'] : '';
			if ( $sptp_swiper_css ) {
				wp_enqueue_style( 'team-free-swiper' );
			}
			if ( $sptp_fontawesome ) {
				wp_enqueue_style( 'team-free-fontawesome-fa5' );
				wp_enqueue_style( 'team-free-fontawesome-fa5-v4-shims' );
			}
			wp_enqueue_style( SPT_PLUGIN_SLUG );

		}

		/**
		 * Shortcode list.
		 *
		 * @return array
		 */
		public function sptf_post_list() {
			$shortcodes = get_posts(
				array(
					'post_type'      => 'sptp_generator',
					'post_status'    => 'publish',
					'posts_per_page' => 9999,
				)
			);

			if ( count( $shortcodes ) < 1 ) {
				return array();
			}

			return array_map(
				function ( $shortcode ) {
						return (object) array(
							'id'    => absint( $shortcode->ID ),
							'title' => esc_html( $shortcode->post_title ),
						);
				},
				$shortcodes
			);
		}

		/**
		 * Register Gutenberg shortcode block.
		 */
		public function sptf_gutenberg_shortcode_block() {
			/**
			 * Register block editor js file enqueue for backend.
			 */
			wp_register_script( 'team-free-swiper', SPT_PLUGIN_ROOT . 'src/Frontend/js/swiper.min.js', array(), SPT_PLUGIN_VERSION, true );
			wp_register_script( SPT_PLUGIN_SLUG, SPT_PLUGIN_ROOT . 'src/Frontend/js/script.js', array( 'jquery' ), SPT_PLUGIN_VERSION, true );

			wp_localize_script(
				SPT_PLUGIN_SLUG,
				'TeamFreeGbScript',
				array(
					'loodScript' => SPT_PLUGIN_ROOT . 'src/Frontend/js/script.js',
					'path'       => SPT_PLUGIN_ROOT,
					'url'        => admin_url( 'post-new.php?post_type=sptp_generator' ),
				)
			);
			/**
			 * Register Gutenberg block on server-side.
			 */
			register_block_type(
				'team-free/shortcode',
				array(
					'attributes'      => array(
						'shortcodelist'      => array(
							'type'    => 'object',
							'default' => $this->sptf_post_list(),
						),
						'shortcode'          => array(
							'type'    => 'string',
							'default' => '',
						),
						'showInputShortcode' => array(
							'type'    => 'boolean',
							'default' => true,
						),
						'is_admin'           => array(
							'type'    => 'boolean',
							'default' => is_admin(),
						),
						'preview'            => array(
							'type'    => 'boolean',
							'default' => false,
						),
					),
					'example'         => array(
						'attributes' => array(
							'preview' => true,
						),
					),
					// Enqueue blocks.editor.build.js in the editor only.
					'editor_script'   => array(
						'team-free-swiper',
						SPT_PLUGIN_SLUG,
					),
					// Enqueue blocks.editor.build.css in the editor only.
					'editor_style'    => array(),
					'render_callback' => array( $this, 'sp_team_free_render_shortcode' ),
				)
			);
		}

		/**
		 * Render callback.
		 *
		 * @param string $attributes Shortcode.
		 * @return string
		 */
		public function sp_team_free_render_shortcode( $attributes ) {

			if ( $attributes['preview'] ) {
				return '<div class="sptf_shortcode_block_preview_image"><img src="' . SPT_PLUGIN_ROOT . 'src/Admin/GutenbergBlock/src/wp-team-block-preview.svg"/></div>';
			}

			if ( is_null( $attributes['shortcode'] ) || '' === $attributes['shortcode'] ) {
				return __( '<i></i>', 'wp-team' );
			}

			if ( ! $attributes['is_admin'] ) {
				return do_shortcode( '[wpteam id="' . sanitize_text_field( $attributes['shortcode'] ) . '"]' );
			}

			$generator_id = $attributes['shortcode'];
			$final_css    = '';
			$layout       = get_post_meta( $generator_id, '_sptp_generator_layout', true );
			$settings     = get_post_meta( $generator_id, '_sptp_generator', true );
			include SPT_PLUGIN_PATH . 'src/Frontend/partials/dynamic-style.php';
			$style = '<style>' . $final_css . '</style>';
			return $style . '<div id="' . uniqid() . '">' . do_shortcode( '[wpteam id="' . sanitize_text_field( $attributes['shortcode'] ) . '"]' ) . '</div>';
		}
	}
}
