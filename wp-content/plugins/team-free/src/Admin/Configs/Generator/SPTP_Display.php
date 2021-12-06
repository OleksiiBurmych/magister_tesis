<?php
/**
 * Display settings tab.
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
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * This class is responsible for Style tab in Team page.
 *
 * @since      2.0.0
 */
class SPTP_Display {

	/**
	 * Member Display Settings.
	 *
	 * @since 2.0.0
	 * @param string $prefix _sptp_generator.
	 */
	public static function section( $prefix ) {
		SPF_TEAM::createSection(
			$prefix,
			array(
				'title'  => __( 'Display Options', 'team-free' ),
				'icon'   => 'fa fa-th-large',
				'fields' => array(

					array(
						'id'       => 'style_margin_between_member',
						'class'    => 'sptp_style_margin_between_member',
						'type'     => 'spacing',
						'title'    => __( 'Margin Between Members', 'team-free' ),
						'subtitle' => __( 'Set space or margin between members. Default value is 24px.', 'team-free' ),
						'all'      => true,
						'units'    => array( 'px' ),
						'all_text' => '<i class="fa fa-arrows-h"></i>',
						'default'  => array(
							'all' => 24,
						),
					),
					array(
						'id'         => 'style_member_content_position',
						'class'      => 'sptp_member_content_position',
						'type'       => 'image_select',
						'title'      => __( 'Member Content Position', 'team-free' ),
						'desc'       => __( 'To unlock the more amazing Member Content Positions and Settings, <a href="https://shapedplugin.com/plugin/wp-team-pro/?ref=1" target="_blank"><b>Upgrade To Pro!</b></a>', 'team-free' ),
						'dependency' => array( 'layout_preset', '!=', 'list', true ),
						'options'    => array(
							'top_img_bottom_content' => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/below-content.svg',
								'option_name' => __( 'Below Content', 'team-free' ),

							),
							'top_content_bottom_img' => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/above-content.svg',
								'option_name' => __( 'Above Content', 'team-free' ),
								'pro_only'    => true,
							),
							'left_img_right_content' => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/right-content.svg',
								'option_name' => __( 'Right Content', 'team-free' ),
								'pro_only'    => true,
							),
							'left_content_right_img' => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/left-content.svg',
								'option_name' => __( 'Left Content', 'team-free' ),
								'pro_only'    => true,
							),
							'content_over_image'     => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/content-over-image.svg',
								'option_name' => __( 'Overlay content', 'team-free' ),
								'pro_only'    => true,
							),
						),
						'default'    => 'top_img_bottom_content',
						'subtitle'   => __( 'Select a position or layout for member content and image.', 'team-free' ),
					),
					array(
						'id'         => 'style_member_content_position_list',
						'class'      => 'sptp_member_content_position_list',
						'type'       => 'image_select',
						'title'      => __( 'Member Content Position', 'team-free' ),
						'dependency' => array( 'layout_preset', '==', 'list', true ),
						'options'    => array(
							'left_img_right_content' => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/right-content.svg',
								'option_name' => __( 'Right Content', 'team-free' ),
								'class'       => 'sptp-free-feature',
							),
							'left_content_right_img' => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/left-content.svg',
								'option_name' => __( 'Left Content', 'team-free' ),
								'class'       => 'sptp-pro-feature',
							),
						),
						'default'    => 'left_img_right_content',
						'subtitle'   => __( 'Select a position or layout for member content and image.', 'team-free' ),
					),
					array(
						'id'     => 'border_bg_around_member',
						'type'   => 'fieldset',
						'class'  => 'sptp-border-bg-group',
						'fields' => array(
							array(
								'id'       => 'border_around_member',
								'class'    => 'sptp_border_around',
								'type'     => 'border',
								'title'    => __( 'Border', 'team-free' ),
								'subtitle' => __( 'Set border for the member.', 'team-free' ),
								'all'      => true,
								'default'  => array(
									'all'         => 0,
									'style'       => 'none',
									'unit'        => 'px',
									'color'       => '#ddd',
									'hover_color' => '#444',
								),
							),
							array(
								'id'       => 'border_radius_around_member',
								'class'    => 'sptp_border_radius_around',
								'type'     => 'spinner',
								'title'    => __( 'Border Radius', 'team-free' ),
								'subtitle' => __( 'Set border radius for the member.', 'team-free' ),
								'default'  => 0,
								'unit'     => 'px',
							),
							array(
								'id'       => 'bg_color_around_member',
								'class'    => 'sptp_bg_color_around',
								'type'     => 'color',
								'title'    => __( 'Background Color', 'team-free' ),
								'subtitle' => __( 'Set background color for the member.', 'team-free' ),
								'default'  => 'transparent',
							),
						),
					),
					array(
						'id'       => 'style_members',
						'class'    => 'sptp_style_generator_list',
						'type'     => 'fieldset',
						'title'    => __( 'Member Meta Fields', 'team-free' ),
						'subtitle' => __( 'Show/Hide member meta fields.', 'team-free' ),
						'desc'     => __( 'To unlock the additional information fields and drag & drop sorting options</b>, <a href="//shapedplugin.com/plugin/wp-team-pro/" target="_blank"><b>Upgrade To Pro!</b></a>', 'team-free' ),
						'default'  => array(
							'image_switch'        => true,
							'name_switch'         => true,
							'job_position_switch' => true,
							'bio_switch'          => true,
							'social_switch'       => true,
						),
						'fields'   => array(
							array(
								'id'         => 'image_switch',
								'type'       => 'switcher',
								'title'      => __( 'Photo/Image', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'name_switch',
								'type'       => 'switcher',
								'title'      => __( 'Member Name', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'job_position_switch',
								'type'       => 'switcher',
								'title'      => __( 'Position/Job Title', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'bio_switch',
								'class'      => 'sptp_bio_switch',
								'type'       => 'switcher',
								'title'      => __( 'Short Bio', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'email_switch',
								'class'      => 'sptp_member_meta_info_pro sptp_pro_only_field',
								'type'       => 'switcher',
								'title'      => __( 'Email', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'mobile_switch',
								'class'      => 'sptp_member_meta_info_pro sptp_pro_only_field',
								'type'       => 'switcher',
								'title'      => __( 'Mobile (personal)', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'phone_switch',
								'class'      => 'sptp_member_meta_info_pro sptp_pro_only_field',
								'type'       => 'switcher',
								'title'      => __( 'Phone (business)', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'location_switch',
								'class'      => 'sptp_member_meta_info_pro sptp_pro_only_field',
								'type'       => 'switcher',
								'title'      => __( 'Location', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'website_switch',
								'class'      => 'sptp_member_meta_info_pro sptp_pro_only_field',
								'type'       => 'switcher',
								'title'      => __( 'Website', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'skill_switch',
								'class'      => 'sptp_member_meta_info_pro sptp_pro_only_field',
								'type'       => 'switcher',
								'title'      => __( 'Skill Bars', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
							array(
								'id'         => 'social_switch',
								'type'       => 'switcher',
								'title'      => __( 'Social Profiles', 'team-free' ),
								'text_on'    => __( 'Show', 'team-free' ),
								'text_off'   => __( 'Hide', 'team-free' ),
								'text_width' => 75,
							),
						),
					),
					array(
						'id'     => 'social_settings',
						'class'  => 'sptp_social_settings',
						'type'   => 'fieldset',
						'title'  => __( 'Social Settings', 'team-free' ),
						'fields' => array(
							array(
								'id'      => 'social_position',
								'class'   => 'sptp_social_position',
								'type'    => 'button_set',
								'title'   => __( 'Position', 'team-free' ),
								'options' => array(
									'left'   => '<i class="fa fa-align-left" title="Left"></i>',
									'center' => '<i class="fa fa-align-center" title="Center"></i>',
									'right'  => '<i class="fa fa-align-right" title="Right"></i>',
								),
								'default' => 'center',
							),
							array(
								'id'    => 'social_margin',
								'type'  => 'spacing',
								'title' => __( 'Margin', 'team-free' ),
								'units' => array( 'px' ),
							),
							array(
								'id'      => 'social_icon_shape',
								'class'   => 'sptp_social_icon_shape',
								'type'    => 'image_select',
								'title'   => __( 'Social Icon Shape', 'team-free' ),
								'options' => array(
									'rounded' => array(
										'image' => SPT_PLUGIN_ROOT . 'src/Admin/img/round-icon.svg',
										'class' => 'sptp_free-feature',
									),
									'circle'  => array(
										'image' => SPT_PLUGIN_ROOT . 'src/Admin/img/circle-icon.svg',
										'class' => 'sptp_free-feature',
									),
								),
								'default' => 'rounded',
							),
							array(
								'id'         => 'social_icon_custom_color',
								'class'      => 'sptp_pro_only_field',
								'attributes' => array( 'disabled' => 'disabled' ),
								'type'       => 'checkbox',
								'title'      => __( 'Custom Color (Pro)', 'team-free' ),
								'default'    => false,
							),
						),
					),
					array(
						'type'       => 'notice',
						'content'    => __( 'To unlock the following pagination settings</b>, <a href="//shapedplugin.com/plugin/wp-team-pro/" target="_blank"><b>Upgrade To Pro!</b></a>', 'team-free' ),
						'dependency' => array( 'layout_preset', 'not-any', 'thumbnail-pager,filter,carousel', true ),
					),
					array(
						'id'         => 'pagination_fields',
						'type'       => 'fieldset',
						'class'      => 'sptp-pagination-group sptp_pro_only_field',
						'dependency' => array( 'layout_preset', 'not-any', 'thumbnail-pager,filter,carousel', true ),
						'fields'     => array(
							array(
								'id'         => 'pagination_universal',
								'type'       => 'switcher',
								'title'      => __( 'Pagination', 'team-free' ),
								'subtitle'   => __( 'Enabled/Disabled pagination', 'team-free' ),
								'text_on'    => __( 'Enabled', 'team-free' ),
								'text_off'   => __( 'Disabled', 'team-free' ),
								'text_width' => 90,
								'default'    => false,
								'class'      => 'sptp-pagination',
							),
							array(
								'id'       => 'universal_pagination_type',
								'type'     => 'radio',
								'title'    => __( 'Pagination Type', 'team-free' ),
								'subtitle' => __( 'Choose a pagination type.', 'team-free' ),
								'options'  => array(
									'pagination_number' => __( 'Ajax Number Pagination', 'team-free' ),
									'pagination_btn'    => __( 'Load More Button (Ajax)', 'team-free' ),
									'pagination_scrl'   => __( 'Load More on Scroll (Ajax)', 'team-free' ),
									'pagination_normal' => __( 'No Ajax (Normal Pagination)', 'team-free' ),
								),
								'default'  => 'pagination_normal',
							),
							array(
								'id'       => 'pagination_show_per_page',
								'type'     => 'spinner',
								'title'    => __( 'Member(s) To Show Per Page', 'team-free' ),
								'subtitle' => __( 'Set number of member(s) to show in per page.', 'team-free' ),
								'default'  => 8,
							),
							array(
								'id'         => 'load_more_label',
								'type'       => 'text',
								'title'      => __( 'Load more button label', 'team-free' ),
								'default'    => __( 'Load More', 'team-free' ),
								'dependency' => array( 'pagination_universal|universal_pagination_type', '==|==', 'true|pagination_btn' ),
							),
							array(
								'id'         => 'scroll_load_more_label',
								'type'       => 'text',
								'title'      => __( 'Scroll Load more button label', 'team-free' ),
								'default'    => __( 'Scroll to Load More', 'team-free' ),
								'dependency' => array( 'pagination_universal|universal_pagination_type', '==|==', 'true|pagination_scrl' ),
							),
							array(
								'id'       => 'pagination_color',
								'class'    => 'pagination_color',
								'type'     => 'color_group',
								'title'    => __( 'Pagination Color', 'team-free' ),
								'subtitle' => __( 'Set pagination color.', 'team-free' ),
								'options'  => array(
									'color'        => __( 'Color', 'team-free' ),
									'hover_color'  => __( 'Hover Color', 'team-free' ),
									'bg'           => __( 'Background', 'team-free' ),
									'hover_bg'     => __( 'Hover Background', 'team-free' ),
									'border'       => __( 'Border', 'team-free' ),
									'hover_border' => __( 'Hover Border', 'team-free' ),
								),
								'default'  => array(
									'color'        => '#5e5e5e',
									'hover_color'  => '#ffffff',
									'bg'           => '#ffffff',
									'hover_bg'     => '#63a37b',
									'border'       => '#dddddd',
									'hover_border' => '#63a37b',
								),
							),
						),
					), // End of the Pagination Settings Fieldset.
				),
			)
		);
	}
}
