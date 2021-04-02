<?php
/**
 * 显示评论和评论表单
 * 
 * @package CGHook
 */

if ( post_password_required() ) {
	return;
}

if ( $comments ) {
	if ( have_comments() ) {
		?>
		<div id="comments" class="comments">
			<h2 class="comment-reply-title">
				<?php

				$comments_number = absint( get_comments_number() );

				if ( have_comments() ) {

					esc_html_e( '发表评论', 'text-cgh' );

				} elseif ( 1 === $comments_number ) {

					esc_html_e( '1 评论', 'text-cgh' );

				} else {

					esc_html_e( $comments_number, ' 评论', 'text-cgh' );

				}

				?>
			</h2>
			<?php

			wp_list_comments(
				array(
					'walker' => new Ch_Walker_Comment(),
					'avatar_size' => 60,
					'style' => 'div',
				)
			);
		
			echo '<div class="prevnext">';

			paginate_comments_links(
				array(
					'next_text' => esc_html__( '新', 'text-cgh' ) . ' <i class="fa fa-angle-right" aria-hidden="true"></i>',
					'prev_text' => '<i class="fa fa-angle-left" aria-hidden="true"></i> ' . esc_html__( '旧', 'text-cgh' ),
				)
			);
		
			echo '</div>';

			?>
		</div>
		<!-- #comments list end -->

	<?php
	}
}
if ( comments_open() || pings_open() ) {
	
	$comment_reply = __( '点评一下', 'text-cgh');
	//$comment_reply_to = __( '盘他', 'text-cgh');
	
	$comment_author = __( '名称*', 'text-cgh');
	$comment_email = __( '电子邮件*', 'text-cgh');
	$comment_url = __( '网址', 'text-cgh');
	$comment_body = __( '你熬夜有什么用，又没人陪你聊天，早点休息吧！(๑•̀ㅂ•́)و✧', 'text-cgh');
	$comment_send = __( '点评一下', 'text-cgh');
	$comment_cancel = __( '不评了', 'text-cgh');

	// Array
	$comments_args = array(
		
		'fields' => array(
			'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . esc_html( $comment_author ) . '" aria-required="true"></p>',
			'email' => '<p class="comment-form-email"><input id="email" name="email" type="email" placeholder="' . esc_html( $comment_email ) . '" aria-required="true"></p>',
			'url' => '<p class="comment-form-url"><input id="url" name="url" type="url" placeholder="' . esc_html( $comment_url ) . '"></p>',
		),
		
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" rows="4" placeholder="' . esc_html( $comment_body ) . '" aria-required="true"></textarea></p>',
		
		'title_reply' => esc_html( $comment_reply ),
		
		//'title_reply_to' => esc_html( $comment_reply_to ),
		
		'cancel_reply_link' => esc_html( $comment_cancel ),

		'label_submit' => esc_html( $comment_send ),
		
	);
	comment_form( $comments_args );

} else {
	?>
	<div class="comment-respond" id="respond">
		<p class="comments-closed">
			<?php esc_html_e('评论被关闭', 'text-cgh'); ?>
		</p>
	</div>
<?php
}
