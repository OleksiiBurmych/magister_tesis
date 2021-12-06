<?php
/**
 * Dynamic css settings of WP_Team.
 *
 * @package WP_Team
 * @since 2.0.0
 */

// Main settings.
$sptp_settings   = get_option( '_sptp_settings' );
$sptp_custom_css = isset( $sptp_settings['custom_css'] ) ? $sptp_settings['custom_css'] : '';
$sptp_custom_js  = isset( $sptp_settings['custom_js'] ) ? $sptp_settings['custom_js'] : '';
$layout_preset   = isset( $layout['layout_preset'] ) ? $layout['layout_preset'] : 'carousel';

// Carousel settings.
$navigation_color  = isset( $settings['carousel_navigation_color'] ) ? $settings['carousel_navigation_color'] : false;
$navigation_border = isset( $settings['carousel_navigation_border'] ) ? $settings['carousel_navigation_border'] : false;

$navigation_border_css  = ( isset( $navigation_border['all'] ) ? $navigation_border['all'] : '0' ) . 'px ';
$navigation_border_css .= ( isset( $navigation_border['style'] ) ? $navigation_border['style'] : 'solid' ) . ' ';
$navigation_border_css .= ( isset( $navigation_border['color'] ) ) ? $navigation_border['color'] : '#63a37b';

$navigation_border_hover_color = ( isset( $navigation_border['hover_color'] ) ) ? $navigation_border['hover_color'] : '#63a37b';

$pagination_color = isset( $settings['carousel_pagination_color'] ) ? $settings['carousel_pagination_color'] : false;

// Display settings.
$section_title               = isset( $settings['style_title'] ) ? $settings['style_title'] : true;
$section_title_margin_bottom = isset( $settings['style_title_margin_bottom']['bottom'] ) && ! empty( $settings['style_title_margin_bottom']['bottom'] ) ? $settings['style_title_margin_bottom']['bottom'] . 'px' : '0px';
$margin_between_member       = isset( $settings['style_margin_between_member'] ) ? intval( $settings['style_margin_between_member']['all'] ) : 24;

if ( 'list' === $layout_preset ) {
	$position = isset( $settings['style_member_content_position_list'] ) ? $settings['style_member_content_position_list'] : '';
} else {
	$position = isset( $settings['style_member_content_position'] ) ? $settings['style_member_content_position'] : 'top_img_bottom_content';
}

$border_bg_around_member       = isset( $settings['border_bg_around_member'] ) ? intval( $settings['border_bg_around_member'] ) : '';
$border_bg_around_member_class = ( $border_bg_around_member ) ? 'border-bg-around-member' : '';

$border_around_member             = isset( $settings['border_bg_around_member']['border_around_member'] ) ? $settings['border_bg_around_member']['border_around_member'] : '';
$border_around_member_width       = ( ! empty( $border_around_member['all'] ) && ( $border_around_member['all'] > 0 ) ) ? intval( $border_around_member['all'] ) : 0;
$navigation_position_right        = ( 0 === $border_around_member_width ) ? 3 : ( ( 1 === $border_around_member_width ) ? 2 : ( ( 2 === $border_around_member_width ) ? 1 : 0 ) );
$border_around_member_style       = isset( $border_around_member['style'] ) ? $border_around_member['style'] : 'none';
$border_around_member_color       = isset( $border_around_member['color'] ) ? $border_around_member['color'] : 'transparent';
$border_around_member_hover_color = isset( $border_around_member['hover_color'] ) ? $border_around_member['hover_color'] : 'transparent';
$border_around_member_border      = $border_around_member_width . 'px ' . $border_around_member_style . ' ' . $border_around_member_color;
$border_radius_around_member      = isset( $settings['border_bg_around_member']['border_radius_around_member'] ) ? $settings['border_bg_around_member']['border_radius_around_member'] . 'px' : 0;
$background_around_member         = isset( $settings['border_bg_around_member']['bg_color_around_member'] ) ? $settings['border_bg_around_member']['bg_color_around_member'] : 'transparent';



$sptp_order_array     = array();
$sptp_order           = 1;
$default_style_arr    = array(
	'image_switch'        => true,
	'name_switch'         => true,
	'job_position_switch' => true,
	'social_switch'       => true,
);
$style_members        = isset( $settings['style_members'] ) ? $settings['style_members'] : $default_style_arr;
$show_member_name     = isset( $style_members['name_switch'] ) ? $style_members['name_switch'] : true;
$show_member_position = isset( $style_members['job_position_switch'] ) ? $style_members['job_position_switch'] : true;

$show_member_bio    = isset( $style_members['bio_switch'] ) ? $style_members['bio_switch'] : true;
$show_member_social = isset( $style_members['social_switch'] ) ? $style_members['social_switch'] : false;

