<?php
/**
 * General tab.
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
 * This class is responsible for General tab in Team page.
 *
 * @since      2.0.0
 */
class SPTP_General {

	/**
	 * General settings.
	 *
	 * @since 2.0.0
	 * @param string $prefix _sptp_generator.
	 */
	public static function section( $prefix ) {
		SPF_TEAM::createSection(
			$prefix,
			array(
				'title'  => __( 'General Settings', 'team-free' ),
				'icon'   => 'fa fa-gear',
				'fields' => array(

					array(
						'id'         => 'style_title',
						'type'       => 'switcher',
						'title'      => __( 'Team Section Title', 'team-free' ),
						'subtitle'   => __( 'Show/Hide team section title.', 'team-free' ),
						'text_on'    => __( 'Show', 'team-free' ),
						'text_off'   => __( 'Hide', 'team-free' ),
						'default'    => true,
						'text_width' => 75,
					),
					array(
						'id'         => 'style_title_margin_bottom',
						'type'       => 'spacing',
						'title'      => __( 'Section Title Margin Bottom', 'team-free' ),
						'subtitle'   => __( 'Set margin bottom for team section title. Default value is 25px.', 'team-free' ),
						'default'    => array(
							'top'    => '0',
							'right'  => '0',
							'bottom' => '25',
							'left'   => '0',
							'unit'   => 'px',
						),
						'top'        => false,
						'right'      => false,
						'left'       => false,
						'units'      => array( 'px' ),
						'dependency' => array( 'style_title', '==', 'true' ),
					),
					array(
						'id'         => 'responsive_columns',
						'class'      => 'sptp_responsive_columns',
						'type'       => 'column',
						'title'      => __( 'Column(s)', 'team-free' ),
						'subtitle'   => __( 'Set number of column(s) in different devices for responsive view.', 'team-free' ),
						'dependency' => array( 'layout_preset', '!=', 'list', true ),
						'default'    => array(
							'desktop' => '4',
							'laptop'  => '3',
							'tablet'  => '2',
							'mobile'  => '1',
						),
						'help'       => '<i class="fa fa-desktop"></i> <strong>DESKTOP</strong> - Screens larger than 1024px.<br/>
						<i class="fa fa-laptop"></i> <strong>LAPTOP</strong> - Screens smaller than 1024px.<br/>
						<i class="fa fa-tablet"></i> <strong>TABLET</strong> - Screens smaller than 768px.<br/>
						<i class="fa fa-mobile"></i> <strong>MOBILE</strong> - Screens smaller than 414px.<br/>',
					),
					array(
						'id'         => 'responsive_columns_list',
						'class'      => 'sptp_responsive_columns_list',
						'type'       => 'column',
						'title'      => __( 'Column(s)', 'team-free' ),
						'subtitle'   => __( 'Set number of column(s) in different devices for responsive view.', 'team-free' ),
						'dependency' => array( 'layout_preset', '==', 'list', true ),
						'default'    => array(
							'desktop' => '1',
							'laptop'  => '1',
							'tablet'  => '1',
							'mobile'  => '1',
						),
						'help'       => '<i class="fa fa-desktop"></i> DESKTOP - Screens larger than 1024px.<br/>
						<i class="fa fa-laptop"></i> LAPTOP - Screens smaller than 1024px.<br/>
						<i class="fa fa-tablet"></i> TABLET - Screens smaller than 768px.<br/>
						<i class="fa fa-mobile"></i> MOBILE - Screens smaller than 414px.<br/>',
					),
					array(
						'id'       => 'total_member_display',
						'class'    => 'sptp_total_member_display',
						'type'     => 'spinner',
						'title'    => __( 'Limit', 'team-free' ),
						'default'  => '12',
						'subtitle' => __( 'Number of total members to display.  For all leave it empty.', 'team-free' ),
						'min'      => 1,
					),
					array(
						'id'       => 'order_by',
						'type'     => 'select',
						'title'    => __( 'Order By', 'team-free' ),
						'options'  => array(
							'title'    => __( 'Name', 'team-free' ),
							'id'       => __( 'ID', 'team-free' ),
							'date'     => __( 'Date', 'team-free' ),
							'rand'     => __( 'Random', 'team-free' ),
							'modified' => __( 'Modified', 'team-free' ),
						),
						'default'  => 'date',
						'subtitle' => __( 'Select an order by option.', 'team-free' ),
					),
					array(
						'id'       => 'order',
						'type'     => 'select',
						'title'    => __( 'Order', 'team-free' ),
						'options'  => array(
							'ASC'  => __( 'Ascending', 'team-free' ),
							'DESC' => __( 'Descending', 'team-free' ),
						),
						'default'  => 'DESC',
						'subtitle' => __( 'Select an order option.', 'team-free' ),
					),
					array(
						'id'         => 'member_live_filter',
						'class'      => 'member_live_filter sptp_pro_only_field',
						'type'       => 'switcher',
						'title'      => __( 'Ajax Live Filter', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable ajax live filtering for member groups.', 'team-free' ),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'default'    => false,
						'text_width' => 96,
						'dependency' => array( 'layout_preset', 'not-any', 'filter,thumbnail-pager', true ),
					),
					array(
						'id'         => 'member_search',
						'class'      => 'sptp_pro_only_field',
						'type'       => 'switcher',
						'title'      => __( 'Ajax Member Search', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable ajax search for member.', 'team-free' ),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'default'    => false,
						'text_width' => 96,
						'dependency' => array( 'layout_preset', '!=', 'thumbnail-pager', true ),

					),
					array(
						'id'         => 'preloader_switch',
						'type'       => 'switcher',
						'title'      => __( 'Preloader', 'team-free' ),
						'subtitle'   => __(
							'Team members will be hidden until page load completed.
						',
							'team-free'
						),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 94,
						'default'    => true,
					),
				),
			)
		);

	}
}
