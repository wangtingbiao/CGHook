<?php
/**
 * 主题自定义动作/过滤集合
 *
 * @package CGHook
 */

/*=============================================================================
 头部动作/过滤添加
===============================================================================*/

/**
 * 增加页面评分，提高站点排名
 *
 * 排名通过一些算法来计算，我们当前的文章是知否符合用户的需求，
 * 这些算法也可以称为是在计算页面的评分值，评分值越高的排名就越好
 */
if ( !function_exists( 'CGh_get_keywords' ) ) {
	function CGh_get_keywords() {

		if ( is_home() || is_front_page() ) {

			$CGh_keywords = get_theme_mod( 'CGh_keywords', '' );
			echo esc_html( $CGh_keywords );

		} elseif ( is_category() ) {
			single_cat_title();
		} elseif ( is_singular() ) {

			echo trim( wp_title( '', false ) ) . ',';
			if ( has_tag() ) {
				foreach ( get_the_tags() as $tag ) {
					echo $tag->name . ',';
				}
			}
			foreach ( get_the_category() as $category ) {
				echo $category->cat_name . ',';
			}

		} elseif ( is_search() ) {
			the_search_query();
		} else {
			echo trim( wp_title( '', false ) );
		}

	}
}

function CGh_keywords_description() {
	?>
<meta name="keywords" content="<?php CGh_get_keywords(); ?>">
<meta name="description" content="<?php bloginfo( 'description' ); ?>">
<?php
}

add_action( 'wp_head', 'CGh_keywords_description' );

/*=============================================================================
 文章列表和内页动作/过滤添加
===============================================================================*/

/**
 * 自定义摘要输出
 */
function CGh_get_post_excerpt( $excerpt ) {
	$excerpt = '<p class="entry-excerpt">' . get_the_excerpt() . '</p>';
	return $excerpt;
}

add_filter( 'the_excerpt', 'CGh_get_post_excerpt', 10, true );

/**
 * 文章浏览量（刷新+1）
 */
function CGh_get_post_view( $before = '', $after = '', $echo = 1 ) {
	global $post;
	$post_ID = $post->ID;
	$views = ( int )get_post_meta( $post_ID, 'views', true );
	if ( $echo )echo $before, number_format( $views ), $after;
	else return $views;
}

function CGh_posts_record_visitors() {
	if ( is_singular() ) {
		global $post;
		$post_ID = $post->ID;
		if ( $post_ID ) {
			$CGh_get_post_view = ( int )get_post_meta( $post_ID, 'views', true );
			if ( !update_post_meta( $post_ID, 'views', ( $CGh_get_post_view + 1 ) ) ) {
				add_post_meta( $post_ID, 'views', 1, true );
			}
		}
	}
}

add_action( 'wp_head', 'CGh_posts_record_visitors' );

/**
 * 文章头图
 */
if ( !function_exists( 'CGh_posts_top_thumbnail' ) ) {
	function CGh_posts_top_thumbnail( $content ) {
		
		$CGh_posts_thumbnail_open = get_theme_mod( 'CGh_posts_thumbnail_open', true );
			
		if ( !is_singular( 'post' ) ) {
			return $content;
		}

		$thumbnail = '';
		
		if ( $CGh_posts_thumbnail_open ) {

			$thumbnail = '<figure class="wp-block-image size-large">' . get_the_post_thumbnail() . '</figure>';

			$content = $thumbnail . $content;
			
		}
		
		return $content;
	}
}

add_filter( 'the_content', 'CGh_posts_top_thumbnail' , 9 );

/**
 * 文章浮动锚点
 */
if ( !function_exists( 'CGh_posts_anchor_point_menu' ) ) {
	function CGh_posts_anchor_point_menu( $content ) {

		if ( !is_singular( 'post' ) ) {
			return $content;
		}
		
		$index = '';
		$ol = '';
		$arr = array();
		$pattern = '/<h([2-6]).*?\>(.*?)<\/h[2-6]>/is';

		if ( preg_match_all( $pattern, $content, $arr ) ): $count = count( $arr[ 0 ] );
		foreach ( $arr[ 1 ] as $k => $v ) {
			if ( $k <= 0 ) {
				$index = '<ol>';
			} else {
				if ( $v > $arr[ 1 ][ $k - 1 ] ) {
					if ( $v - $arr[ 1 ][ $k - 1 ] == 1 ) {
						$index .= '<ol>';
					} elseif ( $v == $arr[ 1 ][ $k - 1 ] ) {

					} else {
						$index .= esc_html__( '目录是非法的', 'text-cgh' );
						return false;
					}
				}
			}

			$title = strip_tags( $arr[ 2 ][ $k ] );
			$content = str_replace( $arr[ 0 ][ $k ], '<h' . $v . ' id="index-' . $k . '">' . $title . '</h' . $v . '>', $content );
			$index .= '<li class="h' . $v . '"><a href="#index-' . $k . '">' . $title . '</a></li>';

			if ( $k < $count - 1 ) {
				if ( $v > $arr[ 1 ][ $k + 1 ] ) {
					$c = $v - $arr[ 1 ][ $k + 1 ];
					for ( $i = 0; $i < $c; $i++ ) {
						$ol .= '</ol>';
						$index .= $ol;
						$ol = '';
					}
				}
			} else {
				$index .= '</ol>';
			}

		}
		$index = '<div id="anchor-point-menu" class="anchor-point-menu">
					<div id="anchor-point-toggle" class="anchor-point-toggle">
						<p>' . esc_html__( '导航目录', 'text-cgh' ) . '</p>
						<button type="button" class="anchor-point-icon"><i class="fa fa-chevron-down"></i></button>
					</div>
					<nav id="anchor-point-nav" class="anchor-point-nav">' . $index . '</nav>
				  </div>';
		$content = $index . $content;
		endif;
		return $content;
	}
}

