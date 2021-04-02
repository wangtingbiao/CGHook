<?php
/**
 * 全局侧边栏
 *
 * @link https://developer.wordpress.org/reference/functions/is_active_sidebar/
 *
 * @package CGHook
 */

if ( !is_active_sidebar( 'main-sidebar' ) ) {
	return;
}
?>
<aside id="secondary" class="layout-small sidebar" role="complementary">
	<?php if ( !is_active_sidebar( 'main-sidebar' ) ) {
	dynamic_sidebar( 'main-sidebar' );
} ?>
</aside>
<!-- #secondary end -->