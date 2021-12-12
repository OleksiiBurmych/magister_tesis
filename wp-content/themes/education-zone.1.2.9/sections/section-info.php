<?php
/**
 * Info Section
 */
?>
<div class="container">
    <ul class="thumb-text">
        <?php
        $post_one   = get_theme_mod( 'education_zone_info_one_post' );
        $post_two   = get_theme_mod( 'education_zone_info_second_post' );
        $post_three = get_theme_mod( 'education_zone_info_third_post' );
        $post_four  = get_theme_mod( 'education_zone_info_fourth_post' );

        $info_posts = array( $post_one, $post_two, $post_three, $post_four );
        $info_posts = array_diff( array_unique( $info_posts ), array('') );

        $args = array(
            'post__in'   => $info_posts,
            'orderby'   => 'post__in',
            'ignore_sticky_posts' => true
        );

        $info_qry = new WP_Query( $args );

        if( $info_posts && $info_qry->have_posts() ){
            $i = 1;
            while( $info_qry->have_posts() ){
                $info_qry->the_post();?>
                <li>
                    <div class="box-<?php echo esc_attr( $i );?>">
                        <?php if( has_post_thumbnail() ){ ?>
                            <span><?php the_post_thumbnail(); ?></span>
                        <?php } ?>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php the_excerpt(); ?>
                    </div>
                </li>
                <?php
                $i++;
            }
            wp_reset_postdata();
        }
        ?>
        <li>
            <div class="box-<?php echo esc_attr( $i );?>">
                <span><img width="38" height="43" src="http://grand.loc/wp-content/uploads/2021/12/testimonial-icon4.png" data-lazy-type="image" data-src="http://grand.loc/wp-content/uploads/2021/12/testimonial-icon4.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image lazy-loaded" alt="" loading="lazy"><noscript><img width="38" height="43" src="http://grand.loc/wp-content/uploads/2021/12/testimonial-icon4.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy" /></noscript></span>
                <h3><a href="http://grand.loc/?cat=18">Останні новини університету</a></h3>
                <p>Тут ви зможете дізнатися про останні новини факультетут. Приклад тексту</p>
            </div>
        </li>
    </ul>
</div>

