<?php
/**
 * 随机列表卡片
 *
 * @package CGHook
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('list-post'); ?>>
	<figure class="entry-pic"> <a href="<?php the_permalink(); ?>">
		<?php

		CGH_get_post_format();
		
		CGh_get_post_thumbnail();

		?>
		</a> </figure>
	<!-- .entry-pic end -->
	
	<div class="entry-box">
		<div class="entry-cat">
			<?php the_category( ' ', '' ); ?>
		</div>
		<!-- .entry-cat end -->
		
		<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
		<!-- .entry-title end -->
		
		<div class="entry-meta">
			<time class="em-date" datetime="<?php the_time( 'Y-m-d A G:i:s' ); ?>"><i class="fa fa-calendar" aria-hidden="true"></i>
				<?php the_time( 'Fj,Y' ); ?>
			</time>
			<!-- .em-date end --> 
			
			<span class="em-read"><i class="fa fa-clock-o" aria-hidden="true"></i>
			<?php CGh_get_reading_time(); ?>
			</span> 
			<!-- .entry-read end --> 
			
		</div>
		<!-- .entry-meta end --> 
		
	</div>
</article>
<!-- #post- end -->