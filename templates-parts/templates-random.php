<?php
/**
 * 随机文章
 *
 * @package CGHook
 */

$CGh_random_title = get_theme_mod( 'CGh_random_title', __( '猜你喜欢', 'text-cgh' ) );
$CGh_random_number = get_theme_mod( 'CGh_random_number', 3 );
$CGh_random_orderby = get_theme_mod( 'CGh_random_orderby', 'rand' );

?>
<div class="random">
	<?php if ( $CGh_random_title ): ?>
	<h2><?php echo esc_html( $CGh_random_title ); ?></h2>
	<?php endif; ?>
	<div class="max-w-13 post-three">
		<?php

		$random_query = array(
			'ignore_sticky_posts' => true,
			'posts_per_page' => esc_html( $CGh_random_number ),
			'orderby' => esc_html( $CGh_random_orderby ),
		);
		$randoms_query = new WP_Query( $random_query );

		if ( $randoms_query->have_posts() ):
			while ( $randoms_query->have_posts() ): $randoms_query->the_post();

		get_template_part( 'loop-parts/content', 'random' );

		endwhile;
		endif;
		wp_reset_postdata();

		?>
	</div>
</div>
<!-- .random end --> 
