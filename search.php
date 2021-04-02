<?php
/**
 * 自定义搜索页
 *
 * @package CGHook
 */

get_header();

CGh_get_sort();

?>
<div class="layout-info max-w-13">
	<main id="primary" class="layout-big post-<?php CGh_lists_columns(); ?>" role="main">
		<?php

		if ( have_posts() ):
			while ( have_posts() ): the_post();

		get_template_part( 'loop-parts/content', 'search' );

		endwhile;

		get_template_part( 'loop-parts/content', 'next' );

		else :

			get_template_part( 'loop-parts/content', 'none' );

		endif;

		?>
	</main>
	<!-- #primary end -->
	
</div>
<!-- .layout-info end -->

<?php get_footer(); ?>
