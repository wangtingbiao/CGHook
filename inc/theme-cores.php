<?php
/**
 * 核心功能集合
 *
 * @package CGHook
 */

/**
 * 支持 WebP
 */
function CGh_filter_mime_types( $array ) {
	$array[ 'webp' ] = 'image/webp';
	return $array;
}

function CGh_file_is_displayable_image( $result, $path ) {
	$info = @getimagesize( $path );
	if ( $info[ 'mime' ] == 'image/webp' ) {
		$result = true;
	}
	return $result;
}

add_filter( 'mime_types', 'CGh_filter_mime_types', 10, 1 );
add_filter( 'file_is_displayable_image', 'CGh_file_is_displayable_image', 10, 2 );

/**
 * 缩略图
 *
 * 禁止生成默认尺寸缩略图，只允许自定义缩略图
 */
function CGh_disable_image_sizes( $sizes ) {

	unset( $sizes[ 'medium' ] );
	unset( $sizes[ 'large' ] );
	unset( $sizes[ 'medium_large' ] );
	unset( $sizes[ '1536x1536' ] );
	unset( $sizes[ '2048x2048' ] );

	return $sizes;

}

add_action( 'intermediate_image_sizes_advanced', 'CGh_disable_image_sizes' );

// 禁用缩放尺寸
add_filter( 'big_image_size_threshold', '__return_false' );

/*function CGh_disable_other_image_sizes() {
	remove_image_size( 'post-thumbnail' );
}
add_action( 'init', 'CGh_disable_other_image_sizes' );*/

/**
 * 默认显示
 *
 * 文章页插入图片默认显示方式
 */
function CGh_attachment_display_settings() {
	update_option( 'image_default_align', 'left' );
	update_option( 'image_default_link_type', 'none' );
	update_option( 'image_default_size', 'medium' );
}

add_action( 'after_setup_theme', 'CGh_attachment_display_settings' );

/**
 * 菜单选择器
 *
 * 移除菜单多余分类选择器，保留所必须的class类
 */
function CGh_css_attributes_filter( $var ) {
	return is_array( $var ) ? array_intersect( $var, array( 'current-menu-item', 'current-menu-ancestor', 'current-post-ancestor', 'menu-item-has-children' ) ) : '';
}

add_filter( 'nav_menu_css_class', 'CGh_css_attributes_filter', 100, true );
add_filter( 'nav_menu_item_id', 'CGh_css_attributes_filter', 100, true );
add_filter( 'page_css_class', 'CGh_css_attributes_filter', 100, true );

/**
 * 排除页面
 *
 * 搜索结果中只显示文章类型，也可以追加自定义类型
 */
function CGh_search_filter_page( $query ) {
	if ( $query->is_search ) {
		$query->set( 'post_type', 'post' );
	}
	return $query;
}

add_filter( 'pre_get_posts', 'CGh_search_filter_page' );

/**
 * 搜索结果一篇文章
 *
 * 当搜索出相关文章仅有一篇时，自动打开进入文章，无需二次点击
 */
function CGh_one_post_result() {
	if ( is_search() ) {
		global $wp_query;
		if ( $wp_query->post_count == 1 ) {
			wp_redirect( get_permalink( $wp_query->posts[ '0' ]->ID ) );
		}
	}
}

add_action( 'template_redirect', 'CGh_one_post_result' );

/**
 * 媒体上传
 *
 * 自定义媒体上传位置，类如上传到自定义子域名下 img.youtname.com
 */
if ( get_option( 'upload_path' ) == 'wp-content/uploads' || get_option( 'upload_path' ) == null ) {
	update_option( 'upload_path', WP_CONTENT_DIR . '/uploads' );
}

/**
 * 添加移动端设备判断函数
 */
// 只检测iPad
function is_ipad() {
	$is_ipad = ( bool )strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'iPad' );
	if ( $is_ipad )
		return true;
	else return false;
}
// 只检测iPhone
function is_iphone() {
	$cn_is_iphone = ( bool )strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'iPhone' );
	if ( $cn_is_iphone )
		return true;
	else return false;
}
// 检测所有iOS设备
function is_ios() {
	if ( is_iphone() || is_ipad() )
		return true;
	else return false;
}
// 检测所有android设备
function is_android() {
	$is_android = ( bool )strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Android' );
	if ( $is_android )
		return true;
	else return false;
}
// 只检测Android手机
function is_android_mobile() {
	$is_android = ( bool )strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Android' );
	$is_android_m = ( bool )strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Mobile' );
	if ( $is_android && $is_android_m )
		return true;
	else return false;
}
// 只检测Android平板电脑
function is_android_tablet() {
	if ( is_android() && !is_android_mobile() )
		return true;
	else return false;
}
// 检测Android手机、iPhone
function is_mobile_device() {
	if ( is_android_mobile() || is_iphone() )
		return true;
	else return false;
}
// 检测Android平板电脑和iPad
function is_tablet() {
	if ( ( is_android() && !is_android_mobile() ) || is_ipad() )
		return true;
	else return false;
}