add_filter( 'the_content', 'CGh_posts_anchor_point_menu', 8 );

/**
 * 文章内容版权-全局
 */
if ( !function_exists( 'CGh_posts_copytight' ) ) {
	function CGh_posts_copytight( $content ) {

		if ( is_singular( 'post' ) ) {

			$CGh_posts_copytight_open = get_theme_mod( 'CGh_posts_copytight_open', false );
			$CGh_posts_copytight = get_theme_mod( 'CGh_posts_copytight', '' );

			if ( $CGh_posts_copytight_open && $CGh_posts_copytight ) {
				$content .= '<div class="wp-block-copytight sin-copytight"><i class="fa fa-flag"></i><span>' . wp_kses_post( $CGh_posts_copytight ) . '</span></div>';
			}

		}
		return $content;
	}
}

add_filter( 'the_content', 'CGh_posts_copytight' );

/**
 * 加一个点赞功能
 */
if ( !function_exists( 'CGh_posts_like' ) ) {
	function CGh_posts_like() {

		global $wpdb, $post;
		$id = $_POST[ "um_id" ];
		$action = $_POST[ "um_action" ];

		if ( $action == 'ding' ) {
			$CGh_raters = get_post_meta( $id, 'CGh_ding', true );
			$expire = time() + 99999999;
			$domain = ( $_SERVER[ 'HTTP_HOST' ] != 'localhost' ) ? $_SERVER[ 'HTTP_HOST' ] : false;
			setcookie( 'CGh_ding_' . $id, $id, $expire, '/', $domain, false );
			if ( !$CGh_raters || !is_numeric( $CGh_raters ) ) {
				update_post_meta( $id, 'CGh_ding', 1 );
			} else {
				update_post_meta( $id, 'CGh_ding', ( $CGh_raters + 1 ) );
			}
			echo get_post_meta( $id, 'CGh_ding', true );
		}
		die;

	}
}

add_action( 'wp_ajax_nopriv_CGh_posts_like', 'CGh_posts_like' );
add_action( 'wp_ajax_CGh_posts_like', 'CGh_posts_like' );

/**
 * 将alt和title属性添加到文章图片的img标签中
 */
if ( !function_exists( 'CGh_posts_img_gesalt' ) ) {
	function CGh_posts_img_gesalt( $content ) {

		global $post;
		$pattern = "/<img(.*?)src=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
		$replacement = '<img$1src=$2$3.$4$5 alt="' . $post->post_title . '" title="' . $post->post_title . '"$6>';
		$content = preg_replace( $pattern, $replacement, $content );
		return $content;

	}
}

add_filter( 'the_content', 'CGh_posts_img_gesalt' );

/*=============================================================================
 底部动作/过滤添加
===============================================================================*/

/**
 * 在线客服
 */
if ( !function_exists( 'CGh_clerk' ) ) {
	function CGh_clerk() {

		$CGh_clerk_open = get_theme_mod( 'CGh_clerk_open', false );
		$CGh_clerk_setup = get_theme_mod( 'CGh_clerk_setup', '' );
		$CGh_clerk_url = get_theme_mod( 'CGh_clerk_url', '' );
		$CGh_clerk_js = get_theme_mod( 'CGh_clerk_js', '' );

		if ( $CGh_clerk_open ) {

			echo '<div id="clerk-fiexd" class="clerk-fiexd">';
			if ( $CGh_clerk_setup == 'clerk_url' ) {
				echo '<a target="_blank" href="' . esc_url( $CGh_clerk_url ) . '"><i class="fa fa-bell" aria-hidden="true"></i><span>' . __( '客服', 'text-cgh' ) . '</span></a>';
			} elseif ( $CGh_clerk_setup == 'clerk_js' ) {
				echo $CGh_clerk_js;
			}
			echo '</div>';

		}

	}
}

add_action( 'wp_footer', 'CGh_clerk' );

/**
 * 返回顶部
 */
if ( !function_exists( 'CGh_totop' ) ) {
	function CGh_totop() {

		$CGh_totop_open = get_theme_mod( 'CGh_totop_open', true );

		if ( $CGh_totop_open ) {
			echo '<button type="button" id="site-top" class="site-top"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>';
		}

	}
}

add_action( 'wp_footer', 'CGh_totop' );
