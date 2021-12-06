<?php
/**
 * Carousel tab.
 *
 * @since      2.0.0
 * @version    2.0.0
 *
 * @package    WP_Team
 * @subpackage WP_Team/admin
 * @author     ShapedPlugin<support@shapedplugin.com>
 */

namespace ShapedPlugin\WPTeam\Admin\Configs\Generator;

use ShapedPlugin\WPTeam\Admin\Framework\Classes\SPF_TEAM;
// Cannot access directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * This class is responsible for Carousel tab in Team page.
 *
 * @since      2.0.0
 */
class SPTP_Carousel {

	/**
	 * Carousel settings.
	 *
	 * @since 2.0.0
	 * @param string $prefix _sptp_generator.
	 */
	public static function section( $prefix ) {
		SPF_TEAM::createSection(
			$prefix,
			array(
				'title'  => __( 'Carousel Controls', 'team-free' ),
				'icon'   => 'fa fa-sliders',
				'fields' => array(
					array(
						'id'       => 'carousel_mode',
						'type'     => 'button_set',
						'title'    => __( 'Carousel Mode', 'team-free' ),
						'options'  => array(
							'standard' => __( 'Standard', 'team-free' ),
							'ticker'   => array(
								'option_name' => __( 'Ticker', 'team-free' ),
								'pro_only'    => true,
							),
						),
						'default'  => 'standard',
						'subtitle' => __( 'Set carousel mode. Carousel controls are disabled in the ticker mode.', 'team-free' ),
					),
					array(
						'id'         => 'carousel_autoplay',
						'type'       => 'switcher',
						'title'      => __( 'AutoPlay', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable auto play.', 'team-free' ),
						'default'    => 'true',
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 95,
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
					),
					array(
						'id'         => 'carousel_autoplay_speed',
						'class'      => 'sptp_carousel_autoplay_speed',
						'type'       => 'spinner',
						'title'      => __( 'AutoPlay Speed', 'team-free' ),
						'subtitle'   => __( 'Set autoplay speed in milliseconds.', 'team-free' ),
						'max'        => 30000,
						'min'        => 1,
						'default'    => 5000,
						'unit'       => 'ms',
						'step'       => 100,
						'dependency' => array( 'carousel_mode|carousel_autoplay', '==|==', 'standard|true' ),
					),
					array(
						'id'       => 'carousel_speed',
						'class'    => 'sptp_carousel_speed',
						'type'     => 'spinner',
						'title'    => __( 'Carousel Speed', 'team-free' ),
						'subtitle' => __( 'Set carousel speed in milliseconds.', 'team-free' ),
						'max'      => 10000,
						'min'      => 1,
						'default'  => 600,
						'unit'     => 'ms',
						'step'     => 10,
					),
					array(
						'id'         => 'carousel_onhover',
						'type'       => 'switcher',
						'title'      => __( 'Stop on Hover', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable carousel pause on hover.', 'team-free' ),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 95,
						'default'    => 'true',
						'dependency' => array( 'carousel_mode|carousel_autoplay', '==|==', 'standard|true' ),
					),
					array(
						'id'         => 'carousel_loop',
						'type'       => 'switcher',
						'title'      => __( 'Loop', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable infinite loop mode.', 'team-free' ),
						'default'    => 'true',
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 95,
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
					),
					array(
						'id'         => 'carousel_auto_height',
						'type'       => 'switcher',
						'title'      => __( 'Auto Height', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable auto height for the carousel.', 'team-free' ),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 95,
						'default'    => 'true',
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
					),
					array(
						'id'       => 'responsive_row',
						'class'    => 'sptp_responsive_columns sptp_pro_only_field',
						'type'     => 'column',
						'title'    => __( 'Row', 'team-free' ),
						'subtitle' => __( 'Set number of rows in different devices for responsive view.', 'team-free' ),
						'default'  => array(
							'desktop' => '1',
							'laptop'  => '1',
							'tablet'  => '1',
							'mobile'  => '1',
						),
					),
					array(
						'type'    => 'subheading',
						'content' => __( 'Navigation', 'team-free' ),
					),
					array(
						'id'         => 'carousel_navigation',
						'type'       => 'switcher',
						'title'      => __( 'Navigation', 'team-free' ),
						'subtitle'   => __( 'Show/Hide carousel navigation.', 'team-free' ),
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
						'text_on'    => __( 'Show', 'team-free' ),
						'text_off'   => __( 'Hide', 'team-free' ),
						'default'    => true,
						'text_width' => 75,
					),
					array(
						'id'         => 'carousel_navigation_color',
						'type'       => 'color_group',
						'title'      => __( 'Color', 'team-free' ),
						'subtitle'   => __( 'Set color for the carousel navigation.', 'team-free' ),
						'options'    => array(
							'color'          => __( 'Color', 'team-free' ),
							'hover_color'    => __( 'Hover Color', 'team-free' ),
							'bg_color'       => __( 'Background', 'team-free' ),
							'bg_hover_color' => __( 'Hover Background', 'team-free' ),
						),
						'default'    => array(
							'color'          => '#aaaaaa',
							'hover_color'    => '#ffffff',
							'bg_color'       => 'transparent',
							'bg_hover_color' => '#63a37b',
						),
						'dependency' => array( 'carousel_navigation|carousel_mode', '==|==', 'true|standard' ),
					),
					array(
						'id'         => 'carousel_navigation_border',
						'type'       => 'border',
						'title'      => __( 'Border', 'team-free' ),
						'subtitle'   => __( 'Set border for the carousel navigation.', 'team-free' ),
						'all'        => true,
						'default'    => array(
							'all'         => 1,
							'style'       => 'solid',
							'color'       => '#aaaaaa',
							'hover_color' => '#63a37b',
							'unit'        => 'px',
						),
						'dependency' => array( 'carousel_navigation|carousel_mode', '==|==', 'true|standard' ),
					),
					array(
						'type'    => 'subheading',
						'content' => __( 'Pagination', 'team-free' ),
					),
					array(
						'id'         => 'carousel_pagination',
						'type'       => 'switcher',
						'title'      => __( 'Pagination', 'team-free' ),
						'subtitle'   => __( 'Show/hide pagination dots.', 'team-free' ),
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
						'text_on'    => __( 'Show', 'team-free' ),
						'text_off'   => __( 'Hide', 'team-free' ),
						'default'    => true,
						'text_width' => 75,
					),
					array(
						'id'         => 'carousel_pagination_color',
						'type'       => 'color_group',
						'title'      => __( 'Color', 'team-free' ),
						'subtitle'   => __( 'Set color for the pagination dots.', 'team-free' ),
						'options'    => array(
							'color'        => __( 'Color', 'team-free' ),
							'active_color' => __( 'Active Color', 'team-free' ),
						),
						'default'    => array(
							'color'        => '#aaaaaa',
							'active_color' => '#63a37b',
						),
						'dependency' => array( 'carousel_pagination|carousel_mode', '==|==', 'true|standard' ),
					),
					array(
						'id'         => 'member_per_slide',
						'type'       => 'column',
						'title'      => __( 'Member(s) Per Slide', 'team-free' ),
						'subtitle'   => __( 'Set members per slide or scroll at a time.', 'team-free' ),
						'default'    => array(
							'desktop' => '1',
							'laptop'  => '1',
							'tablet'  => '1',
							'mobile'  => '1',
						),
						'dependency' => array( 'layout_preset', '==', 'carousel', 'all' ),
					),
					// Miscellaneous Settings.
					array(
						'type'       => 'subheading',
						'content'    => __( 'Miscellaneous', 'team-free' ),
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
					),
					array(
						'id'         => 'touch_swipe',
						'type'       => 'switcher',
						'title'      => __( 'Touch Swipe', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable touch swipe mode.', 'team-free' ),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 94,
						'default'    => 'true',
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
					),
					array(
						'id'         => 'slider_draggable',
						'type'       => 'switcher',
						'title'      => __( 'Mouse Draggable', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable mouse draggable mode.', 'team-free' ),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 94,
						'default'    => 'true',
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
					),
					array(
						'id'         => 'free_mode',
						'type'       => 'switcher',
						'title'      => __( 'Free Mode', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable free mode.', 'team-free' ),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 94,
						'default'    => false,
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
					),
					array(
						'id'         => 'slider_mouse_wheel',
						'type'       => 'switcher',
						'title'      => __( 'Mousewheel Control', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable mousewheel control.', 'team-free' ),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 94,
						'default'    => false,
						'dependency' => array( 'carousel_mode', '==', 'standard' ),
					),
				),
			)
		);
	}
}
