<?php
/**
 * 页面
 *
 * @package CGHook
 */

get_header();

?>
<div class="layout-info max-w-13">
	<main id="primary" class="layout-big posts-no-widget" role="main">
		<?php

		if ( have_posts() ):
			while ( have_posts() ): the_post();

		?>
		<article id="post" class="sin-post">
			<header class="sin-header">
				<?php

				the_title( '<h3 class="sin-title">', '</h3>' );

				edit_post_link( esc_html__( '编辑', 'text-cgh' ), '<p>', '</p>' );

				?>
			</header>
			<div class="sin-content">
				<?php

				the_content();

				wp_link_pages( array(
					'before' => '<p class="post-nav-links">',
					'after' => '</p>',
				) );

				?>
			</div>
			<!-- .sin-content end -->
			
			<?php if ( comments_open() ): ?>
			<footer id="sin-comment-box" class="sin-footer">
				<?php comments_template(); ?>
			</footer>
			<?php endif; ?>
			<!-- #comments end --> 
			
		</article>
		<?php

		endwhile;
		endif;

		?>
	</main>
	<!-- #primary end --> 
	
</div>
<!-- .layout-info end -->

<?php get_footer(); ?>
