<?php
/**
 * 加载主题的JavaScript和CSS源
 *
 * @link https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
 *
 * @package CGHook
 */

if ( !function_exists( 'CGh_scripts' ) ) {
	function CGh_scripts() {

		$theme_version = wp_get_theme()->get( 'Version' );
		$CGh_swiper_open = get_theme_mod( 'CGh_swiper_open', false );
		$CGh_posts_share_open = get_theme_mod( 'CGh_posts_share_open', true );

		// 主要样式
		wp_enqueue_style( 'style', get_stylesheet_uri(), array(), $theme_version );

		// 统一浏览器样式
		wp_enqueue_style( 'normalize-min', get_template_directory_uri() . '/assets/css/normalize.min.css', null, $theme_version );

		// 字体图标
		wp_enqueue_style( 'font-awesome-min', get_template_directory_uri() . '/assets/css/font-awesome.min.css', null, $theme_version );

		// JQuery
		wp_enqueue_script( 'jquery-min', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), $theme_version, false );

		// JQuery-UI
		wp_enqueue_script( 'jquery-ui-min', get_template_directory_uri() . '/assets/js/jquery-ui.min.js', array(), $theme_version, true );

		// 轮播图
		if ( is_home() ) {
			if ( $CGh_swiper_open ) {
				wp_enqueue_style( 'swiper-min', get_template_directory_uri() . '/assets/css/swiper.min.css', null, $theme_version );
				wp_enqueue_script( 'swiper-min', get_template_directory_uri() . '/assets/js/swiper.min.js', array(), $theme_version, false );
			}
		}

		// 文章页
		if ( is_singular( 'post' ) ) {

			// 分享
			if ( $CGh_posts_share_open ) {
				wp_enqueue_style( 'share-min', get_template_directory_uri() . '/assets/css/share.min.css', null, $theme_version );
				wp_enqueue_script( 'share-min', get_template_directory_uri() . '/assets/js/share.min.js', array(), $theme_version, true );
			}

			// 文章页自定义
			wp_enqueue_script( 'archive', get_template_directory_uri() . '/assets/js/archive.js', array(), $theme_version, true );

		}

		// 弹出组件
		wp_enqueue_style( 'modal-min', get_template_directory_uri() . '/assets/css/modal.min.css', null, $theme_version );
		wp_enqueue_script( 'modal-min', get_template_directory_uri() . '/assets/js/modal.min.js', array(), $theme_version, true );

		// 全局自定义
		wp_enqueue_script( 'app', get_template_directory_uri() . '/assets/js/app.js', array(), $theme_version, true );

		// 文章评论回复
		if ( ( !is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}
}

add_action( 'wp_enqueue_scripts', 'CGh_scripts' );