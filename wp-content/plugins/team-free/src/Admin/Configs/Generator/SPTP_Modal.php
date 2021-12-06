<?php
/**
 * Member Detail Settings tab.
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
 * This class is responsible for Member Detail tab in Team page.
 *
 * @since      2.0.0
 */
class SPTP_Modal {

	/**
	 * Member Detail Settings.
	 *
	 * @since 2.0.0
	 * @param string $prefix _sptp_generator.
	 */
	public static function section( $prefix ) {
		$single_page_link = admin_url( 'edit.php?post_type=sptp_member&page=team_settings#tab=single-page' );
		SPF_TEAM::createSection(
			$prefix,
			array(
				'title'  => __( 'Member Detail Settings', 'team-free' ),
				'icon'   => 'fa fa-id-card-o',
				'fields' => array(

					array(
						'type'       => 'switcher',
						'id'         => 'link_detail',
						'title'      => __( 'Link To Detail Page', 'team-free' ),
						'subtitle'   => __( 'Enable/Disable for linking member detail page.', 'team-free' ),
						'text_on'    => __( 'Enabled', 'team-free' ),
						'text_off'   => __( 'Disabled', 'team-free' ),
						'text_width' => 94,
						'default'    => true,
					),
					array(
						'id'         => 'link_detail_fields',
						'type'       => 'fieldset',
						'dependency' => array( 'link_detail', '==', 'true' ),
						'fields'     => array(
							array(
								'id'       => 'page_link_type',
								'class'    => 'sptp_page_link_type',
								'type'     => 'button_set',
								'title'    => __( 'Detail Page Link Type', 'team-free' ),
								'subtitle' => __( 'Choose member detail page type.', 'team-free' ),
								'options'  => array(
									'new_page' => __( 'Single Page', 'team-free' ),
									'modal'    => __( 'Modal', 'team-free' ),
									'drawer'   => __( 'Drawer', 'team-free' ),
								),
								'default'  => 'new_page',
								'inline'   => true,
							),
							array(
								'id'         => 'page_link_open',
								'type'       => 'radio',
								'title'      => __( 'Link Target', 'team-free' ),
								'options'    => array(
									'_blank' => __( 'New Tab', 'team-free' ),
									'_self'  => __( 'Current  Tab', 'team-free' ),
								),
								'default'    => '_blank',
								'dependency' => array( 'page_link_type', '==', 'new_page' ),
							),
							array(
								'id'      => 'nofollow_link',
								'type'    => 'checkbox',
								'title'   => __( 'Add rel="nofollow" to Link', 'team-free' ),
								'default' => false,
							),
							array(
								'type'    => 'notice',
								'style'   => 'success',
								'content' => __( 'To unlock the following modal settings, <a href="https://shapedplugin.com/plugin/wp-team-pro/?ref=1" target="_blank"><b>Upgrade to Pro!</b></a>', 'team-free' ),
							),
							array(
								'id'         => 'modal_type',
								'type'       => 'radio',
								'title'      => __( 'Modal Type', 'team-free' ),
								'attributes' => array( 'disabled' => 'disabled' ),
								'subtitle'   => __( 'Choose modal type.', 'team-free' ),
								'class'      => 'sptp_page_link_type_option',
								'options'    => array(
									'single'   => __( 'Single Member', 'team-free' ),
									'multiple' => __( 'Multiple Member with Navigation', 'team-free' ),
								),
								'default'    => 'multiple',
							),
							array(
								'id'         => 'modal_layout',
								'class'      => 'sptp_modal_layout',
								'type'       => 'image_select',
								'attributes' => array( 'disabled' => 'disabled' ),
								'title'      => __( 'Modal Layout', 'team-free' ),
								'subtitle'   => __( 'Choose a modal layout.', 'team-free' ),
								'options'    => array(
									'style-1' => array(
										'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/modal-classic.svg',
										'option_name' => __( 'Classic Modal', 'team-free' ),
										'pro_only'    => true,
									),
									'style-3' => array(
										'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/modal-left.svg',
										'option_name' => __( 'Slide-Ins Left', 'team-free' ),
										'pro_only'    => true,
									),
									'style-4' => array(
										'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/modal-center.svg',
										'option_name' => __( 'Slide-Ins Center', 'team-free' ),
										'pro_only'    => true,
									),
									'style-2' => array(
										'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/modal-right.svg',
										'option_name' => __( 'Slide-Ins Right', 'team-free' ),
										'pro_only'    => true,
									),
								),
							),
							array(
								'id'         => 'modal_background',
								'class'      => 'sptp_pro_only_field',
								'type'       => 'color',
								'attributes' => array( 'disabled' => 'disabled' ),
								'title'      => __( 'Modal Background', 'team-free' ),
								'subtitle'   => __( 'Set modal background.', 'team-free' ),
								'default'    => '#ffffff',
							),
							array(
								'type'    => 'subheading',
								'content' => __( 'Member Detail Fields', 'team-free' ),
							),
							// Member details page in single page link.
							array(
								'id'    => 'sptp_single_page_link',
								'class' => 'sptp_single_page_link',
								'type'  => 'none',
								'title' => __( '<a href="' . esc_url( $single_page_link ) . '">Explore More Settings For Single Page→</a>', 'team-free' ),
							),
						),
					),
				),
			)
		);
	}
}
