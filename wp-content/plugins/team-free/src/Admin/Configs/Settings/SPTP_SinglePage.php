<?php
/**
 * Rename section in settings page.
 *
 * @since      2.0.0
 * @version    2.0.0
 *
 * @package    WP_Team
 * @subpackage WP_Team/admin
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

namespace ShapedPlugin\WPTeam\Admin\Configs\Settings;

use ShapedPlugin\WPTeam\Admin\Framework\Classes\SPF_TEAM;
// Cannot access directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * This class is responsible for Rename in Settings page.
 *
 * @since      2.0.0
 */
class SPTP_SinglePage {

	/**
	 * Rename settings.
	 *
	 * @since 2.0.0
	 * @param string $prefix _sptp_settings.
	 */
	public static function section( $prefix ) {
		SPF_TEAM::createSection(
			$prefix,
			array(
				'id'     => 'single_page',
				'title'  => __( 'Single Page', 'team-free' ),
				'icon'   => 'fa fa-id-card-o',
				'fields' => array(
					array(
						'id'       => 'detail_page_fields',
						'type'     => 'checkbox',
						'title'    => __( 'Member Detail Fields Selection', 'team-free' ),
						'title_help' => __( 'Check the field(s) to show on detail page.', 'team-free' ),
						'class'    => 'detail_page_options',
						'options'  => array(
							'img'             => __( 'Photo/Image', 'team-free' ),
							'name'            => __( 'Member Name', 'team-free' ),
							'position'        => __( 'Position/Job Title', 'team-free' ),
							'desc'            => __( 'Description', 'team-free' ),
							'social_profiles' => __( 'Social Profiles', 'team-free' ),
						),
						'default'  => array( 'name', 'desc', 'img', 'position', 'social_profiles' ),
					),
				),
			)
		);
	}
}
