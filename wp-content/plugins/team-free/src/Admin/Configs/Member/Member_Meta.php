<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://shapedplugin.com
 * @since      2.0.0
 *
 * @package    WP_Team
 * @subpackage WP_Team/admin/partials
 */

namespace ShapedPlugin\WPTeam\Admin\Configs\Member;

use ShapedPlugin\WPTeam\Admin\Framework\Classes\SPF_TEAM;
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Member meta class
 */
class Member_Meta {

	/**
	 * Create Metabox function
	 *
	 * @param object $post_type post type.
	 * @param string $prefix metabox prefix.
	 * @param string $name metabox option name.
	 * @return void
	 */
	public static function metaboxes( $post_type, $prefix, $name ) {
		SPF_TEAM::createMetabox(
			$prefix,
			array(
				'title'     => __( 'Member Details', 'team-free' ),
				'post_type' => $post_type,
				'priority'  => 'high',
				'class'     => '_sptp_member_metabox',
			)
		);

		SPF_TEAM::createSection(
			$prefix,
			array(
				'fields' => array(
					array(
						'type'    => 'subheading',
						/* translators: %s is replaced with 'Member' */
						'content' => wp_sprintf( __( '%s DETAILS', 'team-free' ), strtoupper( $name ) ),
					),
					array(
						'id'    => 'sptp_job_title',
						'type'  => 'text',
						'title' => __( 'Position/Job Title', 'team-free' ),
					),
					array(
						'id'     => 'sptp_short_bio',
						'type'   => 'textarea',
						'title'  => __( 'Short Bio', 'team-free' ),
						'help'   => __( 'Member short bio is fine in 100 characters or less. Short & detail bio text fields are HTML supported.', 'team-free' ),
						'height' => '125px',
					),
					array(
						'type'    => 'subheading',
						'content' => wp_sprintf( '%s SOCIAL PROFILES', strtoupper( $name ) ),
					),
					array(
						'id'       => 'sptp_member_social',
						'type'     => 'repeater',
						'title'    => 'Social Icon',
						'class'    => 'sptp-inline-repeater-social',
						'sort'     => true,
						'clone'    => false,
						'remove'   => true,
						'fields'   => array(

							array(
								'id'          => 'social_group',
								'type'        => 'select',
								'options'     => array(
									'facebook'    => 'Facebook',
									'twitter'     => 'Twitter',
									'linkedin'    => 'LinkedIn',
									'pinterest-p' => 'Pinterest',
									'youtube'     => 'Youtube',
									'instagram'   => 'Instagram',
									'medium'      => 'Medium',
									'codepen'     => 'Codepen',
								),
								'placeholder' => 'Select',
								'class'       => 'sptp-repeater-select',
							),
							array(
								'id'    => 'social_link',
								'type'  => 'text',
								'class' => 'sptp-repeater-text',
							),
						),
						'default'  => array(
							array(),
						),
						'validate' => 'spf_validate_social',
					),

					array(
						'type'    => 'subheading',
						'class'   => 'sptp_pro_heading',
						'content' => __( 'ADDITIONAL INFORMATION (PRO)', 'team-free' ),
					),
					array(
						'type'    => 'notice',
						'style'   => 'success',
						'content' => __( 'To unlock the Member Additional Information fields, Skills, and Photo Gallery, <a href="https://shapedplugin.com/plugin/wp-team-pro/?ref=1"><b>Upgrade To Pro!</b></a>', 'team-free' ),
					),
					array(
						'id'         => 'sptp_email',
						'class'      => 'sptp_pro_only_field',
						'attributes' => array( 'disabled' => 'disabled' ),
						'type'       => 'text',
						'title'      => __( 'Email Address', 'team-free' ),
					),
					array(
						'id'         => 'sptp_mobile',
						'class'      => 'sptp_pro_only_field',
						'attributes' => array( 'disabled' => 'disabled' ),
						'type'       => 'text',
						'title'      => __( 'Mobile (personal)', 'team-free' ),
					),
					array(
						'id'         => 'sptp_phone',
						'class'      => 'sptp_pro_only_field',
						'attributes' => array( 'disabled' => 'disabled' ),
						'type'       => 'text',
						'title'      => __( 'Telephone (office)', 'team-free' ),
					),
					array(
						'id'         => 'sptp_location',
						'class'      => 'sptp_pro_only_field',
						'attributes' => array( 'disabled' => 'disabled' ),
						'type'       => 'text',
						'title'      => __( 'Location', 'team-free' ),
					),
					array(
						'id'         => 'sptp_website',
						'class'      => 'sptp_pro_only_field',
						'attributes' => array( 'disabled' => 'disabled' ),
						'type'       => 'text',
						'title'      => __( 'Website', 'team-free' ),
					),
					array(
						'id'         => 'sptp_user_profile',
						'attributes' => array( 'disabled' => 'disabled' ),
						'type'       => 'select',
						'title'      => __( 'User/Author Profile', 'team-free' ),
						'help'       => __( 'If this member is associated with a account, select it here. Might be used to fetch latest published posts in the single member page.', 'team-free' ),
						'options'    => 'users',
						'default'    => 'Select',
						'class'      => 'spf-after sptp_pro_only_field',
					),
					array(
						'type'    => 'subheading',
						'class'   => 'sptp_pro_heading',
						'content' => wp_sprintf( '%s SKILLS (PRO)', strtoupper( $name ) ),
					),
					array(
						'id'         => 'sptp_skills',
						'class'      => 'sptp_pro_only_field',
						'attributes' => array( 'disabled' => 'disabled' ),
						'type'       => 'repeater',
						'title'      => __( 'Skill Label', 'team-free' ),
						'class'      => 'inline-repeater-skill sptp_pro_only_field',
						'sort'       => false,
						'clone'      => false,
						'remove'     => false,
						'fields'     => array(
							array(
								'id'          => 'sptp_skill_name',
								'type'        => 'text',
								'attributes'  => array( 'disabled' => 'disabled' ),
								'placeholder' => __( 'e.g. Python', 'team-free' ),
								'class'       => 'sptp-repeater-text',
							),
							array(
								'id'         => 'sptp_skill_percentage',
								'type'       => 'spinner',
								'attributes' => array( 'disabled' => 'disabled' ),
								'unit'       => '%',
								'class'      => 'sptp-repeater-select',
							),
						),
						'default'    => array(
							array(),
						),
					),
					array(
						'type'    => 'subheading',
						'class'   => 'sptp_pro_heading',
						'content' => wp_sprintf( '%s PHOTO GALLERY (PRO)', strtoupper( $name ) ),
					),
					array(
						'id'          => 'member_image_gallery',
						'class'       => 'sptp_pro_only_field',
						'attributes'  => array( 'disabled' => 'disabled' ),
						'type'        => 'gallery',
						'title'       => __( 'Gallery Images', 'team-free' ),
						'add_title'   => __( 'Add Image(s)', 'team-free' ),
						'edit_title'  => __( 'Edit Images', 'team-free' ),
						'clear_title' => __( 'Remove Images', 'team-free' ),
					),
				),
			)
		);
	}
}
