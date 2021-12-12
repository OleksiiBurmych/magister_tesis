<?php
/**
 * The plugin premium page.
 *
 * @link       https://shapedplugin.com/
 * @since      2.0.0
 * @package    team-free
 * @subpackage team-free/includes
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

namespace ShapedPlugin\WPTeam\Includes;

/**
 * Help page class for the help page.
 */
class Help_Page {

	/**
	 * Admin help page
	 *
	 * @since    2.0.0
	 */
	public function help_page() {
		add_submenu_page(
			'edit.php?post_type=sptp_member',
			__( 'Help', 'team-free' ),
			__( 'Help', 'team-free' ),
			'manage_options',
			'team_help',
			array( $this, 'help_page_callback' )
		);
	}

	/**
	 * Help Page Callback
	 */
	public function help_page_callback() {
		wp_enqueue_style( 'sp-team-free-admin-help', SPT_PLUGIN_ROOT . 'src/Admin/css/help-page.min.css', array(), SPT_PLUGIN_VERSION );
		if ( is_rtl() ) {
			wp_enqueue_style( 'sp-team-free-admin-help-rtl', SPT_PLUGIN_ROOT . 'src/Admin/css/help-page-rtl.min.css', array(), SPT_PLUGIN_VERSION );
		}
		$add_new_member_link = admin_url( 'post-new.php?post_type=sptp_member' );
		?>

	<div class="sp-team-help-page">
		<!-- Header section start -->
		<section class="sp-team-help header">
			<div class="header-area">
				<div class="container">
					<div class="header-logo">
						<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/wp-team.svg' ); ?>" alt="">
						<span><?php echo esc_html( SPT_PLUGIN_VERSION ); ?></span>
					</div>
					<div class="header-content">
						<p>Thank you for installing WP Team plugin! This video will help you get started with the plugin.</p>
					</div>
				</div>
			</div>
			<div class="video-area">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLoUb-7uG-5jPvyBSiv3x5HNvGQ3hx08RU" frameborder="0" allowfullscreen=""></iframe>
			</div>
			<div class="content-area">
				<div class="container">
					<div class="content-button">
						<a href="<?php echo esc_url( $add_new_member_link ); ?>">Start Adding Members</a>
						<a href="https://docs.shapedplugin.com/docs/wp-team/introduction/" target="_blank">Read Documentation</a>
					</div>
				</div>
			</div>
		</section>
		<!-- Header section end -->

		<!-- Upgrade section start -->
		<section class="sp-team-help upgrade">
			<div class="upgrade-area">
			<div class="upgrade-img">
			<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/wp-team-icon.svg' ); ?>" alt="WP Team">
			</div>
				<h2>Upgrade To WP Team Pro</h2>
				<p>Building a great-looking Team Page or Section has never been so much fun! Get the most out of WP Team by upgrading to unlock all of its powerful features like.</p>
			</div>
			<div class="upgrade-info">
				<div class="container">
					<div class="row">
						<div class="col-lg-6">
							<ul class="upgrade-list">
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								8 Unique team layouts (Carousel, Grid, Isotope Filter, List, Mosaic, Inline, Table, Thumbnails Pager).
								</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								5+ Member content positions.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								13 Member display options.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">Advanced typography (fonts, colors, styling).</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">Create unlimited team groups, members.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt=""> Multiple teams display on the same page.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt=""> 300+ Highly customizable options.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt=""> <span>Template Overriding or Modification and Required Filter and Action Hooks. <span class="sptp-new-ft">New</span></span> </li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">Filter team members by categories or groups, specific, and exclude too.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								Display team with taxonomy relation (IN, AND, NOT IN).</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt=""> Drag & Drop ordering integrated (for all fields, members, groups & more).</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt=""> Limit member bio characters.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">Member image shapes, effects, border, box-shadow, padding, and size.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								Member image effects(zoom, grayscale).</li>
							</ul>
						</div>
						<div class="col-lg-6">
							<ul class="upgrade-list">
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								Show/hide member detail page fields.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								3 Detail page link types (modal, drawer, and single page).</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">

								4 Modal layouts (Classic modal, Slide-ins left, center, right).</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">

								Single & multiple popup view with the navigation button.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">

								<span> Ajax Live Filtering for member groups. <span class="sptp-new-ft">New</span></span> </span> </li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">

								Multiple live filtering by taxonomy, position, location, etc.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">

								<span> Ajax Member Search option.  <span class="sptp-new-ft">New</span></span> </span> </li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								Ajax pagination control (Ajax number, load more, infinite on scroll, normal, etc.).</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								Set the members to show per page.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								Additional member photo gallery.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								25+ Team carousel controls.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								Multisite, multilingual (WPML), RTL, accessibility-ready.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								Page builders & theme compatibility.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt="">
								Top-notch support and frequent updates.</li>
								<li><img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/checkm.svg' ); ?>" alt=""><span>Not Happy? 100% No Questions Asked <a href="//shapedplugin.com/refund-policy/" target="_blank">Refund Policy!</a></span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="upgrade-pro">
					<div class="pro-content">
						<div class="pro-icon">
							<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/wpt-pro.svg' ); ?>" alt="">
						</div>
						<div class="pro-text">
							<h2>Upgrade To Unleash the Power of WP Team</h2>
							<p>Pricing starts at just $39... What are you waiting for?</p>
						</div>
					</div>
					<div class="pro-btn">
						<a href="https://shapedplugin.com/plugin/wp-team-pro/?ref=1" target="_blank">Upgrade To Pro Now</a>
					</div>
				</div>
			</div>
		</section>
		<!-- Upgrade section end -->

		<!-- Testimonial section start -->
		<section class="sp-team-help testimonial">
			<div class="row">
				<div class="col-lg-6">
					<div class="testimonial-area">
						<div class="testimonial-content">
							<p>The best filterable grid plugin I found to edit the text for longer details, so that the text doesn’t just run like a ribbon in a row. Nice minimalist design, various options can be activated and sorting by drag and drop is very helpful for many members or objects. </p>
						</div>
						<div class="testimonial-info">
							<div class="img">
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/Regina-Jungk-min.jpeg' ); ?>" alt="">
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
								<img src="<?php echo esc_url( SPT_PLUGIN_ROOT . 'src/Admin/img/ab-min.jpg' ); ?>" alt="">
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
		<!-- Testimonial section end -->
	</div>
		<?php
	}
}
