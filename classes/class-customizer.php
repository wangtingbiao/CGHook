<?php
/**
 * 主题定制器
 *
 * @package CGHook
 */

/**
 * 为主题定制器的站点标题和说明添加postMessage支持
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( !class_exists( 'CGh_Customize_Register' ) ) {

	class CGh_Customize_Register {

		public static function register( $wp_customize ) {

			/* -------------------------------------------------------------------------- */
			/*	默认菜单添加自定义属性
			/* -------------------------------------------------------------------------- */

			$postMessage = 'postMessage';

			$orderby = array(
				'rand' => __( '随机', 'text-cgh' ),
				'date' => __( '发布时间', 'text-cgh' ),
				'modified' => __( '修改时间', 'text-cgh' ),
				'comment_count' => __( '评论数', 'text-cgh' ),
			);

			$list_colums = array(
				'one' => __( '一列', 'text-cgh' ),
				'two' => __( '二列', 'text-cgh' ),
				'three' => __( '三列 无侧边栏', 'text-cgh' ),
			);

			$wp_customize->get_setting( 'blogname' )->transport = $postMessage;

			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector' => '.site-title a',
					'render_callback' => 'CGh_site_title_callback',
				)
			);

			// 显示登录/注册
			$wp_customize->add_setting(
				'CGh_register_login_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_register_login_open',
				array(
					'label' => __( '显示登录/注册', 'text-cgh' ),
					'description' => __( '后台 <a href="' . get_admin_url( 'options-general.php' ) . '" target="_blank">成员资格</a> 勾选任何人都可以注册', 'text-cgh' ),
					'section' => 'title_tagline',
					'priority' => 9,
					'type' => 'checkbox',
				)
			);

			// 显示站点标题
			$wp_customize->add_setting(
				'CGh_site_title_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_site_title_open',
				array(
					'label' => __( '显示站点标题', 'text-cgh' ),
					'section' => 'title_tagline',
					'priority' => 9,
					'type' => 'checkbox',
				)
			);

			// 站点关键词
			$wp_customize->add_setting(
				'CGh_keywords',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'wp_kses_post', //wp_filter_nohtml_kses
				)
			);

			$wp_customize->add_control(
				'CGh_keywords',
				array(
					'label' => __( '站点关键词', 'text-cgh' ),
					'description' => __( '多个词请用英文逗号（,）或中文顿号（、）隔开', 'text-cgh' ),
					'section' => 'title_tagline',
					'priority' => 10,
					'type' => 'textarea',
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	主面板
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_panel(
				'CGh_panels',
				array(
					'title' => __( '主题设置', 'text-cgh' ),
					'priority' => 0,
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	首页轮播
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_section(
				'CGh_home_menu',
				array(
					'title' => __( '首页轮播', 'text-cgh' ),
					'panel' => 'CGh_panels',
					'priority' => 10,
				)
			);

			// 显示轮播
			$wp_customize->add_setting(
				'CGh_swiper_open',
				array(
					'default' => false,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_open',
				array(
					'label' => __( '显示轮播', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_swiper_open',
				array(
					'selector' => '.swiper-box h3',
				)
			);

			// 显示模式
			$wp_customize->add_setting(
				'CGh_swiper_select',
				array(
					'default' => 'category',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' ),
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_select',
				array(
					'label' => __( '显示模式', 'text-cgh' ),
					'description' => __( '选择不同显示模式，并填写下面所选模式的对应ID', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'select',
					'choices' => array(
						'category' => __( '分类', 'text-cgh' ),
						'article' => __( '文章', 'text-cgh' ),
					)
				)
			);

			// 分类ID
			$wp_customize->add_setting(
				'CGh_swiper_category_id',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_category_id',
				array(
					'label' => __( '分类ID', 'text-cgh' ),
					'description' => __( '分类ID，多个ID请用英文逗号（,）隔开', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 文章ID
			$wp_customize->add_setting(
				'CGh_swiper_post_id',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_post_id',
				array(
					'label' => __( '文章ID', 'text-cgh' ),
					'description' => __( '文章ID，多个ID请用英文逗号（,）隔开', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 排序方式
			$wp_customize->add_setting(
				'CGh_swiper_orderby',
				array(
					'default' => 'rand',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' ),
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_orderby',
				array(
					'label' => __( '排序方式', 'text-cgh' ),
					'description' => __( '对获取的文章进行排序，默认随机顺序', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'select',
					'choices' => $orderby,
				)
			);

			// 数量
			$wp_customize->add_setting(
				'CGh_swiper_number',
				array(
					'default' => 5,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_number',
				array(
					'label' => __( '文章数量', 'text-cgh' ),
					'description' => __( '获取的文章数量，建议不要设置过多，5篇以下为宜，不可为空', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 显示小圆点
			$wp_customize->add_setting(
				'CGh_swiper_pagination',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_pagination',
				array(
					'label' => __( '显示小圆点', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示左右箭头
			$wp_customize->add_setting(
				'CGh_swiper_navigation',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_navigation',
				array(
					'label' => __( '显示左右箭头', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 自动轮播
			$wp_customize->add_setting(
				'CGh_swiper_autoplay',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_autoplay',
				array(
					'label' => __( '自动轮播', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 轮播速度
			$wp_customize->add_setting(
				'CGh_swiper_autoplay_time',
				array(
					'default' => 5000,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_autoplay_time',
				array(
					'label' => __( '轮播速度', 'text-cgh' ),
					'description' => __( '轮播停留时间，默认5000（5秒），不可为空', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 动画速度
			$wp_customize->add_setting(
				'CGh_swiper_speed',
				array(
					'default' => 1000,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_speed',
				array(
					'label' => __( '动画速度', 'text-cgh' ),
					'description' => __( '轮播从右向左滑动速度，默认1000（1秒），不可为空', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 轮播间距
			$wp_customize->add_setting(
				'CGh_swiper_spacebetween',
				array(
					'default' => 0,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_spacebetween',
				array(
					'label' => __( '轮播间距', 'text-cgh' ),
					'description' => __( '两个轮播之间的间距（空白缝隙），默认为0，不用加单位（例：30）', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 同框数量
			$wp_customize->add_setting(
				'CGh_swiper_slidesperView',
				array(
					'default' => 1,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'CGh_swiper_slidesperView',
				array(
					'label' => __( '同框数量', 'text-cgh' ),
					'description' => __( '同时显示轮播数量，不可为空', 'text-cgh' ),
					'section' => 'CGh_home_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	文章列表
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_section(
				'CGh_post_list_menu',
				array(
					'title' => __( '文章列表', 'text-cgh' ),
					'panel' => 'CGh_panels',
					'priority' => 10,
				)
			);

			// 默认列数
			$wp_customize->add_setting(
				'CGh_archive_list_columns',
				array(
					'default' => 'one',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' ),
				)
			);

			$wp_customize->add_control(
				'CGh_archive_list_columns',
				array(
					'label' => __( '默认列数', 'text-cgh' ),
					'description' => __( '除首页全局生效，若设为三列则不显示侧边栏', 'text-cgh' ),
					'section' => 'CGh_post_list_menu',
					'priority' => 10,
					'type' => 'select',
					'choices' => $list_colums,
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_archive_list_columns',
				array(
					'selector' => '.layout-info',
				)
			);

			// 首页列数
			$wp_customize->add_setting(
				'CGh_home_list_columns',
				array(
					'default' => 'one',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' ),
				)
			);

			$wp_customize->add_control(
				'CGh_home_list_columns',
				array(
					'label' => __( '首页列数', 'text-cgh' ),
					'description' => __( '只在首页生效，若设为三列则不显示侧边栏', 'text-cgh' ),
					'section' => 'CGh_post_list_menu',
					'priority' => 10,
					'type' => 'select',
					'choices' => $list_colums,
				)
			);

			// 搜索页列数
			$wp_customize->add_setting(
				'CGh_search_list_columns',
				array(
					'default' => 'one',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' ),
				)
			);

			$wp_customize->add_control(
				'CGh_search_list_columns',
				array(
					'label' => __( '搜索页列数', 'text-cgh' ),
					'description' => __( '只在搜索页生效，默认无侧边栏', 'text-cgh' ),
					'section' => 'CGh_post_list_menu',
					'priority' => 10,
					'type' => 'select',
					'choices' => $list_colums,
				)
			);

			// 自定义缩略图
			$wp_customize->add_setting(
				'CGh_posts_thumbnail',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'CGh_posts_thumbnail',
					array(
						'label' => __( '自定义缩略图', 'text-cgh' ),
						'description' => __( '显示顺序，特色图像->文章第一张图->自定义缩略图->默认图', 'text-cgh' ),
						'section' => 'CGh_post_list_menu',
						'priority' => 10,
					)
				)
			);

			// 显示所属分类
			$wp_customize->add_setting(
				'CGh_lists_category_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_lists_category_open',
				array(
					'label' => __( '显示所属分类', 'text-cgh' ),
					'section' => 'CGh_post_list_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示发布日期
			$wp_customize->add_setting(
				'CGh_lists_time_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);
			$wp_customize->add_control(
				'CGh_lists_time_open',
				array(
					'label' => __( '显示发布日期', 'text-cgh' ),
					'section' => 'CGh_post_list_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示阅读时间
			$wp_customize->add_setting(
				'CGh_lists_read_time_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_lists_read_time_open',
				array(
					'label' => __( '显示阅读时间', 'text-cgh' ),
					'section' => 'CGh_post_list_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示摘要
			$wp_customize->add_setting(
				'CGh_lists_excerpt_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_lists_excerpt_open',
				array(
					'label' => __( '显示摘要', 'text-cgh' ),
					'section' => 'CGh_post_list_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示链接按钮
			$wp_customize->add_setting(
				'CGh_lists_link_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_lists_link_open',
				array(
					'label' => __( '显示链接按钮', 'text-cgh' ),
					'section' => 'CGh_post_list_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 按钮文字
			$wp_customize->add_setting(
				'CGh_lists_link',
				array(
					'default' => __( '阅读更多', 'text-cgh' ),
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => $postMessage,
				)
			);

			$wp_customize->add_control(
				'CGh_lists_link',
				array(
					'label' => __( '按钮文字', 'text-cgh' ),
					'description' => __( '链接按钮文字，默认阅读更多，不可为空', 'text-cgh' ),
					'section' => 'CGh_post_list_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_lists_link',
				array(
					'selector' => '.entry-more a',
					'settings' => 'CGh_lists_link',
					'render_callback' => function () {
						return get_theme_mod( 'CGh_lists_link' );
					},
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	文章页
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_section(
				'CGh_post_page_menu',
				array(
					'title' => __( '文章页', 'text-cgh' ),
					'panel' => 'CGh_panels',
					'priority' => 10,
				)
			);

			// 显示侧边栏
			$wp_customize->add_setting(
				'CGh_posts_sidebar_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_sidebar_open',
				array(
					'label' => __( '显示侧边栏', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示特色图像
			$wp_customize->add_setting(
				'CGh_posts_thumbnail_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_thumbnail_open',
				array(
					'label' => __( '显示特色图像', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示发布日期
			$wp_customize->add_setting(
				'CGh_posts_time_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_time_open',
				array(
					'label' => __( '显示发布日期', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示所属分类
			$wp_customize->add_setting(
				'CGh_posts_category_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_category_open',
				array(
					'label' => __( '显示所属分类', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示浏览量
			$wp_customize->add_setting(
				'CGh_posts_postview_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_postview_open',
				array(
					'label' => __( '显示浏览量', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示评论按钮
			$wp_customize->add_setting(
				'CGh_posts_comment_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_comment_open',
				array(
					'label' => __( '显示评论按钮', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示点赞按钮
			$wp_customize->add_setting(
				'CGh_posts_like_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_like_open',
				array(
					'label' => __( '显示点赞按钮', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示分享按钮
			$wp_customize->add_setting(
				'CGh_posts_share_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_share_open',
				array(
					'label' => __( '显示分享按钮', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 分享设置
			$wp_customize->add_setting(
				'CGh_posts_share',
				array(
					'default' => 'weibo,qq,wechat,tencent,qzone',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_posts_share',
				array(
					'label' => __( '分享设置', 'text-cgh' ),
					'description' => __( '多个属性请用英文逗号（,）隔开<br>weibo,qq,wechat,tencent,douban,<br>qzone,linkedin,diandian,facebook,twitter,google<br><a href="https://github.com/overtrue/share.js" target="_blank">Github share.js</a>', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 显示赞赏按钮
			$wp_customize->add_setting(
				'CGh_posts_reward_open',
				array(
					'default' => false,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_reward_open',
				array(
					'label' => __( '显示赞赏按钮', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 赞赏图片
			$wp_customize->add_setting(
				'CGh_posts_reward',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'CGh_posts_reward',
					array(
						'label' => __( '赞赏图片', 'text-cgh' ),
						'section' => 'CGh_post_page_menu',
						'priority' => 10,
					)
				)
			);

			// 显示标签
			$wp_customize->add_setting(
				'CGh_posts_tag_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_tag_open',
				array(
					'label' => __( '显示标签', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示上下篇
			$wp_customize->add_setting(
				'CGh_posts_prevnext_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_prevnext_open',
				array(
					'label' => __( '显示上下篇', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示文章版权
			$wp_customize->add_setting(
				'CGh_posts_copytight_open',
				array(
					'default' => false,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_copytight_open',
				array(
					'label' => __( '显示文章版权', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 版权内容
			$wp_customize->add_setting(
				'CGh_posts_copytight',
				array(
					'default' => __( '本文是从Internet上收集的，版权属于原始作者或组织 如果此文章侵犯了您的权益，请通过电子邮件<a href="mailto:hi@cghook.com">hi@cghook.com</a>与我们联系！', 'text-cgh' ),
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'wp_kses_post',
					'transport' => $postMessage,
				)
			);

			$wp_customize->add_control(
				'CGh_posts_copytight',
				array(
					'label' => __( '版权内容', 'text-cgh' ),
					'description' => esc_html__( '文章全局版权，可以使用html  例如： <a href="">版权声明</a>', 'text-cgh' ),
					'section' => 'CGh_post_page_menu',
					'priority' => 10,
					'type' => 'textarea',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_posts_copytight',
				array(
					'selector' => '.sin-copytight span',
					'settings' => 'CGh_posts_copytight',
					'render_callback' => function () {
						return get_theme_mod( 'CGh_posts_copytight' );
					},
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	随机文章
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_section(
				'CGh_random_menu',
				array(
					'title' => __( '随机文章', 'text-cgh' ),
					'panel' => 'CGh_panels',
					'priority' => 10,
				)
			);

			// 显示首页随机文章
			$wp_customize->add_setting(
				'CGh_home_random_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_home_random_open',
				array(
					'label' => __( '显示【首页】随机文章', 'text-cgh' ),
					'description' => __( '首页底部', 'text-cgh' ),
					'section' => 'CGh_random_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示分类随机文章
			$wp_customize->add_setting(
				'CGh_archive_random_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_archive_random_open',
				array(
					'label' => __( '显示【分类页】随机文章', 'text-cgh' ),
					'description' => __( '所有分类以及归档底部', 'text-cgh' ),
					'section' => 'CGh_random_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 显示文章随机文章
			$wp_customize->add_setting(
				'CGh_posts_random_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_posts_random_open',
				array(
					'label' => __( '显示【文章页】随机文章', 'text-cgh' ),
					'description' => __( '所有文章页底部', 'text-cgh' ),
					'section' => 'CGh_random_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 随机文章标题
			$wp_customize->add_setting(
				'CGh_random_title',
				array(
					'default' => __( '猜你喜欢', 'text-cgh' ),
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => $postMessage,
				)
			);

			$wp_customize->add_control(
				'CGh_random_title',
				array(
					'label' => __( '随机文章标题', 'text-cgh' ),
					'description' => __( '全局标题，默认猜你喜欢', 'text-cgh' ),
					'section' => 'CGh_random_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_random_title',
				array(
					'selector' => '.random h2',
					'settings' => 'CGh_random_title',
					'render_callback' => function () {
						return get_theme_mod( 'CGh_random_title' );
					},
				)
			);

			// 随机文章显示数量
			$wp_customize->add_setting(
				'CGh_random_number',
				array(
					'default' => 3,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'absint',
				)
			);

			$wp_customize->add_control(
				'CGh_random_number',
				array(
					'label' => __( '随机文章显示数量', 'text-cgh' ),
					'description' => __( '文章显示数量，默认3列排版，显示3篇，建议不超过6篇，不可为空', 'text-cgh' ),
					'section' => 'CGh_random_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 随机文章排序方式
			$wp_customize->add_setting(
				'CGh_random_orderby',
				array(
					'default' => 'rand',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' ),
				)
			);

			$wp_customize->add_control(
				'CGh_random_orderby',
				array(
					'label' => __( '随机文章排序方式', 'text-cgh' ),
					'description' => __( '文章以什么排序方式进行显示，默认随机顺序', 'text-cgh' ),
					'section' => 'CGh_random_menu',
					'priority' => 10,
					'type' => 'select',
					'choices' => $orderby,
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	站点底部
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_section(
				'CGh_footer_menu',
				array(
					'title' => __( '站点底部', 'text-cgh' ),
					'panel' => 'CGh_panels',
					'priority' => 10,
				)
			);

			// 显示底部站点标题
			$wp_customize->add_setting(
				'CGh_foo_site_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_foo_site_open',
				array(
					'label' => __( '显示底部站点标题', 'text-cgh' ),
					'section' => 'CGh_footer_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 底部介绍
			$wp_customize->add_setting(
				'CGh_foo_site_desc',
				array(
					'default' => __( '欢迎您访问我的小栈！我是菜鸟设计师、前端开发爱好者您可以看到我转发的一些教程、资源、工具、站点等推荐无需付费、帐户注册或电子邮件订阅如果您有收获也想保持这个网站正常运行，请考虑支持我<a href="">♥ 捐赠 ♥</a>', 'text-cgh' ),
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'wp_kses_post',
					'transport' => $postMessage,
				)
			);

			$wp_customize->add_control(
				'CGh_foo_site_desc',
				array(
					'label' => __( '底部介绍', 'text-cgh' ),
					'description' => esc_html__( '可以使用html 例如： <a href="">♥ 捐赠 ♥</a>', 'text-cgh' ),
					'section' => 'CGh_footer_menu',
					'priority' => 10,
					'type' => 'textarea',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_foo_site_desc',
				array(
					'selector' => '.foo-site-title-desc',
					'settings' => 'CGh_foo_site_desc',
					'render_callback' => function () {
						return get_theme_mod( 'CGh_foo_site_desc' );
					},
				)
			);

			// 备案号
			$wp_customize->add_setting(
				'CGh_record',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_record',
				array(
					'label' => __( '备案号', 'text-cgh' ),
					'section' => 'CGh_footer_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 统计代码
			$wp_customize->add_setting(
				'CGh_statistics',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => '',
				)
			);

			$wp_customize->add_control(
				'CGh_statistics',
				array(
					'label' => __( '统计代码', 'text-cgh' ),
					'section' => 'CGh_footer_menu',
					'priority' => 10,
					'type' => 'textarea',
				)
			);

			// 显示返回顶部
			$wp_customize->add_setting(
				'CGh_totop_open',
				array(
					'default' => true,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_totop_open',
				array(
					'label' => __( '显示返回顶部', 'text-cgh' ),
					'section' => 'CGh_footer_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_totop_open',
				array(
					'selector' => '.site-top i',
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	社交
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_section(
				'CGh_follow_menu',
				array(
					'title' => __( '社交', 'text-cgh' ),
					'panel' => 'CGh_panels',
					'priority' => 10,
				)
			);

			// 显示社交
			$wp_customize->add_setting(
				'CGh_follow_open',
				array(
					'default' => false,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_follow_open',
				array(
					'label' => __( '显示社交', 'text-cgh' ),
					'description' => __( '请填写带有http://，https://的完整链接，或者填写个人用户的ID/用户名', 'text-cgh' ),
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_follow_open',
				array(
					'selector' => '.follow',
				)
			);

			// QQ
			$wp_customize->add_setting(
				'CGh_link_qq',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_qq',
				array(
					'label' => __( 'QQ', 'text-cgh' ),
					'description' => '123456',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'number',
					),
				)
			);

			// Weibo
			$wp_customize->add_setting(
				'CGh_link_weibo',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_weibo',
				array(
					'label' => __( 'Weibo', 'text-cgh' ),
					'description' => 'http://weibo.com/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Behance
			$wp_customize->add_setting(
				'CGh_link_behance',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_behance',
				array(
					'label' => 'Behance',
					'description' => 'http://behance.net/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Dribbble
			$wp_customize->add_setting(
				'CGh_link_dribbble',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_dribbble',
				array(
					'label' => 'Dribbble',
					'description' => 'http://dribbble.com/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Github
			$wp_customize->add_setting(
				'CGh_link_github',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_github',
				array(
					'label' => 'Github',
					'description' => 'http://github.com/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Vimeo
			$wp_customize->add_setting(
				'CGh_link_vimeo',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_vimeo',
				array(
					'label' => 'Vimeo',
					'description' => 'http://vimeo.com/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Youtube
			$wp_customize->add_setting(
				'CGh_link_youtube',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_youtube',
				array(
					'label' => 'Youtube',
					'description' => 'http://youtube.com/channel/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Twitch
			$wp_customize->add_setting(
				'CGh_link_twitch',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_twitch',
				array(
					'label' => 'Twitch',
					'description' => 'http://twitch.tv/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Instagram
			$wp_customize->add_setting(
				'CGh_link_instagram',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_instagram',
				array(
					'label' => 'Instagram',
					'description' => 'http://instagram.com/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Facebook
			$wp_customize->add_setting(
				'CGh_link_facebook',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_facebook',
				array(
					'label' => 'Facebook',
					'description' => 'http://facebook.com/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Twitter
			$wp_customize->add_setting(
				'CGh_link_twitter',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_twitter',
				array(
					'label' => 'Tumblr',
					'description' => 'http://twitter.com/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Telegram
			$wp_customize->add_setting(
				'CGh_link_telegram',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_telegram',
				array(
					'label' => 'Telegram',
					'description' => 'http://t.me/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Linkedin
			$wp_customize->add_setting(
				'CGh_link_linkedin',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_linkedin',
				array(
					'label' => 'Linkedin',
					'description' => 'http://linkedin.com/in/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Steam
			$wp_customize->add_setting(
				'CGh_link_steam',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_steam',
				array(
					'label' => 'Steam',
					'description' => 'http://steamcommunity.com/id/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// Pinterest
			$wp_customize->add_setting(
				'CGh_link_pinterest',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_pinterest',
				array(
					'label' => 'Pinterest',
					'description' => 'http://pinterest.com/yourname',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			// 500px
			$wp_customize->add_setting(
				'CGh_link_500px',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				'CGh_link_500px',
				array(
					'label' => '500px',
					'description' => 'http://500px.com/p/yourname?view=photos',
					'section' => 'CGh_follow_menu',
					'priority' => 10,
					'type' => 'text',
					'input_attrs' => array(
						'placeholder' => 'ID or Name',
					),
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	二维码
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_section(
				'CGh_qrcode_menu',
				array(
					'title' => __( '二维码', 'text-cgh' ),
					'panel' => 'CGh_panels',
					'priority' => 10,
				)
			);

			// 显示二维码
			$wp_customize->add_setting(
				'CGh_qrcode_open',
				array(
					'default' => false,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_qrcode_open',
				array(
					'label' => __( '显示二维码', 'text-cgh' ),
					'section' => 'CGh_qrcode_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 二维码按钮
			$wp_customize->add_setting(
				'CGh_qrcode_title',
				array(
					'default' => __( '关注我们实时更新渠道', 'text-cgh' ),
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => $postMessage,
				)
			);

			$wp_customize->add_control(
				'CGh_qrcode_title',
				array(
					'label' => __( '二维码按钮', 'text-cgh' ),
					'section' => 'CGh_qrcode_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_qrcode_title',
				array(
					'selector' => '.qrcode-toggle',
					'settings' => 'CGh_qrcode_title',
					'render_callback' => function () {
						return get_theme_mod( 'CGh_qrcode_title' );
					},
				)
			);

			// 二维码图片 1
			$wp_customize->add_setting(
				'CGh_qrcode_img_1',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'CGh_qrcode_img_1',
					array(
						'label' => __( '二维码图片 1', 'text-cgh' ),
						'section' => 'CGh_qrcode_menu',
						'priority' => 10,
					)
				)
			);

			// 二维码图片 2
			$wp_customize->add_setting(
				'CGh_qrcode_img_2',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'CGh_qrcode_img_2',
					array(
						'label' => __( '二维码图片 2', 'text-cgh' ),
						'section' => 'CGh_qrcode_menu',
						'priority' => 10,
					)
				)
			);

			// 二维码图片 3
			$wp_customize->add_setting(
				'CGh_qrcode_img_3',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'CGh_qrcode_img_3',
					array(
						'label' => __( '二维码图片 3', 'text-cgh' ),
						'section' => 'CGh_qrcode_menu',
						'priority' => 10,
					)
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	在线客服
			/* -------------------------------------------------------------------------- */

			$wp_customize->add_section(
				'CGh_clerk_menu',
				array(
					'title' => __( '在线客服', 'text-cgh' ),
					'panel' => 'CGh_panels',
					'priority' => 10,
				)
			);

			// 显示在线客服
			$wp_customize->add_setting(
				'CGh_clerk_open',
				array(
					'default' => false,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_clerk_open',
				array(
					'label' => __( '显示在线客服', 'text-cgh' ),
					'description' => __( '腾讯云智服系统，微信可实时回复消息', 'text-cgh' ),
					'section' => 'CGh_clerk_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 在线客服模式
			$wp_customize->add_setting(
				'CGh_clerk_setup',
				array(
					'default' => 'clerk_js',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' ),
				)
			);

			$wp_customize->add_control(
				'CGh_clerk_setup',
				array(
					'label' => __( '在线客服模式', 'text-cgh' ),
					'description' => __( '选择显示模式，填写对应的链接地址或者代码即可推荐使用JS版', 'text-cgh' ),
					'section' => 'CGh_clerk_menu',
					'priority' => 10,
					'type' => 'select',
					'choices' => array(
						'clerk_url' => __( '链接版', 'text-cgh' ),
						'clerk_js' => __( '代码版', 'text-cgh' ),
					)
				)
			);

			// 链接版
			$wp_customize->add_setting(
				'CGh_clerk_url',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'CGh_clerk_url',
				array(
					'label' => __( '链接版', 'text-cgh' ),
					'description' => __( '请在云智服后台获取->设定->网站渠道 <a href="https://yzf.qq.com/" target="_blank">获取链接地址</a>', 'text-cgh' ),
					'section' => 'CGh_clerk_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			// 代码版
			$wp_customize->add_setting(
				'CGh_clerk_js',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => '',
				)
			);

			$wp_customize->add_control(
				'CGh_clerk_js',
				array(
					'label' => __( '代码版', 'text-cgh' ),
					'description' => __( '请在云智服后台->设定->网站渠道 <a href="https://yzf.qq.com/" target="_blank">获取内嵌插件</a>', 'text-cgh' ),
					'section' => 'CGh_clerk_menu',
					'priority' => 10,
					'type' => 'textarea',
				)
			);

			/* -------------------------------------------------------------------------- */
			/*	站点广告
			/* -------------------------------------------------------------------------- */
			$wp_customize->add_section(
				'CGh_adv_menu',
				array(
					'title' => __( '站点广告', 'text-cgh' ),
					'panel' => 'CGh_panels',
					'priority' => 10,
				)
			);

			// 显示顶部横条广告
			$wp_customize->add_setting(
				'CGh_top_adv_open',
				array(
					'default' => false,
					'capability' => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'CGh_top_adv_open',
				array(
					'label' => __( '显示顶部横条广告', 'text-cgh' ),
					'section' => 'CGh_adv_menu',
					'priority' => 10,
					'type' => 'checkbox',
				)
			);

			// 广告标题
			$wp_customize->add_setting(
				'CGh_top_adv_title',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => $postMessage,
				)
			);

			$wp_customize->add_control(
				'CGh_top_adv_title',
				array(
					'label' => __( '广告标题', 'text-cgh' ),
					'section' => 'CGh_adv_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'CGh_top_adv_title',
				array(
					'selector' => '.text-banner a',
					'settings' => 'CGh_top_adv_title',
					'render_callback' => function () {
						return get_theme_mod( 'CGh_top_adv_title' );
					},
				)
			);

			// 广告链接
			$wp_customize->add_setting(
				'CGh_top_adv_url',
				array(
					'default' => '',
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				'CGh_top_adv_url',
				array(
					'label' => __( '广告链接', 'text-cgh' ),
					'section' => 'CGh_adv_menu',
					'priority' => 10,
					'type' => 'text',
				)
			);

		}

		/**
		 * 清理定制器中的选择输入（select、radio）
		 */
		public static function sanitize_select( $input, $setting ) {
			$input = sanitize_key( $input );
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
		}

		/**
		 * 清理定制器中的复选框输入
		 */
		public static function sanitize_checkbox( $checked ) {
			return ( ( isset( $checked ) && true === $checked ) ? true : false );
		}

	}

	// 设置主题定制器设置和控件
	add_action( 'customize_register', array( 'CGh_Customize_Register', 'register' ) );

}

/**
 * 部分刷新功能
 */
if ( !function_exists( 'CGh_site_title_callback' ) ) {
	/**
	 * 站点标题以进行部分刷新
	 */
	function CGh_site_title_callback() {
		bloginfo( 'name' );
	}
}