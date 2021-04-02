<?php
/**
 * 1.底部社交，各大公共平台，自由选择
 * 2.底部二维码，个人二维码、公众号、小程序之类，最多可3张
 *
 * @package CGHook
 */

if ( !function_exists( 'Ch_Walker_Social' ) ) {

	class Ch_Walker_Social {

		// 社交类
		public static function CGh_follows() {
			$follow_links = array();
			$follow_selected = array(
				'qq' => get_theme_mod( 'CGh_link_qq', '' ),
				'weibo' => get_theme_mod( 'CGh_link_weibo', '' ),
				'behance' => get_theme_mod( 'CGh_link_behance', '' ),
				'dribbble' => get_theme_mod( 'CGh_link_dribbble', '' ),
				'github' => get_theme_mod( 'CGh_link_github', '' ),
				'vimeo' => get_theme_mod( 'CGh_link_vimeo', '' ),
				'youtube' => get_theme_mod( 'CGh_link_youtube', '' ),
				'twitch' => get_theme_mod( 'CGh_link_twitch', '' ),
				'instagram' => get_theme_mod( 'CGh_link_instagram', '' ),
				'facebook' => get_theme_mod( 'CGh_link_facebook', '' ),
				'twitter' => get_theme_mod( 'CGh_link_twitter', '' ),
				'telegram' => get_theme_mod( 'CGh_link_telegram', '' ),
				'linkedin' => get_theme_mod( 'CGh_link_linkedin', '' ),
				'steam' => get_theme_mod( 'CGh_link_steam', '' ),
				'pinterest' => get_theme_mod( 'CGh_link_pinterest', '' ),
				'500px' => get_theme_mod( 'CGh_link_500px', '' ),
			);
			foreach ( $follow_selected as $c_key => $c_value ) {
				$link_builder = 'CGh_link_' . $c_key;
				if ( '' !== $c_key && '' !== $c_value ) {
					if ( filter_var( $c_value, FILTER_VALIDATE_URL ) ) {
						$follow_links[ $c_key ] = self::$link_builder( sanitize_text_field( esc_url( $c_value ) ), 'url' );
					} else {
						$follow_links[ $c_key ] = self::$link_builder( sanitize_text_field( esc_attr( $c_value ) ), 'username' );
					}
				}
			}
			return $follow_links;
		}

		public static function CGh_link_qq( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-qq" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//wpa.qq.com/msgrd?v=3&uin=' . $input . '&site=qq&menu=yes" target="_blank"><i class="fa fa-qq" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_weibo( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-weibo" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//weibo.com/' . $input . '" target="_blank"><i class="fa fa-weibo" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_behance( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-behance" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//behance.net/' . $input . '" target="_blank"><i class="fa fa-behance" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_dribbble( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-dribbble" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//dribbble.com/' . $input . '" target="_blank"><i class="fa fa-dribbble" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_github( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-github" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//github.com/' . $input . '" target="_blank"><i class="fa fa-github" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_vimeo( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-vimeo" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//vimeo.com/' . $input . '" target="_blank"><i class="fa fa-vimeo" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_youtube( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//youtube.com/channel/' . $input . '" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_twitch( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-twitch" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//twitch.tv/' . $input . '" target="_blank"><i class="fa fa-twitch" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_instagram( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//instagram.com/' . $input . '" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_facebook( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//facebook.com/' . $input . '" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_twitter( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//twitter.com/' . $input . '" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_telegram( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-telegram" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//t.me/' . $input . '" target="_blank"><i class="fa fa-telegram" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_linkedin( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//linkedin.com/in/yourname' . $input . '" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_steam( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-steam" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//steamcommunity.com/id/yourname' . $input . '" target="_blank"><i class="fa fa-steam" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_pinterest( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//pinterest.com/' . $input . '" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		public static function CGh_link_500px( $input, $type ) {
			if ( 'url' === $type ) {
				$link = '<a href="' . $input . '" target="_blank"><i class="fa fa-500px" aria-hidden="true"></i></a>';
			} else {
				$link = '<a href="//500px.com/p/' . $input . '?view=photos" target="_blank"><i class="fa fa-500px" aria-hidden="true"></i></a>';
			}
			return $link;
		}

		// 二维码类
		public static function CGh_qrcodes() {
			$qrcode_links = array();
			$qrcode_selected = array(
				'img_1' => get_theme_mod( 'CGh_qrcode_img_1', '' ),
				'img_2' => get_theme_mod( 'CGh_qrcode_img_2', '' ),
				'img_3' => get_theme_mod( 'CGh_qrcode_img_3', '' ),
			);
			foreach ( $qrcode_selected as $c_key => $c_value ) {
				$img_builder = 'CGh_qrcode_' . $c_key;
				if ( '' !== $c_key && '' !== $c_value ) {
					if ( filter_var( $c_value, FILTER_VALIDATE_URL ) ) {
						$qrcode_links[ $c_key ] = self::$img_builder( sanitize_text_field( esc_url( $c_value ) ), 'url' );
					}
				}
			}
			return $qrcode_links;
		}

		public static function CGh_qrcode_img_1( $input, $type ) {
			if ( 'url' === $type ) {
				$img = '<span><img src="' . $input . '"></span>';
			}
			return $img;
		}

		public static function CGh_qrcode_img_2( $input, $type ) {
			if ( 'url' === $type ) {
				$img = '<span><img src="' . $input . '"></span>';
			}
			return $img;
		}

		public static function CGh_qrcode_img_3( $input, $type ) {
			if ( 'url' === $type ) {
				$img = '<span><img src="' . $input . '"></span>';
			}
			return $img;
		}

	}
}

function CGh_get_social() {

	// 社交
	$CGh_follow_open = get_theme_mod( 'CGh_follow_open', false );
	$CGh_qrcode_open = get_theme_mod( 'CGh_qrcode_open', false );
	$CGh_qrcode_title = get_theme_mod( 'CGh_qrcode_title', '' );
	if ( $CGh_follow_open || $CGh_qrcode_open ) {
		echo '<div class="widget foo-social">';
		if ( $CGh_follow_open ) {

			$link_values = Ch_Walker_Social::CGh_follows();
			echo '<div class="follow">';
			foreach ( $link_values as $link_key => $link_value ) {
				echo $link_value;
			}
			echo '</div>';

		}

		// 二维码
		if ( $CGh_qrcode_open ) {
			echo '<div class="qrcode">';

			if ( $CGh_qrcode_title ) {
				echo '<a href="#qrcode-btn" class="qrcode-toggle">' . esc_html__( $CGh_qrcode_title ) . '</a>';
				?>
				<script>
					$('a[href="#qrcode-btn"]').click(function(e) {

						$(this).modal({
							fadeDuration: 300,
						});

						e.preventDefault();
					});
				</script>
			<?php
			echo '<div id="qrcode-btn" class="qrcode-box modal"><p>';
			} else {
				echo '<div class="qrcode-box"><p>';
			}
			$img_values = Ch_Walker_Social::CGh_qrcodes();
			foreach ( $img_values as $img_key => $img_value ) {
				echo $img_value;
			}
			echo '</p></div></div>';
		}
		echo '</div><!-- .foo-social end --> ';
	}
}