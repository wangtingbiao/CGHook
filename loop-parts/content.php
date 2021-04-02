<?php
/**
 * 默认列表卡片
 *
 * @package CGHook
 */

$CGh_lists_category_open = get_theme_mod( 'CGh_lists_category_open', true );
$CGh_lists_excerpt_open = get_theme_mod( 'CGh_lists_excerpt_open', true );
$CGh_lists_link_open = get_theme_mod( 'CGh_lists_link_open', true );
$CGh_lists_link = get_theme_mod( 'CGh_lists_link', __( '阅读更多', 'text-cgh' ) );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'list-post' ); ?>>
	<figure class="entry-pic"><a href="<?php the_permalink(); ?>">
		<?php

		CGH_get_post_format();

		CGh_get_post_thumbnail();

		?>
		</a></figure>
	<!-- .entry-pic end -->
	
	<div class="entry-box">
		<?php if ( $CGh_lists_category_open ) : ?>
		<div class="entry-cat">
			<?php the_category( ' ', '' ); ?>
		</div>
		<?php endif; ?>
		<!-- .entry-cat end -->
		
		<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
		<!-- .entry-title end -->
		
		<div class="entry-meta">
			<?php CGh_get_post_meta(); ?>
		</div>
		<!-- .entry-meta end -->
		
		<?php if ( $CGh_lists_excerpt_open ) : the_excerpt(); endif; ?>
		<!-- .entry-excerpt end -->
		
		<?php if ( $CGh_lists_link_open && $CGh_lists_link ) : ?>
		<p class="entry-more"><a href="<?php the_permalink(); ?>"><?php echo $CGh_lists_link; ?></a></p>
		<?php endif; ?>
		<!-- .entry-more end --> 
		
	</div>
</article>
<!-- #post- end --> 
