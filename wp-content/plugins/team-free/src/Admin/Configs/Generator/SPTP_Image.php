<?php
/**
 * Image tab.
 *
 * @since      2.0.0
 * @version    2.0.0
 *
 * @package    WP_Team
 * @subpackage WP_Team/admin
 */

namespace ShapedPlugin\WPTeam\Admin\Configs\Generator;

use ShapedPlugin\WPTeam\Admin\Framework\Classes\SPF_TEAM;
// Cannot access directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * This class is responsible for Image tab in Team page.
 *
 * @since      2.0.0
 */
class SPTP_Image {

	/**
	 * SPTP_Image class for setting image in Admin->Team Pro->Team Generator Page.
	 * Here, this class is responsible for image settings tab.
	 *
	 * @since 2.0.0
	 * @param string $prefix _sptp_generator.
	 */
	public static function section( $prefix ) {
		SPF_TEAM::createSection(
			$prefix,
			array(
				'title'  => __( 'Image Settings', 'team-free' ),
				'icon'   => 'fa fa-image',
				'fields' => array(
					array(
						'id'         => 'image_on_off',
						'type'       => 'switcher',
						'title'      => __( 'Photo/Image', 'team-free' ),
						'subtitle'   => __( 'Show/Hide member photo or image.', 'team-free' ),
						'text_on'    => __( 'Show', 'team-free' ),
						'text_off'   => __( 'Hide', 'team-free' ),
						'text_width' => 75,
						'default'    => true,
					),
					array(
						'id'         => 'image_size',
						'class'      => 'sptp_image_size',
						'type'       => 'select',
						'title'      => __( 'Image Sizes', 'team-free' ),
						'subtitle'   => __( 'Set member image size.', 'team-free' ),
						'options'    => 'img_sizes',
						'default'    => 'original',
						'dependency' => array( 'image_on_off', '==', 'true' ),
					),
					array(
						'id'         => 'image_shape',
						'class'      => 'sptp_image_shape',
						'type'       => 'image_select',
						'title'      => __( 'Image Shape', 'team-free' ),
						'subtitle'   => __( 'Choose an image shape for member.', 'team-free' ),
						'options'    => array(
							'sptp-square'  => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/square.svg',
								'option_name' => __( 'Square', 'team-free' ),
							),
							'sptp-rounded' => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/rounded.svg',
								'option_name' => __( 'Rounded', 'team-free' ),
								'pro_only'    => true,
							),
							'sptp-circle'  => array(
								'image'       => SPT_PLUGIN_ROOT . 'src/Admin/img/circle.svg',
								'option_name' => __( 'Circle', 'team-free' ),
								'pro_only'    => true,
							),
						),
						'default'    => 'sptp-square',
						'dependency' => array( 'image_on_off', '==', 'true' ),
					),
					array(
						'id'       => 'border',
						'type'     => 'border',
						'title'    => __( 'Border', 'team-free' ),
						'subtitle' => __( 'Set border.', 'team-free' ),
						'all'      => true,
						'default'  => array(
							'style' => 'none',
						),
					),
					array(
						'id'         => 'background',
						'type'       => 'color',
						'title'      => __( 'Background', 'team-free' ),
						'subtitle'   => __( 'Set background for member image.', 'team-free' ),
						'default'    => '#FFFFFF',
						'dependency' => array( 'image_on_off', '==', 'true' ),
					),
					array(
						'id'         => 'image_zoom',
						'type'       => 'select',
						'title'      => __( 'Zoom', 'team-free' ),
						'subtitle'   => __( 'Select a zoom effect for image.', 'team-free' ),
						'options'    => array(
							'none'     => __( 'None', 'team-free' ),
							'zoom_in'  => __( 'Zoom In', 'team-free' ),
							'zoom_out' => __( 'Zoom Out', 'team-free' ),
						),
						'default'    => 'none',
						'dependency' => array( 'image_on_off', '==', 'true' ),
					),
					array(
						'id'         => 'image_grayscale',
						'class'      => 'sptp_image_grayscale',
						'type'       => 'select',
						'title'      => __( 'Image Mode', 'team-free' ),
						'subtitle'   => __( 'Select a mode for the image.', 'team-free' ),
						'options'    => array(
							'none'            => __( 'Normal', 'team-free' ),
							'normal_on_hover' => __( 'Grayscale and normal on hover (Pro)', 'team-free' ),
							'on_hover'        => __( 'Grayscale on Hover (Pro)', 'team-free' ),
							'always'          => __( 'Always grayscale (Pro)', 'team-free' ),
						),
						'default'    => 'none',
						'dependency' => array( 'image_on_off', '==', 'true' ),
					),
				),
			)
		);
	}
}
