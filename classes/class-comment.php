<?php
/**
 * 主题自定义评论列表
 *
 * @package CGHook
 */

/**
 * 当前评论是否文章作者
 */
function get_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		
		if ( !empty( $user ) && !empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * 回复评论自动添加@
 */
function get_comment_add_at( $comment_text, $comment = '' ) {
	if ( $comment->comment_parent > 0 ) {
		$comment_text = '<em>@' . get_comment_author( $comment->comment_parent ) . '</em> ' . $comment_text;
	}
	return $comment_text;
}

add_filter( 'comment_text', 'get_comment_add_at', 20, 2 );

/**
 * 评论列表
 */
if ( ! class_exists( 'Ch_Walker_Comment' ) ) {
	
	class Ch_Walker_Comment extends Walker_Comment {
		
		protected function html5_comment( $comment, $depth, $args ) {
			
			$tag = ( 'div' === $args[ 'style' ] ) ? 'div' : 'li';
			?>

			<<?php echo $tag; ?> id="comment-<?php comment_ID() ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>

				<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
					<header class="comment-author">
						<?php

						$comment_author_url = get_comment_author_url( $comment );
						$comment_author     = get_comment_author( $comment );
						$avatar             = get_avatar( $comment, $args['avatar_size'] );

						if ( 0 !== $args['avatar_size'] ) {

							if ( empty( $comment_author_url ) ) {
								echo wp_kses_post( $avatar );
							} else {
								printf( '<a href="%s" rel="external nofollow" class="url">', esc_url( $comment_author_url ) );
								echo wp_kses_post( $avatar );
							}

						}

						printf('<strong class="fn">%1$s</strong>',esc_html( $comment_author ));

						if ( ! empty( $comment_author_url ) ) {
							echo '</a>';
						}

						?>
					</header>
					<div class="comment-right">
						<div class="comment-matedata">

							<?php
			
							$by_post_author = get_comment_by_post_author( $comment );
			
							if ( $by_post_author ) {
								echo'<span class="by-post-author">' . esc_html__( '作者', 'text-cgh' ) . '</span>';
							}
							?>
							
							<?php $comment_timestamp = sprintf( __( '%1$s %2$s', 'text-cgh' ), get_comment_date( '', $comment ), get_comment_time() ); ?>
							<time datetime="<?php comment_time( 'c' ); ?>" title="<?php echo esc_attr( $comment_timestamp ); ?>">
								<?php echo esc_html( $comment_timestamp ); ?>
							</time>							

							<?php
			
							if ( current_user_can( 'edit_comment' ) ) {
								edit_comment_link();
							}

							?>
						</div>
						<div class="comment-content">
							<?php

							comment_text();

							if ( '0' === $comment->comment_approved ) {
								echo'<p class="comment-awaiting-moderation">' . esc_html__( '您的评论正在等待审核', 'text-cgh' ) . '</p>';
							} 

							?>

						</div><!-- .comment-content -->
						<?php

							$comment_reply_link = get_comment_reply_link(
								array_merge($args,
									array(
										'add_below' => 'div-comment',
										'depth'     => $depth,
										'max_depth' => $args['max_depth'],
										'before'    => '<div class="comment-reply">',
										'after'     => '</div>',
									)
								)
							);

							if ( $comment_reply_link ) {
								echo $comment_reply_link;
							}

						?>
					</div>
				</article><!-- .comment-body -->

		<?php
		}
	}
}