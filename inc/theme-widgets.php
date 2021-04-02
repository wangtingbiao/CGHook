<?php
/**
 * 初始化主题小部件
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @package CGHook
 */

if ( !function_exists( 'CGh_widgets_init' ) ) {
	function CGh_widgets_init() {

		// 所有register_sidebar（）调用中使用的参数
		$shared_args = array(
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget' => '</div>',
		);

		// sidebar #1.
		register_sidebar(
			array_merge(
				$shared_args,
				array(
					'name' => __( '侧边小部件', 'text-cgh' ),
					'id' => 'main-sidebar',
				)
			)
		);

		// sidebar #2.
		register_sidebar(
			array_merge(
				$shared_args,
				array(
					'name' => __( '底部小部件', 'text-cgh' ),
					'id' => 'footer-sidebar',
				)
			)
		);

	}
	
}

add_action( 'widgets_init', 'CGh_widgets_init' );