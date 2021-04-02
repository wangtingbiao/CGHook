<?php
/**
 * 主题自定义标签集合
 *
 * @package CGHook
 */

/*=============================================================================
 头部标签
===============================================================================*/

/**
 * 自定义徽标（logo）
 *
 * 使用a标签包裹图片和文字
 */
if ( !function_exists( 'CGh_get_hea_site' ) ) {
	function CGh_get_hea_site() {

		$CGh_site_id = get_theme_mod( 'custom_logo', true );
		$CGh_site_img = wp_get_attachment_image_src( $CGh_site_id, 'full' );
		$CGh_site_title_open = get_theme_mod( 'CGh_site_title_open', true );

		echo '<h1 class="site-title"><a rel="home" class="custom-logo-text" href="' . esc_url( home_url( '/' ) ) . '">';
		if ( has_custom_logo() ) {
			echo '<img src="' . esc_url( $CGh_site_img[ 0 ] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
		}
		if ( $CGh_site_title_open ) {
			bloginfo( 'name' );
		}
		echo '</a></h1>';
	}
}

/**
 * 头部的登录与注册
 *
 * 暂时为默认登录注册，注册成功返回之前页面（分类页或者首页返回第一篇文章内）
 */
if ( !function_exists( 'CGh_get_register_login' ) ) {
	function CGh_get_register_login() {

		$CGh_register_login_open = get_theme_mod( 'CGh_register_login_open', true );

		if ( $CGh_register_login_open ) {
			echo '<div class="register-login">';

			if ( !is_user_logged_in() ) {
				echo '<a href="' . wp_login_url( get_the_permalink() ) . '">' . esc_html__( '登录', 'text-cgh' ) . '</a>';
				if ( get_option( 'users_can_register' ) ) {
					wp_register( '', '' );
				}
			} else {
				echo '<a href="' . esc_url( admin_url( '/edit.php' ) ) . '" target="_blank">' . esc_html__( '个人中心', 'text-cgh' ) . '</a>';
				echo '<a href="' . wp_logout_url( get_the_permalink() ) . '">' . esc_html__( '注销', 'text-cgh' ) . '</a>';
			}

			echo '</div>';
		}
	}
}

/*=============================================================================
 首页和默认页标签
===============================================================================*/

/**
 * 轮播图
 *
 * 仅在首页显示，采用调取分类或文章作为效果展示
 * 多个分类ID或文章ID使用英文逗号（,）隔开
 */
if ( !function_exists( 'CGh_get_swiper' ) ) {
	function CGh_get_swiper() {

		$CGh_swiper_open = get_theme_mod( 'CGh_swiper_open', false );

		if ( is_home() && !is_paged() ) {
			if ( $CGh_swiper_open ) {
				get_template_part( 'templates-parts/templates', 'swiper' );
			}
		}

	}
}

/**
 * 顶部横条广告
 *
 * 全局显示在顶部，暂时可以添加文字和链接
 */
if ( !function_exists( 'CGh_get_top_adv' ) ) {
	function CGh_get_top_adv() {

		$CGh_top_adv_open = get_theme_mod( 'CGh_top_adv_open', false );
		$CGh_top_adv_title = get_theme_mod( 'CGh_top_adv_title', '' );
		$CGh_top_adv_url = get_theme_mod( 'CGh_top_adv_url', '' );

		if ( $CGh_top_adv_open ) {
			echo '<div class="text-banner"><div class="max-w-13"><a href="' . esc_url( $CGh_top_adv_url ) . '" target="_blank"><i class="fa fa-bullhorn" aria-hidden="true"></i>' . esc_html( $CGh_top_adv_title ) . '</a></div></div><!-- .text-banner end -->';
		}

	}
}

/**
 * 全局横幅
 *
 * 分类名称、搜索结果等等页面头部，用以集中化管理
 */
if ( !function_exists( 'CGh_get_sort' ) ) {
	function CGh_get_sort() {

		$h2_before = '<h2>';
		$h2_after = '</h2>';
		$p_before = '<p>';
		$p_after = '</p>';

		echo '<div class="cat-info"><div class="max-w-13">';

		if ( is_search() ) {

			echo $h2_before . sprintf( __( '搜索 " %1$s " 相关文章', 'text-cgh' ), get_search_query() ) . $h2_after;
			echo $p_before . $p_after;
			get_search_form();

		} else if ( is_date() ) {

			echo $h2_before;
			single_month_title();
			echo $h2_after;

		} else {

			echo $h2_before;
			single_term_title();
			echo $h2_after;
			echo term_description();

		}
		echo '</div></div>';
	}
}

/**
 * 随机文章
 *
 * 所有页面默认显示随机文章
 * 首页、归档（分类）、文章，各自页面可独立显示
 */
if ( !function_exists( 'CGh_get_random' ) ) {
	function CGh_get_random() {

		$CGh_templates_random = get_template_part( 'templates-parts/templates', 'random' );

		$CGh_home_random_open = get_theme_mod( 'CGh_home_random_open', true );
		$CGh_archive_random_open = get_theme_mod( 'CGh_archive_random_open', true );
		$CGh_posts_random_open = get_theme_mod( 'CGh_posts_random_open', true );

		if ( is_home() && !is_paged() ) {

			if ( $CGh_home_random_open ) {
				echo $CGh_templates_random;
			}

		} elseif ( is_archive() ) {

			if ( $CGh_posts_random_open ) {
				echo $CGh_templates_random;
			}

		} elseif ( is_single() ) {

			if ( $CGh_posts_random_open ) {
				echo $CGh_templates_random;
			}

		}

	}
}

/*=============================================================================
 文章列表和内页标签
===============================================================================*/

/**
 * 列表列数
 *
 * 使用class方式更改列表样式
 * 首页、归档（分类）均有一列、二列、三列显示方式，设为三列侧边栏不显示
 * 各自页面可独立显示，默认为1列
 */
if ( !function_exists( 'CGh_lists_columns' ) ) {
	function CGh_lists_columns() {

		$post_widget = ' lists-no-widget';
		$CGh_home_list_columns = get_theme_mod( 'CGh_home_list_columns', 'one' );
		$CGh_search_list_columns = get_theme_mod( 'CGh_search_list_columns', 'one' );
		$CGh_archive_list_columns = get_theme_mod( 'CGh_archive_list_columns', 'one' );

		if ( is_home() ) {

			if ( $CGh_home_list_columns == 'three' ) {
				echo esc_attr( $CGh_home_list_columns ) . $post_widget;
			} else {
				echo esc_attr( $CGh_home_list_columns );
			}

		} elseif ( is_search() ) {

			if ( $CGh_search_list_columns == 'three' ) {
				echo esc_attr( $CGh_search_list_columns ) . $post_widget;
			} else {
				echo esc_attr( $CGh_search_list_columns );
			}

		} else {

			if ( $CGh_archive_list_columns == 'three' ) {
				echo esc_attr( $CGh_archive_list_columns ) . $post_widget;
			} else {
				echo esc_attr( $CGh_archive_list_columns );
			}

		}

	}
}

/**
 * 显示侧边栏
 *
 * 所有页面默认显示侧边栏
 * 首页、归档（分类）、文章，各自页面可独立显示
 */
if ( !function_exists( 'CGh_get_sidebar' ) ) {
	function CGh_get_sidebar() {

		$CGh_home_list_columns = get_theme_mod( 'CGh_home_list_columns', 'one' );
		$CGh_archive_list_columns = get_theme_mod( 'CGh_archive_list_columns', 'one' );
		$CGh_posts_sidebar_open = get_theme_mod( 'CGh_posts_sidebar_open', true );

		if ( is_home() ) {

			if ( $CGh_home_list_columns == 'three' ) {} else {
				get_sidebar();
			}

		} elseif ( is_single() ) {

			if ( $CGh_posts_sidebar_open ) {
				get_sidebar();
			}

		} else {

			if ( $CGh_archive_list_columns == 'three' ) {} else {
				get_sidebar();
			}

		}

	}
}

/**
 * 循环列表显示的缩略图
 *
 * 使用优先级，特色图像->文章第一张图->自定义图像->默认图像
 */
if ( !function_exists( 'CGh_the_thumbnail' ) ) {
	function CGh_the_thumbnail() {

		global $post;
		$content = $post->post_content;
		$CGh_posts_thumbnail = get_theme_mod( 'CGh_posts_thumbnail', '' );
		preg_match_all( '/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
		$number = count( $strResult[ 1 ] );

		if ( $number > 0 ) {

			echo esc_url( $strResult[ 1 ][ 0 ] );
			
		} elseif ( $CGh_posts_thumbnail ) {
			
			echo esc_url( $CGh_posts_thumbnail );
			
		} else{
			
			echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/thumbnail.svg';
			
		}

	}
}

/**
 * 海报图
 */
if ( !function_exists( 'CGh_get_full_thumbnail' ) ) {
	function CGh_get_full_thumbnail() {

		if ( has_post_thumbnail() ) {

			if ( is_mobile_device() ) {

				the_post_thumbnail( 'post-thumb-medium' );

			} elseif ( is_tablet() ) {

				the_post_thumbnail( 'post-thumb-large' );

			} else {

				the_post_thumbnail();

			}

		} else {

			echo '<img ';

			if ( is_mobile_device() ) {

				echo 'width="576" height="auto" ';

			} elseif ( is_tablet() ) {

				echo 'width="960" height="auto" ';

			}

			echo 'src="';

			CGh_the_thumbnail();

			echo '">';

		}
	}
}

/**
 * 文章列表图
 */
if ( !function_exists( 'CGh_get_post_thumbnail' ) ) {
	function CGh_get_post_thumbnail() {

		if ( has_post_thumbnail() ) {

			the_post_thumbnail( 'post-thumb-medium' );

		} else {

			echo '<img width="576" height="auto" src="';

			CGh_the_thumbnail();

			echo '">';

		}
	}
}


/**
 * 文章格式
 * 
 * 当前文章的格式，视频、音乐、图片、等等
 */
if ( !function_exists( 'CGH_get_post_format' ) ) {
	function CGH_get_post_format() {

		if ( has_post_format( 'video' ) ) {
			
			echo '<i class="fa fa-video-camera" aria-hidden="true"></i>';
			
		}elseif ( has_post_format( 'audio' ) ) {
			
			echo '<i class="fa fa-headphones" aria-hidden="true"></i>';
			
		}elseif ( has_post_format( 'image' ) ) {
			
			echo '<i class="fa fa-picture-o" aria-hidden="true"></i>';
			
		}elseif ( has_post_format( 'aside' ) ) {
			
			echo '<i class="fa fa-newspaper-o" aria-hidden="true"></i>';
			
		}else{
			
			echo '<i class="fa fa-circle-o" aria-hidden="true"></i>';
			
		}

	}
}

/**
 * 文章内容阅读大概时间
 */
if ( !function_exists( 'CGh_reading_time' ) ) {
	function CGh_reading_time( $content ) {

		$format = __( '%min%分%sec%秒阅读', 'text-cgh' );
		$chars_per_minute = 300;
		$format = str_replace( '%num%', $chars_per_minute, $format );
		$words = mb_strlen( preg_replace( '/\s/', '', html_entity_decode( strip_tags( $content ) ) ), 'UTF-8' );
		$minutes = floor( $words / $chars_per_minute );
		$seconds = floor( $words % $chars_per_minute / ( $chars_per_minute / 60 ) );
		return str_replace( '%sec%', $seconds, str_replace( '%min%', $minutes, $format ) );

	}
}

function CGh_get_reading_time() {
	echo CGh_reading_time( get_the_content() );
}

/**
 * 共有元
 */
if ( !function_exists( 'CGh_get_post_meta' ) ) {
	function CGh_get_post_meta() {

		$CGh_posts_time_open = get_theme_mod( 'CGh_posts_time_open', true );
		$CGh_posts_category_open = get_theme_mod( 'CGh_posts_category_open', true );
		$CGh_posts_postview_open = get_theme_mod( 'CGh_posts_postview_open', true );
		$CGh_lists_time_open = get_theme_mod( 'CGh_lists_time_open', true );
		$CGh_lists_read_time_open = get_theme_mod( 'CGh_lists_read_time_open', true );
		$publish_time = '<time datetime="' . get_the_time( 'Y-m-d A G:i:s' ) . '"><i class="fa fa-calendar" aria-hidden="true"></i>' . get_the_time( 'Fj,Y' ) . '</time>';

		if ( is_singular( 'post' ) ) {

			// 发布日期
			if ( $CGh_posts_time_open ) {
				echo $publish_time;
			}

			// 所属分类
			if ( $CGh_posts_category_open ) {
				echo '<span>';
				the_category( '，', '' );
				echo '</span>';
			}

			//浏览量
			if ( $CGh_posts_postview_open ) {
				echo '<span><i class="fa fa-eye"></i>';
				CGh_get_post_view();
				echo '</span>';
			}

		} else {

			// 发布日期
			if ( $CGh_lists_time_open ) {
				echo $publish_time;
			}

			// 阅读时间
			if ( $CGh_lists_read_time_open ) {
				echo '<span><i class="fa fa-clock-o" aria-hidden="true"></i>';
				CGh_get_reading_time();
				echo '</span>';
			}

		}
	}
}

/*=============================================================================
 底部标签
===============================================================================*/

/**
 * 底部介绍
 *
 * 底部站点介绍，自带logo
 */
if ( !function_exists( 'CGh_get_foo_site' ) ) {
	function CGh_get_foo_site() {

		$CGh_foo_site_open = get_theme_mod( 'CGh_foo_site_open', true );
		$CGh_foo_site_desc = get_theme_mod( 'CGh_foo_site_desc', '' );
		
		if ( $CGh_foo_site_open || $CGh_foo_site_desc ) {
			echo '<div class="widget foo-site-title">';
			if ( $CGh_foo_site_open ) {
				CGh_get_hea_site();
			}
			echo '<p class="foo-site-title-desc">' . wp_kses_post( $CGh_foo_site_desc ) . '</p>';
			echo '</div><!-- .foo-site-title end -->';
		}

	}
}

/**
 * 底部版权
 *
 * 自动更新当前版权年份，版权自动链接到官方查询站点
 */
if ( !function_exists( 'CGh_get_copyright' ) ) {
	function CGh_get_copyright() {
		echo '<div class="copyright">';

		echo '&copy; ' . date_i18n( esc_html__( 'Y', 'text-cgh' ) ) . ' ' . get_bloginfo( 'name' ) . ' | ' . __( '主题', 'text-cgh' ) . ' <a href="https://www.wangtingbiao.com" target="_blank">MR Wang</a>';

		$CGh_record = get_theme_mod( 'CGh_record', '' );
		$CGh_statistics = get_theme_mod( 'CGh_statistics', '' );

		if ( $CGh_record ) {
			echo ' | <a href="https://beian.miit.gov.cn" target="_blank">' . esc_html( $CGh_record ) . '</a>';
		}

		echo $CGh_statistics;

		echo '</div>';
	}
}