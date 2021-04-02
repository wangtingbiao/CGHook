/**
 * 文章页面独享
 * 
 * @package CGHook
 */

(function ($) {
	'use strict';

	/*------------------------------------------------
	  Ajax喜欢Cookie
	-------------------------------------------------*/
	function getPostLikeCookie(cookieName) {
		var cookieValue = "";
		if (document.cookie && document.cookie != '') {
			var cookies = document.cookie.split(';');
			for (var i = 0; i < cookies.length; i++) {
				var cookie = cookies[i];
				if (cookie.substring(0, cookieName.length + 2).trim() == cookieName.trim() + "=") {
					cookieValue = cookie.substring(cookieName.length + 2, cookie.length);
					break;
				}
			}
		}
		return cookieValue;
	}

	/*------------------------------------------------
	  Ajax喜欢
	-------------------------------------------------*/
	$.fn.postLike = function () {
		if ($(this).hasClass('done')) {

			return false;

		} else {

			$(this).addClass('done');
			$(this).children('i').switchClass('fa-heart-o', 'fa-heart', 200);

			var id = $(this).data("id"),
				action = $(this).data('action'),
				rateHolder = $(this).children('.count');
			var ajax_data = {
				action: "CGh_posts_like",
				um_id: id,
				um_action: action,
			};

			$.post("/wp-admin/admin-ajax.php", ajax_data,
				function (data) {
					$(rateHolder).html(data);
				});
			return false;

		}
	};

	$(document).on("click", "#sin-like-btn", function (e) {

		var post_id = $("#sin-like-btn").attr("data-id");

		if (getPostLikeCookie('CGh_ding_' + post_id) != '') {
			alert('You have already liked it!');
		} else {
			$(this).postLike();
		}

		e.preventDefault();
	});

	/*------------------------------------------------
	  文章目录与锚点
	-------------------------------------------------*/
	$('#anchor-point-toggle').on('click', function (e) {

		$(this).toggleClass('anchor-point-bgcolor').siblings('nav').slideToggle();

		if ($(this).find('i').hasClass('fa-chevron-down')) {
			$(this).find('i').switchClass('fa-chevron-down', 'fa-chevron-up', 200);
		} else {
			$(this).find('i').switchClass('fa-chevron-up', 'fa-chevron-down', 200);
		}

		e.stopPropagation();

	});

	$('#anchor-point-nav a').on('click', function (e) {

		var get_section = $(this).attr('href'),
			section_offset = $(get_section).offset().top;

		$('html,body').animate({
			scrollTop: section_offset,
		}, 1000);

		e.stopPropagation();
	});

	/*------------------------------------------------
	  PLUS按钮
	-------------------------------------------------*/
	$('#sin-plus-btn').on('click', function (e) {

		$(this).prevAll('.sin-like-btn,.sin-reward-btn,.sin-share-btn').slideToggle();
		if ($(this).find('i').hasClass('fa-plus')) {
			$(this).find('i').switchClass('fa-plus', 'fa-remove', 200);
		} else {
			$(this).find('i').switchClass('fa-remove', 'fa-plus', 200);
		}

		e.stopPropagation();
	});

	/*------------------------------------------------
	  评论锚点
	-------------------------------------------------*/
	$('#sin-comment-btn').on('click', function (e) {

		$('html,body').animate({
			scrollTop: $('#sin-comment-box').offset().top
		}, 1000);

		e.stopPropagation();
	});

	/*------------------------------------------------
	  打赏/分享弹窗
	-------------------------------------------------*/
	$('a[href="#sin-reward-btn"],a[href="#sin-share-btn"]').click(function (e) {

		$(this).modal({
			fadeDuration: 300,
			//showClose: false, // 去掉关闭按钮
		});

		e.preventDefault();
	});

})(jQuery);
