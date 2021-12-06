<?php
/**
 * The plugin premium page.
 *
 * @link       https://shapedplugin.com/
 * @since      2.0.0
 * @package    WP_Team
 * @subpackage WP_Team/includes
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

namespace ShapedPlugin\WPTeam\Admin\Helper;

/**
 * Team Premium class
 */
class Team_Premium {

	/**
	 * Add SubMenu Page
	 */
	public function premium_page() {
		add_submenu_page( 'edit.php?post_type=sptp_member', __( 'WP Team Premium', 'team-free' ), __( 'Premium', 'team-free' ), 'manage_options', 'wpteam_premium', array( $this, 'premium_page_callback' ) );
	}

	/**
	 * Happy users.
	 *
	 * @param boolean $username happy user name.
	 * @param array   $args happy user args.
	 * @return array
	 */
	public function happy_users( $username = 'shapedplugin', $args = array() ) {
		if ( $username ) {
			$params = array(
				'timeout'   => 10,
				'sslverify' => false,
			);

			$raw = wp_remote_retrieve_body( wp_remote_get( 'http://wptally.com/api/' . $username, $params ) );
			$raw = json_decode( $raw, true );

			if ( array_key_exists( 'error', $raw ) ) {
				$data = array(
					'error' => $raw['error'],
				);
			} else {
				$data = $raw;
			}
		} else {
			$data = array(
				'error' => __( 'No data found!', 'team-free' ),
			);
		}

		return $data;
	}


