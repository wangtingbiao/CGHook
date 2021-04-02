<?php
/**
 * 自定义搜索框
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package CGHook
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x('GO &hellip;', 'placeholder', 'text-cgh'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x('GO', 'submit button', 'text-cgh'); ?>" />
</form>
<!-- .search-form end -->