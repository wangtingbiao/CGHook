<?php
/**
 * 文章页
 *
 * @package CGHook
 */

get_header();

$CGh_posts_sidebar_open = get_theme_mod( 'CGh_posts_sidebar_open', true );
$CGh_posts_comment_open = get_theme_mod( 'CGh_posts_comment_open', true );
$CGh_posts_like_open = get_theme_mod( 'CGh_posts_like_open', true );
$CGh_posts_reward_open = get_theme_mod( 'CGh_posts_reward_open', false );
$CGh_posts_reward = get_theme_mod( 'CGh_posts_reward', '' );
$CGh_posts_share_open = get_theme_mod( 'CGh_posts_share_open', true );
$CGh_posts_share = get_theme_mod( 'CGh_posts_share', 'weibo,qq,wechat,tencent,qzone' );
$CGh_posts_tag_open = get_theme_mod( 'CGh_posts_tag_open', true );
$CGh_posts_prevnext_open = get_theme_mod( 'CGh_posts_prevnext_open', true );

?>
<div class="layout-info max-w-13">
	<main id="primary" class="layout-big<?php if ( $CGh_posts_sidebar_open == false ): echo' posts-no-widget'; endif; ?>" role="main">
		<?php

		if ( have_posts() ):
			while ( have_posts() ): the_post();

		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'sin-post' ); ?>>
			<header class="sin-header">
				<?php

				the_title( '<h3 class="sin-title">', '</h3>' );

				edit_post_link( esc_html__( '编辑', 'text-cgh' ), '<p>', '</p>' );

				?>
				<div class="sin-meta">
					<?php CGh_get_post_meta(); ?>
				</div>
			</header>
			<div class="sin-content">
				<?php

				the_content();

				wp_link_pages( array(
					'before' => '<p class="prevnext">',
					'after' => '</p>',
				) );

				?>
			</div>
			<!-- .sin-content end -->
			
			<div id="sin-fixed" class="sin-fixed">
				<?php if ( $CGh_posts_comment_open ) : ?>
				<a id="sin-comment-btn" class="sin-comment-btn"><i class="fa fa-comments"></i><span><?php echo get_comments_number(); ?></span></a>
				<?php endif; ?>
				<!-- #sin-comment-btn end -->
				
				<?php if ( $CGh_posts_like_open ) : ?>
				<a id="sin-like-btn" class="sin-like-btn<?php if(isset($_COOKIE['CGh_ding_'.$post->ID])) echo ' done'; ?>" οnclick="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>"><i class="fa<?php if(isset($_COOKIE['CGh_ding_'.$post->ID])):echo ' fa-heart'; else: echo' fa-heart-o';endif; ?>"></i>
				<p>
					<?php esc_html_e( '喜欢', 'text-cgh' );?>
				</p>
				<span class="count">
				<?php if ( get_post_meta( $post->ID, 'CGh_ding', true ) ): echo get_post_meta( $post->ID, 'CGh_ding', true ); else: echo'0'; endif; ?>
				</span></a>
				<?php endif; ?>
				<!-- #sin-like-btn end -->
				
				<?php if ( $CGh_posts_reward_open && $CGh_posts_reward) :?>
				<a href="#sin-reward-btn" class="sin-reward-btn"><i class="fa fa-cny"></i>
				<p>
					<?php esc_html_e( '赞赏', 'text-cgh' );?>
				</p>
				</a>
				<div id="sin-reward-btn" class="reward-box modal"><img src="<?php echo $CGh_posts_reward; ?>" alt=""></div>
				<?php endif;?>
				<!-- #sin-reward-btn end -->
				
				<?php if ( $CGh_posts_share_open ) : ?>
				<a href="#sin-share-btn" class="sin-share-btn"><i class="fa fa-share"></i>
				<p>
					<?php esc_html_e( '分享', 'text-cgh' );?>
				</p>
				</a>
				<div id="sin-share-btn" class="share-box modal share-component" data-sites="<?php echo $CGh_posts_share; ?>"></div>
				<?php endif; ?>
				<!-- #sin-share-btn end --> 
				
				<a id="sin-plus-btn" class="sin-plus-btn"><i class="fa fa-plus"></i></a> 
				<!-- #sin-plus-btn end --> 
				
			</div>
			<?php
			if ( $CGh_posts_tag_open ) {
				the_tags( '<div class="sin-tag"><i class="fa fa-tags" aria-hidden="true"></i> ', ' ', '</div>' );
			}
			?>
			<!-- .sin-tag end -->
			
			<?php if ( $CGh_posts_prevnext_open ): ?>
			<div class="sin-prevnext">
				<?php

				previous_post_link( '<p class="sin-prev"><i class="fa fa-arrow-left"></i> %link </p>', ' %title', true );
				next_post_link( '<p class="sin-next"> %link <i class="fa fa-arrow-right"></i></p>', '%title', true );

				?>
			</div>
			<?php endif; ?>
			<!-- .sin-prevnext end -->
			
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
	
	<?php CGh_get_sidebar(); ?>
</div>
<!-- .layout-info end -->

<?php

CGh_get_random();

get_footer();

?>
