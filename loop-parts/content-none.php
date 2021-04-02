<?php
/**
 * 无内容列表卡片
 *
 * @package CGHook
 */
?>
<article <?php post_class('list-post'); ?>>
	<?php
	if ( is_search() ) {
		esc_html_e( '好尴尬，尝试换一个词搜索', 'text-cgh' );
	} else {
		esc_html_e( '好尴尬，没有了', 'text-cgh' );
	}
	?>
</article>
<!-- no post end -->