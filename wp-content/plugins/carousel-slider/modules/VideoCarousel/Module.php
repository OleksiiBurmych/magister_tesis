<?php

namespace CarouselSlider\Modules\VideoCarousel;

defined( 'ABSPATH' ) || exit;

class Module {
	/**
	 * The instance of the class
	 *
	 * @var self
	 */
	protected static $instance;

	/**
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return self
	 */
	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();

			add_action( 'carousel_slider/meta_box_content', [ self::$instance, 'meta_box_content' ], 10, 2 );
			add_action( 'carousel_slider/save_slider', [ self::$instance, 'save_slider' ] );
			add_filter( 'carousel_slider/register_view', [ self::$instance, 'view' ] );
		}

		return self::$instance;
	}

	/**
	 * Meta box content
	 *
	 * @param int $slider_id
	 * @param string $slider_type
	 */
	public function meta_box_content( int $slider_id, string $slider_type ) {
		$is_video_carousel = $slider_type == 'video-carousel';
		$urls              = get_post_meta( $slider_id, '_video_url', true );
		$description       = sprintf( '%s<br><br>%s %s',
			esc_html__( 'Only support youtube and vimeo. Enter video URL from youtube or vimeo separating each by comma', 'carousel-slider' ),
			esc_html__( 'Example:', 'carousel-slider' ),
			'https://www.youtube.com/watch?v=O4-EM32h7b4,https://www.youtube.com/watch?v=72IO4gzB8mU,https://vimeo.com/193773669,https://vimeo.com/193517656'
		);
		?>
		<div data-id="open" id="section_video_settings" class="shapla-toggle shapla-toggle--stroke"
			 style="display: <?php echo $is_video_carousel ? 'block' : 'none'; ?>">
			<span class="shapla-toggle-title">
				<?php esc_html_e( 'Video Settings', 'carousel-slider' ); ?>
			</span>
			<div class="shapla-toggle-inner">
				<div class="shapla-toggle-content">
					<div class="sp-input-group" id="field-_video_url">
						<div class="sp-input-label">
							<label for="_video_url"><?php esc_html_e( 'Video URLs', 'carousel-slider' ) ?></label>
							<p class="sp-input-desc"><?php echo $description ?></p>
						</div>
						<div class="sp-input-field">
							<textarea class="sp-input-textarea" id="_video_url" cols="35" rows="6"
									  name="_video_url"><?php echo esc_textarea( $urls ) ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Save slider video url
	 *
	 * @param int $slider_id
	 */
	public function save_slider( int $slider_id ) {
		if ( isset( $_POST['_video_url'] ) ) {
			$urls          = is_string( $_POST['_video_url'] ) ? explode( ',', $_POST['_video_url'] ) : $_POST['_video_url'];
			$sanitize_urls = [];
			if ( is_array( $urls ) ) {
				foreach ( $urls as $url ) {
					if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
						$sanitize_urls[] = $url;
					}
				}
			}
			update_post_meta( $slider_id, '_video_url', implode( ',', $sanitize_urls ) );
		}
	}

	/**
	 * Register view
	 *
	 * @param array $views
	 *
	 * @return array
	 */
	public function view( array $views ): array {
		$views['video-carousel'] = new View();

		return $views;
	}
}
