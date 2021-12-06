<?php
/**
 * Single view template for member.
 *
 * @package team-free
 * @subpackage team-free\Frontend\templates
 * @since 2.1.0
 */

get_header();
// Start the loop.
while ( have_posts() ) :
	the_post();
	$member_info   = get_post_meta( get_the_ID(), '_sptp_add_member', true );
	$sptp_settings = get_option( '_sptp_settings' );

	$show_name            = true;
	$show_img             = true;
	$show_desc            = true;
	$show_position        = true;
	$show_social_profiles = true;
	if ( isset( $sptp_settings['detail_page_fields'] ) ) {
		$detail_fields        = $sptp_settings['detail_page_fields'];
		$show_name            = in_array( 'name', $detail_fields, true );
		$show_img             = in_array( 'img', $detail_fields, true );
		$show_desc            = in_array( 'desc', $detail_fields, true );
		$show_position        = in_array( 'position', $detail_fields, true );
		$show_social_profiles = in_array( 'social_profiles', $detail_fields, true );
	}
	?>
	<div id="post-sptp-<?php the_ID(); ?>" <?php post_class( 'sptp-single-post' ); ?>>
	<div class="sptp-list-style">
	<?php if ( $show_img && has_post_thumbnail() ) { ?>
		<div class="sptp-member-avatar-area">
			<?php
				the_post_thumbnail();
			?>
		</div><!-- .post-thumbnail -->
	<?php } ?>
	<div class="sptp-info">
	<?php if ( $show_name ) { ?>
		<div class="sptp-member-name">
			<h2 class="sptp-member-name-title"><?php the_title(); ?> </h2>
		</div>
		<?php
	} if ( $show_position ) {
		$member_job_title = isset( $member_info['sptp_job_title'] ) ? $member_info['sptp_job_title'] : '';
		if ( $member_job_title ) {
			?>
			<div class="sptp-member-profession">
				<h4 class="sptp-jop-title"><?php echo esc_html( $member_info['sptp_job_title'] ); ?></h4>
			</div>
			<?php
		}
	} if ( $show_social_profiles ) {
		$member_socials = isset( $member_info['sptp_member_social'] ) ? $member_info['sptp_member_social'] : 0;
		if ( $member_socials ) {
			?>
			<div class="sptp-member-social rounded">
				<ul>
				<?php
				foreach ( $member_socials as $social ) :
					if ( $social['social_group'] ) :
						$social_link = $social['social_link'];
						if ( preg_match( '#^https?://#i', $social_link ) ) {
							$social_link = $social_link;
						} else {
							$social_link = 'http://' . $social_link;
						}
						?>
					<li>
						<a class="<?php echo 'sptp-' . esc_html( $social['social_group'] ); ?>" href="<?php echo esc_html( $social_link ); ?>" target="_blank">
						<i class="<?php echo 'fa fa-' . esc_html( $social['social_group'] ); ?>"></i>
						</a>
					</li>
						<?php
					endif;
				endforeach;
				?>
				</ul>
			</div>
			<?php
		}
	}
	?>
		</div>
	</div>
	<?php if ( $show_desc ) { ?>
		<div class="sptp-content">
			<?php the_content(); ?>
		</div>
	<?php } ?>
</div>
	<?php
	endwhile;
get_footer();
