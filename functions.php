<?php
/**
 * 主题函数定义
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CGHook
 */

/*
 * 升级WP失败删除core_updater.lock文件

global $wpdb;
$wpdb->query( "DELETE FROM wp_options WHERE option_name = 'core_updater.lock'" );
 */
/**
 * 设置主题默认值并注册对各种WordPress功能的支持
 *
 * 请注意，此函数已挂接到after_setup_theme挂钩中，
 * 在初始化钩子之前运行对于某些功能，init挂钩为时已晚，例如
 * 表示支持文章缩略图
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 */
if ( !function_exists( 'CGh_setup' ) ) {
	function CGh_setup() {

		// 启用对文章格式的支持
		add_theme_support( 'post-formats', array( 'aside', 'video', 'image', 'audio' ) );

		/*
		 * 启用缩略图的支持
		 * 默认缩略图尺寸
		 * 自定义尺寸
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1280, 600, array( 'center', 'center' ) );
		add_image_size( 'post-thumb-large', 960, 450, array( 'center', 'center' ) );
		add_image_size( 'post-thumb-medium', 576, 270, array( 'center', 'center' ) );

		// 自定义背景
		add_theme_support( 'custom-background' );

		// 自定义页眉
		//add_theme_support( 'custom-header' );

		// 设置WordPress主题徽标功能
		add_theme_support( 'custom-logo',
			array(
				'height' => '40',
				'width' => 'auto',
				'flex-height' => true,
				'flex-width' => true,
			)
		);

		// 将默认文章和评论RSS feed链接添加到头部
		add_theme_support( 'automatic-feed-links' );

		// 切换搜索表格，评论表格和评论的默认核心标记输出有效的HTML5
		add_theme_support(
			'html5',
			array(
				'navigation-widgets',
				'comment-list',
				'comment-form',
				'search-form',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		/*
		 * 让WordPress管理文档标题
		 *
		 * 通过添加主题支持，我们声明此主题不使用文档头中
		 * 硬编码的<title>标签，并希望WordPress能够为我们提供
		 */
		add_theme_support( 'title-tag' );

		// 在自定义程序中添加对小部件编辑图标的支持
		add_theme_support( 'customize-selective-refresh-widgets' );

		// 使主题可用于翻译，翻译可以保存在/languages/目录中
		load_theme_textdomain( 'text-cgh', get_template_directory() . '/languages' );

		// 为块编辑器启用主题“对齐全部”和“对齐宽”选项
		add_theme_support( 'align-wide' );

		// 添加对响应式嵌入的支持
		add_theme_support( 'responsive-embeds' );

		// 对于块编辑器
		add_theme_support( 'editor-styles' );

		// 将空样式表应用于可视化编辑器以删除由于某种原因目前尚无法正常工作的样式表
		add_editor_style( '/editor-style.css' );

		// 该主题在一个位置使用wp_nav_menu（）
		register_nav_menus(
			array(
				'main-menu'		=>	__( '主菜单', 'text-cgh' ),
				'footer-menu'	=>	__( '底部菜单', 'text-cgh' ),
			)
		);

		// 入门演示内容
		//add_theme_support( 'starter-content' );
	}
}

add_action( 'after_setup_theme', 'CGh_setup' );

/**
 * 核心
 */
require get_template_directory() . '/inc/theme-cores.php';

/**
 * 加载JavaScript和CSS源
 */
require get_template_directory() . '/inc/theme-enqueue.php';

/**
 * 初始化小部件
 */
require get_template_directory() . '/inc/theme-widgets.php';

/**
 * 后台文章列表缩略图
 */
require get_template_directory() . '/inc/theme-easy-thumbnail.php';

/**
 * 标签集合
 */
require get_template_directory() . '/inc/theme-tags.php';

/**
 * 动作/过滤集合
 */
require get_template_directory() . '/inc/theme-action-filter.php';

/**
 * 数据库清理
 */
require get_template_directory() . '/inc/wp-clean-up/wp-clean-up.php';

/**
 * 定制器
 */
require get_template_directory() . '/classes/class-customizer.php';

/**
 * 评论列表
 */
require get_template_directory() . '/classes/class-comment.php';

/**
 * 社交与二维码
 */
require get_template_directory() . '/classes/class-social.php';

/**
 * 将文章格式添加到页面'page'
 */
//add_post_type_support( 'page', 'post-formats' );

/**
 * 对wp_body_open进行填充
 *
 * 以确保与5.2之前的WordPress版本向后兼容
 */
if ( !function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * 低于IE11浏览器
 */
function custom_body_open() {
	if ( preg_match( '~MSIE|Internet Explorer~i', $_SERVER[ 'HTTP_USER_AGENT' ] ) || preg_match( '~Trident/7.0(; Touch)?; rv:11.0~', $_SERVER[ 'HTTP_USER_AGENT' ] ) ) {
		echo '<div class="unsupported-browser">' . __( '<b>浏览器版本可能过低！</b> 该网站将在此浏览器中提供有限的功能请升级为Chrome，Firefox，Safari和Edge等浏览器<a href="https://browsehappy.com/" target="_blank">最新版本</a>以获取更好的体验！', 'text-cgh' ) . '</div>';
	}
}

add_action( 'wp_body_open', 'custom_body_open' );