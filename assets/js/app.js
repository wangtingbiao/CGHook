/**
 * 全局启用
 *
 * @package CGHook
 */

(function ($) {
	'use strict';

	var _timer = null, // 初始化定时器
		_navbtn = $('#nav-btn'), // 头部菜单按钮
		_submenu = $('.nav .sub-menu'), // 默认子菜单
		_sitetop = $('#site-top'); // 返回顶部

	// 子菜单添加字体图标
	_submenu.before("<i class='fa fa-chevron-down'></i>");

	// 移动菜单
	_navbtn.on('click', function (e) {

		$('body').toggleClass('nav-active');

		if ($(this).find('i').hasClass('fa-bars')) {
			$(this).find('i').switchClass('fa-bars', 'fa-close', 200);
		} else {
			$(this).find('i').switchClass('fa-close', 'fa-bars', 200);
		}
		e.stopPropagation();

	});

	// 动态监测延迟
	$(window).resize(function () {
		clearTimeout(_timer);
		_timer = setTimeout(function () {
			setDelay();
		}, 0);
	});

	$(function () {
		setDelay();
	});

	function setDelay() {

		var winWidth = $(window).width(), // 获取可视窗口总宽度
			winHeight = $(window).height(), // 获取可视窗口总高度
			_headerheight = $('#masthead').outerHeight(true), // 头部高度（包含内外边距）
			_navbox = $('#nav-box'), // 菜单盒子
			_counter = false; // 子菜单点击计数

		$('#content').css('padding-top', _headerheight); // 动态计算-页面主体距离顶部高度

		// 小于992px
		if (winWidth <= 992) {
			_navbox.css('height', winHeight - _headerheight); // 菜单盒子距离顶部高度+高度

			// 移动->点击打开当前子菜单关闭其他子菜单
			_submenu.prev('i').on('click', function (e) {
				if ((_counter = !_counter)) {
					$(this).switchClass('fa-chevron-down', 'fa-chevron-up', 200).next().slideDown();
					$(this).parents('li').siblings().slideUp();
				} else {
					$(this).switchClass('fa-chevron-up', 'fa-chevron-down', 200).next().slideUp();
					$(this).parents('li').siblings().slideDown().prev('i');
				}
				e.stopPropagation();
			});

		} else {

			_navbox.removeAttr('style'); // 移除菜单盒子内联样式

			// 桌面->鼠标滑过显示子菜单
			_submenu.parents('li').hover(
				function (e) {
					$(this).find('ul').slideDown().prev('i').switchClass('fa-chevron-down', 'fa-chevron-up', 200);
					e.stopPropagation();
				},
				function (e) {
					$(this).find('ul').slideUp().prev('i').switchClass('fa-chevron-up', 'fa-chevron-down', 200);
					e.stopPropagation();
				}
			);

		}
	}

	// 搜索
	$('a[href="#sea-btn"]').click(function (e) {

		$(this).modal({
			fadeDuration: 300,
		});

		e.stopPropagation();
	});

	// 缓动返回顶部
	_sitetop.on('click', function (e) {
		$('html,body').animate({
				scrollTop: '0', //滚到顶部
				// scrollTop: $('html').prop("scrollHeight") 滚到底部
			},
			1000
		);
		e.stopPropagation();
	});

	// 距离顶部300显示->到底部隐藏
	$(window).scroll(function (e) {

		if ($(document).scrollTop() <= 300) {
			_sitetop.fadeOut();
		} else if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
			_sitetop.fadeOut();
		} else {
			_sitetop.fadeIn();
		}

		e.stopPropagation();
	});

})(jQuery);