// Social Icons.
$small_icon      = isset( $settings['icon_switch'] ) ? $settings['icon_switch'] : '';
$social_settings = isset( $settings['social_settings'] ) ? $settings['social_settings'] : '';
$social_position = isset( $social_settings['social_position'] ) ? $social_settings['social_position'] : 'center';

$social_margin      = isset( $social_settings['social_margin'] ) ? $social_settings['social_margin'] : '';
$social_margin_css  = '';
$social_margin_css .= ( ! empty( $social_margin['top'] ) ) ? $social_margin['top'] . 'px ' : ' 0 ';
$social_margin_css .= ( ! empty( $social_margin['right'] ) ) ? $social_margin['right'] . 'px ' : ' 0 ';
$social_margin_css .= ( ! empty( $social_margin['bottom'] ) ) ? $social_margin['bottom'] . 'px ' : ' 0 ';
$social_margin_css .= ( ! empty( $social_margin['left'] ) ) ? $social_margin['left'] . 'px ' : ' 0 ';

$social_icon_shape        = isset( $social_settings['social_icon_shape'] ) ? $social_settings['social_icon_shape'] : '';
$social_icon_custom_color = isset( $social_settings['social_icon_custom_color'] ) ? $social_settings['social_icon_custom_color'] : '';

$social_icon_color       = ! empty( $social_icon_custom_color ) && isset( $social_settings['icon_color_group'] ) ? $social_settings['icon_color_group'] : '';
$social_icon_main_color  = isset( $social_icon_color['icon_color'] ) ? $social_icon_color['icon_color'] : '';
$social_icon_hover_color = isset( $social_icon_color['icon_hover_color'] ) ? $social_icon_color['icon_hover_color'] : '';

$social_icon_bg_color       = ! empty( $social_icon_custom_color ) && isset( $social_settings['icon_bg_color_group'] ) ? $social_settings['icon_bg_color_group'] : '';
$social_icon_bg_main_color  = isset( $social_icon_bg_color['icon_bg'] ) ? $social_icon_bg_color['icon_bg'] : '';
$social_icon_bg_hover_color = isset( $social_icon_bg_color['icon_bg_hover'] ) ? $social_icon_bg_color['icon_bg_hover'] : '';

$social_icon_border       = ! empty( $social_icon_custom_color ) && isset( $social_settings['icon_border'] ) ? $social_settings['icon_border'] : '';
$social_icon_border_main  = '';
$social_icon_border_main .= ( ! empty( $social_icon_border['all'] ) ) ? $social_icon_border['all'] . 'px' : ' 0 ';
$social_icon_border_main .= ( ! empty( $social_icon_border['style'] ) ) ? ' ' . $social_icon_border['style'] : '';
$social_icon_border_main .= ( ! empty( $social_icon_border['color'] ) ) ? ' ' . $social_icon_border['color'] : '';
$social_icon_border_hover = ( ! empty( $social_icon_border['hover_color'] ) ) ? $social_icon_border['hover_color'] : '';


// Image settings.
$image_size = isset( $settings['image_size'] ) ? $settings['image_size'] : '';

$image_border = isset( $settings['border'] ) ? $settings['border'] : '';
if ( $image_border ) {
	$border  = '';
	$border .= ( $settings['border']['all'] > 0 ) ? $settings['border']['all'] . 'px ' : '0px ';
	$border .= ( '' !== $settings['border']['style'] ) ? $settings['border']['style'] . ' ' : ' ';
	$border .= ( '' !== $settings['border']['color'] ) ? $settings['border']['color'] : ' ';
} else {
	$border = 'none';
}
$border_hover = $image_border && isset( $settings['border']['hover_color'] ) ? $settings['border']['hover_color'] : 'inherit';

$image_bg = ( ( ! empty( $filter_members ) ) && isset( $settings['background'] ) ) ? $settings['background'] : '';

$link_detail    = isset( $settings['link_detail'] ) ? $settings['link_detail'] : true;
$page_link_type = ( isset( $settings['link_detail_fields']['page_link_type'] ) && $link_detail ) ? $settings['link_detail_fields']['page_link_type'] : '';

$team_title = isset( $settings['typo_team_title'] ) ? $settings['typo_team_title'] : '';

$team_title_color = isset( $team_title['color'] ) ? $team_title['color'] : '';
// Member Details.
$member_name              = isset( $settings['typo_member_name'] ) ? $settings['typo_member_name'] : '';
$member_name_color        = isset( $member_name['color'] ) ? $member_name['color'] : '';
$member_position          = isset( $settings['typo_member_position'] ) ? $settings['typo_member_position'] : true;
$member_position_color    = isset( $member_position['color'] ) ? $member_position['color'] : '';
$member_description       = isset( $settings['typo_desc_bio'] ) ? $settings['typo_desc_bio'] : true;
$member_description_color = isset( $member_description['color'] ) ? $member_description['color'] : '';
