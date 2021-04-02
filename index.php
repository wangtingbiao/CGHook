<?php
/**
 * 首页
 *
 * @package CGHook
 */

get_header();

CGh_get_swiper();

?>
<div class="layout-info max-w-13">
	<main id="primary" class="layout-big post-<?php CGh_lists_columns(); ?>" role="main">
		<?php

		if ( have_posts() ):
			while ( have_posts() ): the_post();

		get_template_part( 'loop-parts/content', get_post_format() );

		endwhile;

		get_template_part( 'loop-parts/content', 'next' );

		else :

			get_template_part( 'loop-parts/content', 'none' );

		endif;

		?>
	</main>
	<!-- #primary end -->
	
	<?php CGh_get_sidebar(); ?>
</div>
<!-- .layout-info end -->

<?php

CGh_get_random();

get_footer();

?>
