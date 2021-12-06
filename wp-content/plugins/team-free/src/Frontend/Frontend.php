<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    team-free
 * @subpackage team-free/public
 * @author     ShapedPlugin <info@shapedplugin.com>
 */

namespace ShapedPlugin\WPTeam\Frontend;

use ShapedPlugin\WPTeam\Frontend\Helper;

/**
 * Frontend class
 */
class Frontend {

	/**
	 * The name of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name    The name of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Generator
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      integer    $generator_id    Generator ID of team.
	 */
	private $generator_id;

	/**
	 * The Settings key.
	 *
	 * @since    2.0.0
	 * @access private
	 * @var mixed Settings
	 */
	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		add_shortcode( 'wpteam', array( $this, 'sptp_shortcode_func' ) );
		define( 'SPT_TRANSIENT_EXPIRATION', apply_filters( 'spteam_free_transient_expiration', DAY_IN_SECONDS ) );

		add_filter( 'single_template', array( $this, 'get_custom_post_type_template' ) );
		// Member single page css.
		add_action( 'wp_head', array( $this, 'sp_team_free_single_css' ), 99 );
	}

	/**
	 * Get custom template for the team post type.
	 *
	 * @param string $single_template The template file.
	 *
	 * @return string
	 */
	public function get_custom_post_type_template( $single_template ) {
		global $post;
		if ( 'sptp_member' === $post->post_type ) {
			return Helper::sptp_locate_template( 'sptp-single.php' );
			wp_reset_postdata();
		}
		return $single_template;
	}
	/**
	 * Single page css.
	 *
	 * @return css
	 */
	public function sp_team_free_single_css() {
		global $post;
		if ( is_object( $post ) && 'sptp_member' === $post->post_type ) {
			ob_start();
			Helper::sp_team_free_single_css();
			echo ob_get_clean();
		}
	}

	/**
	 * Function get layout from atts and create class depending on it.
	 *
	 * @param array $attributes Shortcode's all attributes/options.
	 * @since 2.0.0
	 */
	public function sptp_shortcode_func( $attributes ) {

		if ( empty( $attributes['id'] ) || ( get_post_status( $attributes['id'] ) === 'trash' ) ) {
			return;
		}
		$generator_id = $attributes['id'];
		// Preset Layouts.
		$layout = get_post_meta( $generator_id, '_sptp_generator_layout', true );
		// All the visible options for the Shortcode like – Global, Filter, Display, Popup, Typography etc.
		$settings           = get_post_meta( $generator_id, '_sptp_generator', true );
		$main_section_title = get_the_title( $generator_id );
		Helper::sptp_html_show( $generator_id, $layout, $settings, $main_section_title );
		return ob_get_clean();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_styles() {
		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Team_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Team_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$min = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
		wp_register_style( 'team-free-fontawesome-fa5', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/all' . $min . '.css', array(), '5.15.3', 'all' );
		wp_register_style( 'team-free-fontawesome-fa5-v4-shims', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/v4-shims' . $min . '.css', array(), '5.15.3', 'all' );
		wp_register_style( 'team-free-swiper', SPT_PLUGIN_ROOT . 'src/Frontend/css/swiper.min.css', array(), SPT_PLUGIN_VERSION, 'all' );
		wp_register_style( SPT_PLUGIN_SLUG, SPT_PLUGIN_ROOT . 'src/Frontend/css/public.min.css', array(), SPT_PLUGIN_VERSION, 'all' );
		$css_load_in_head = true;
		$sptp_settings    = get_option( '_sptp_settings' );
		$sptp_fontawesome = isset( $sptp_settings['enqueue_fontawesome'] ) ? $sptp_settings['enqueue_fontawesome'] : true;
		$sptp_swiper_css  = isset( $sptp_settings['enqueue_swiper'] ) ? $sptp_settings['enqueue_swiper'] : true;
		$sptp_custom_css  = isset( $sptp_settings['custom_css'] ) ? $sptp_settings['custom_css'] : '';
		$css_load_in_head = apply_filters( 'spteam_free_style_load_in_header', true );
		if ( $css_load_in_head ) {
			if ( $sptp_swiper_css ) {
				wp_enqueue_style( 'team-free-swiper' );
			}
			if ( $sptp_fontawesome ) {
				wp_enqueue_style( 'team-free-fontawesome-fa5' );
				wp_enqueue_style( 'team-free-fontawesome-fa5-v4-shims' );
			}
			wp_enqueue_style( SPT_PLUGIN_SLUG );
			$sptp_posts = new \WP_Query(
				array(
					'post_type'      => 'sptp_generator',
					'post_status'    => 'publish',
					'posts_per_page' => 1000,
				)
			);
			$post_ids   = wp_list_pluck( $sptp_posts->posts, 'ID' );
			$final_css  = '';
			foreach ( $post_ids as $generator_id ) {
				$layout   = get_post_meta( $generator_id, '_sptp_generator_layout', true );
				$settings = get_post_meta( $generator_id, '_sptp_generator', true );
				include 'partials/dynamic-style.php';
			}
			$final_css .= $sptp_custom_css;
			wp_add_inline_style( SPT_PLUGIN_SLUG, $final_css );
		}

		// Frontend rtl css code.
		if ( is_rtl() ) {
			wp_enqueue_style( 'public-rtl', SPT_PLUGIN_ROOT . 'src/Frontend/css/public-rtl.min.css', array(), SPT_PLUGIN_VERSION, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Team_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Team_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_script( 'team-free-swiper', SPT_PLUGIN_ROOT . 'src/Frontend/js/swiper.min.js', array(), SPT_PLUGIN_VERSION, true );
		wp_register_script( SPT_PLUGIN_SLUG, SPT_PLUGIN_ROOT . 'src/Frontend/js/script.js', array( 'jquery' ), SPT_PLUGIN_VERSION, true );

	}

}