	/**
	 * Premium Page Callback
	 */
	public function premium_page_callback() {
		wp_enqueue_style( 'sp-team-free-admin-premium', SPT_PLUGIN_ROOT . 'src/Admin/css/premium-page.min.css', array(), SPT_PLUGIN_VERSION );
		wp_enqueue_style( 'sp-team-free-admin-premium-modal', SPT_PLUGIN_ROOT . 'src/Admin/css/modal-video.min.css', array(), SPT_PLUGIN_VERSION );
		wp_enqueue_script( 'sp-team-free-admin-premium', SPT_PLUGIN_ROOT . 'src/Admin/js/jquery-modal-video.min.js', array( 'jquery' ), SPT_PLUGIN_VERSION, true );
		?>
	<div class="sp-team-premium-page">
		<!-- Banner section start -->
		<section class="sp-team-banner">
			<div class="sp-team-container">
				<div class="row">
					<div class="sp-team-col-xl-6">
						<div class="sp-team-banner-content">
							<h2 class="sp-team-font-30 main-color sp-team-font-weight-500">
							<?php esc_html_e( 'Upgrade To WP Team Pro', 'team-free' ); ?>
							</h2>
							<h4 class="sp-team-mt-10 sp-team-font-18 sp-team-font-weight-500"><?php echo wp_kses_post( 'Supercharge <strong>Your Team Page</strong> with powerful functionality!', 'team-free' ); ?></h4>
							<p class="sp-team-mt-25 text-color-2 line-height-20 sp-team-font-weight-400"><?php esc_html_e( 'Create easily a great looking Team Page or Section on your WordPress site in a few minutes with excellent design and multiple options.', 'team-free' ); ?></p>
							<p class="sp-team-mt-20 text-color-2 sp-team-line-height-20 sp-team-font-weight-400"><?php esc_html_e( 'The plugin comes with the easiest Shortcode Generator settings panel that can help you build awesome and unique team page or section with responsive layouts and customized styles.', 'sp-team' ); ?></p>
						</div>
						<div class="sp-team-banner-button sp-team-mt-40">
							<a class="sp-team-btn sp-team-btn-sky" href="https://shapedplugin.com/plugin/wp-team-pro/?ref=1" target="_blank">Upgrade To Pro Now</a>
							<a class="sp-team-btn sp-team-btn-border ml-16 sp-team-mt-15" href="https://demo.shapedplugin.com/wp-team/" target="_blank">Live Demo</a>
						</div>
					</div>
					<div class="sp-team-col-xl-6">
						<div class="sp-team-banner-img">
							<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/wp-team-vector-com.svg' ); ?>" alt="">
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Banner section End -->

		<!-- Count section Start -->
		<section class="sp-team-count">
			<div class="sp-team-container">
				<div class="sp-team-count-area">
					<div class="count-item">
						<h3 class="sp-team-font-24">
						<?php
						$plugin_data  = $this->happy_users();
						$plugin_names = array_values( $plugin_data['plugins'] );

						$active_installations = array_column( $plugin_names, 'installs', 'url' );
						echo esc_attr( $active_installations['http://wordpress.org/plugins/team-free'] ) . '+';
						?>
						</h3>
						<span class="sp-team-font-weight-400">Active Installations</span>
					</div>
					<div class="count-item">
						<h3 class="sp-team-font-24">
						<?php
						$active_installations = array_column( $plugin_names, 'downloads', 'url' );
						echo esc_attr( $active_installations['http://wordpress.org/plugins/team-free'] );
						?>
						</h3>
						<span class="sp-team-font-weight-400">all time downloads</span>
					</div>
					<div class="count-item">
						<h3 class="sp-team-font-24">
						<?php
						$active_installations = array_column( $plugin_names, 'rating', 'url' );
						echo esc_attr( $active_installations['http://wordpress.org/plugins/team-free'] ) . '/5';
						?>
						</h3>
						<span class="sp-team-font-weight-400">user reviews</span>
					</div>
				</div>
			</div>
		</section>
		<!-- Count section End -->

		<!-- Video Section Start -->
		<section class="sp-team-video">
			<div class="sp-team-container">
				<div class="section-title text-center">
					<h2 class="sp-team-font-28">Make Your Team Page or Section Amazing!</h2>
					<h4 class="sp-team-font-16 sp-team-mt-10 sp-team-font-weight-400">Learn why WP Team Pro is the best Team Showcase plugin.</h4>
				</div>
				<div class="video-area text-center">
					<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/wp-team-vector.svg' ); ?>" alt="">
					<div class="video-button">
						<a class="js-video-button" href="#" data-channel="youtube" data-video-url="//www.youtube.com/embed/bdSNx3n5suA">
							<span><i class="fa fa-play"></i></span>
						</a>
					</div>
				</div>
			</div>
		</section>
		<!-- Video Section End -->

		<!-- Features Section Start -->
		<section class="sp-team-feature">
			<div class="sp-team-container">
				<div class="section-title text-center">
					<h2 class="sp-team-font-28">Key Pro Features</h2>
					<h4 class="sp-team-font-16 sp-team-mt-10 sp-team-font-weight-400">Upgrading to Pro will get you the following amazing benefits.</h4>
				</div>
				<div class="feature-wrapper">
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/responsive.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Mobile Responsive & SEO Friendly</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">WP Team Pro is fully mobile responsive and SEO-friendly. It looks great on any device. You have complete control to set device-wise specific columns. It adapts to fit any screen size or mobile device.</p>
							</div>
						</div>

						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="
								<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/layout1.svg' ); ?>
								" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">8 Unique Team Layouts</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">WP Team Pro comes with 8 unique team layouts (Carousel, Grid, Isotope Filter, List, Mosaic, Inline, Table, Thumbnails Pager.) to display your team members beautifully. The layouts are fully customizable.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
					<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="
								<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/content-position.svg' ); ?>
								" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">5+ Member Content Positions</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">The members will display in different team layouts with the number of columns you set and with the information to the right, left, above, or below the image, depending on your settings.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/display-opt.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">13 Display Options for Each Member</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">When adding a new member, you’ll have fields for specific content. These fields are member name, position, image, bio, location, email, mobile, phone, website, skill, socials, photo gallery, etc.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
					<div class="feature-item mr-30">
					<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/customize.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Customize Everything Easily</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">You will be able to make it look exactly how you want with layout and colors & typography settings! You have full control over styling to design your way. No coding skills or knowledge required!</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/wp-team-icon.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Display and Manage Unlimited Teams</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">Add unlimited team members and create unlimited groups. And build a great-looking team members page as you like across your WordPress site in a few clicks with excellent design and multiple options.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
					<div class="feature-item mr-30">
					<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/ajax-p-control.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Ajax Pagination Control (4 Pagination Types)</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">WP Team Pro has 4 types of pagination options, like Ajax number, Ajax load more, Ajax Infinite scroll, No Ajax. You can set how many team members you want to show per page with few customization options.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
						<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/details-page-setting.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Member Detail Page Settings </h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">Choose if the detail page feature will be active or not and what information you want to display on it! You can display with modal, drawer, a new page, classic modal, slide-ins, left, center, or right, etc.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
					<div class="feature-item mr-30">
					<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/color-styling.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Advanced Typography (Colors & Styling)</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">This is very important to be able to set fonts & colors to match your brand. WP Team Pro supports 900+ Google fonts and typography options. You can enable or disable Google fonts loading.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
						<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/image-gallery.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Additional Member Photo Gallery</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">
								Add additional images gallery for each team member. It’ll display on the member detail page with a beautiful gallery slider. You can add unlimited images for every team member which slides will autoplay.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/skill-social.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Add Unlimited Skill Bars & Socials</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">
								You can add unlimited skills with a progress bar for each member with customizable options. You can also add 35+ social profile icons, shapes, colors, and backgrounds. Both have a drag & drop feature.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/shaped.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Member Image Shapes, Effects, and Size</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">You can show your member photo in different shapes like square, rounded & circle. Customize image border, box-shadow, inner padding, etc. You can set specified size dimensions, zoom, grayscale effects.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/carousel-control.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">25+ Team Carousel Controls</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">WP Team Pro comes with more than 25 team carousel Controls, e.g: slider controls, such as autoplay, ticker, speed, scroll speed, pause on hover, loop, navigation, bullets, member per slide, auto-height, etc.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/compability.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Multisite, Multilingual, RTL, Accessibility Ready</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">WP Team Pro is multisite, multilingual, RTL, and accessibility-ready. For Arabic, Hebrew, Persian, etc. languages, you can select the right-to-left option for slider direction, without writing any CSS.</p>
							</div>
						</div>
					</div>
					<div class="feature-area">
						<div class="feature-item mr-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/builder.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Page Builders & Countless Theme Compatibility</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">The plugin works smoothly with the popular themes and page builders plugins, e,g: Gutenberg, WPBakery, Elementor/Pro, Divi builder, BeaverBuilder, Fusion Builder, SiteOrgin, Themify Builder, etc.</p>
							</div>
						</div>
						<div class="feature-item ml-30">
							<div class="feature-icon">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/frequent.svg' ); ?>" alt="">
							</div>
							<div class="feature-content">
								<h3 class="sp-team-font-18 sp-team-font-weight-600">Top-notch Support and Frequently Updates</h3>
								<p class="sp-team-font-15 sp-team-mt-15 sp-team-line-height-24">Our dedicated top-notch support team is always ready to offer you world-class support and help when needed. Our engineering team is continuously working to improve the plugin and release new versions!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Features Section End -->

		<!-- Buy Section Start -->
		<section class="sp-team-buy">
			<div class="sp-team-container">
				<div class="row">
					<div class="sp-team-col-xl-12">
						<div class="buy-content text-center">
							<div class="buy_img">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/premium/wp-team-icon.svg' ); ?>" alt="">
							</div>
							<h2 class="sp-team-font-28">Join 
							<?php
							$install = 0;
							foreach ( $plugin_names as &$plugin_name ) {
								$install += $plugin_name['installs'];
							}
							echo esc_attr( $install + '15000' ) . '+';
							?>
							Happys Users in 160+ Countries </h2>
							<p class="sp-team-font-16 sp-team-mt-25 sp-team-line-height-22">98% of customers are happy with <b>ShapedPlugin's</b> products and support. <br>
								So it’s a great time to join them.</p>
							<a class="sp-team-btn sp-team-btn-buy sp-team-mt-40" href="https://shapedplugin.com/plugin/wp-team-pro/?ref=1" target="_blank">Get Started for $39 Today!</a>
							<span>14 Days Money-back Guarantee! No Question Asked.</span>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Buy Section End -->

		<!-- Testimonial section start -->
		<div class="testimonial-wrapper">
		<section class="sp-team-premium testimonial">
			<div class="row">
				<div class="col-lg-6">
					<div class="testimonial-area">
						<div class="testimonial-content">
							<p>The best filterable grid plugin I found to edit the text for longer details, so that the text doesn’t just run like a ribbon in a row. Nice minimalist design, various options can be activated and sorting by drag and drop is very helpful for many members or objects.</p>
						</div>
						<div class="testimonial-info">
							<div class="img">
								<img src="<?php echo esc_attr( SPT_PLUGIN_ROOT . 'src/Admin/img/Regina-Jungk-min.jpeg' ); ?>" alt="">
							</div>
							<div class="info">
								<h3>Regina Jungk</h3>
								<p>Founder, Leichtes Design</p>
								<div class="star">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="testimonial-area">
						<div class="testimonial-content">
							<p>I had an issue where a WP Team feature was behaving slightly wrong, due to an incompatibility with my theme. The support team responded quickly to my question, and eventually solved the issue without any work from me. I only had to provide temporary administrator access.</p>
						</div>
						<div class="testimonial-info">
							<div class="img">
								<img src="<?php echo esc_attr( SPT_PLUGIN_ROOT . 'src/Admin/img/ab-min.jpg' ); ?>" alt="">
							</div>
							<div class="info">
								<h3>Aaron Brown</h3>
								<p>Stanford University</p>
								<div class="star">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		</div>
		<!-- Testimonial section end -->
	</div>
	<!-- End premium page -->
		<?php
	}
}