/**
 * 保护您的网站免受恶意请求
 *
 * 避免来自垃圾邮件发送者的许多恶意URL请求
 */
global $user_ID;
if ( $user_ID ) {
	if ( !current_user_can( 'administrator' ) ) {
		if ( strlen( $_SERVER[ 'REQUEST_URI' ] ) > 255 ||
			stripos( $_SERVER[ 'REQUEST_URI' ], "eval(" ) ||
			stripos( $_SERVER[ 'REQUEST_URI' ], "CONCAT" ) ||
			stripos( $_SERVER[ 'REQUEST_URI' ], "UNION+SELECT" ) ||
			stripos( $_SERVER[ 'REQUEST_URI' ], "base64" ) ) {
			@header( "HTTP/1.1 414 Request-URI Too Long" );
			@header( "Status: 414 Request-URI Too Long" );
			@header( "Connection: Close" );
			@exit;
		}
	}
}

/**
 * 清理head
 *
 * 针对大陆无法访问信息和不必要的信息进行移除
 */
remove_action( 'wp_head', 'wp_generator' ); //移除版本号
remove_action( 'wp_head', 'rsd_link' ); // 移除离线编辑器开放接口 EditURI
remove_action( 'wp_head', 'wlwmanifest_link' ); // 移除 wlwmanifest
remove_action( 'wp_head', 'wp_shortlink_wp_head' ); // 移除文章 shortlink 短链接
remove_action( 'wp_head', 'rel_canonical' ); // 移除本页面链接 url
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' ); // 移除上一篇 prev 和下一篇 next 文章链接
remove_action( 'wp_head', 'feed_links', 2 ); // 移除文章和评论 feed
remove_action( 'wp_head', 'feed_links_extra', 3 ); // 移除分类等 feed
remove_action( 'wp_head', 'wp_resource_hints', 2 ); // 移除辅助获取表情包

remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); // 删除表情符号
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
add_filter( 'xmlrpc_enabled', '__return_false' ); // 禁用XML-RPC服务

add_filter( 'wpcf7_load_js', '__return_false' ); // 禁用联系表7 CSS / JS
add_filter( 'wpcf7_load_css', '__return_false' );

add_filter( 'avf_load_google_map_api', '__return_false' ); // 移除整站谷歌地图

/**
 * 禁用Dashicons
 */
function CGh_dequeue_dashicon() {
	if ( current_user_can( 'update_core' ) ) {
		return;
	}
	wp_deregister_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'CGh_dequeue_dashicon' );

/**
 * 从评论中删除nofollow
 */
function CGh_xwp_dofollow( $str ) {
	$str = preg_replace(
		'~<a ([^>]*)\s*(["|\']{1}\w*)\s*nofollow([^>]*)>~U',
		'<a ${1}${2}${3}>',
		$str
	);
	return str_replace( array( ' rel=""', " rel=''" ), '', $str );
}
remove_filter( 'pre_comment_content', 'wp_rel_nofollow' );
add_filter( 'get_comment_author_link', 'CGh_xwp_dofollow' );
add_filter( 'post_comments_link', 'CGh_xwp_dofollow' );
add_filter( 'comment_reply_link', 'CGh_xwp_dofollow' );
add_filter( 'comment_text', 'CGh_xwp_dofollow' );

/**
 * 从静态资源中删除查询字符串
 */
function CGh_remove_cssjs_ver( $src ) {
	if ( strpos( $src, '?ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'CGh_remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'CGh_remove_cssjs_ver', 10, 2 );

/**
 * 禁止PINGBACK内页
 */
function CGh_disable_pingback( & $links ) {
	foreach ( $links as $l => $link ) {
		if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
			unset( $links[ $l ] );
		}
	}
}
add_action( 'pre_ping', 'CGh_disable_pingback' );