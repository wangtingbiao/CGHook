<?php
/**
 * 数字分页
 *
 * @package CGHook
 */

if ( $wp_query->max_num_pages > 1 ) {
	echo '<div class="prevnext">';

	echo paginate_links(
		array(
			'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
			'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
			'mid_size' => 1,
		)
	);

	echo '</div>';
}
?>
<!-- .prevnext end -->