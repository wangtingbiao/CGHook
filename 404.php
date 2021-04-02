<?php
/**
 * 404
 *
 * @package CGHook
 */

get_header();

?>
<div class="layout-info max-w-13">
	<main id="primary" class="layout-big post-one" role="main">
		<article id="post" class="post">
			<div class="site-404">
				<h2>
					<?php esc_html_e('404<br>找不到网页','text-cgh'); ?>
				</h2>
				<p>
					<?php esc_html_e('也许资源已转移，您可以尝试搜索','text-cgh'); ?>
				</p>
				<div class="max-w-13">
					<?php get_search_form(); ?>
				</div>
			</div>
			<!-- .site-404 end --> 
			
		</article>
	</main>
	<!-- #primary end --> 
	
</div>
<!-- .layout-info end -->

<?php get_footer(); ?>
