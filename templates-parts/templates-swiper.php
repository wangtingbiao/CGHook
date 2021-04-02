<?php
/**
 * 轮播图
 *
 * @link https://swiperjs.com
 *
 * @package CGHook
 */

$CGh_swiper_select = get_theme_mod( 'CGh_swiper_select', 'category' );
$CGh_swiper_number = get_theme_mod( 'CGh_swiper_number', 5 );
$CGh_swiper_category_id = explode( ",", get_theme_mod( 'CGh_swiper_category_id', '' ) );
$CGh_swiper_post_id = explode( ",", get_theme_mod( 'CGh_swiper_post_id', '' ) );
$CGh_swiper_orderby = get_theme_mod( 'CGh_swiper_orderby', 'rand' );

$CGh_swiper_pagination = get_theme_mod( 'CGh_swiper_pagination', true );
$CGh_swiper_navigation = get_theme_mod( 'CGh_swiper_navigation', true );

$CGh_swiper_autoplay_time = get_theme_mod( 'CGh_swiper_autoplay_time', 5000 );
$CGh_swiper_speed = get_theme_mod( 'CGh_swiper_speed', 1000 );
$CGh_swiper_spacebetween = get_theme_mod( 'CGh_swiper_spacebetween', 0 );
$CGh_swiper_slidesperView = get_theme_mod( 'CGh_swiper_slidesperView', 1 );

?>
<div class="swiper-container">
	<div class="swiper-wrapper">
		<?php
		if ( $CGh_swiper_select == 'category' ) {
			$swiper_query = array(
				'ignore_sticky_posts' => true,
				'posts_per_page' => $CGh_swiper_number,
				'cat' => $CGh_swiper_category_id,
				'orderby' => $CGh_swiper_orderby,
			);
		} elseif ( $CGh_swiper_select == 'article' ) {
			$swiper_query = array(
				'ignore_sticky_posts' => true,
				'posts_per_page' => $CGh_swiper_number,
				'post__in' => $CGh_swiper_post_id,
				'orderby' => $CGh_swiper_orderby,
			);
		};

		$swipers_query = new WP_Query( $swiper_query );
		if ( $swipers_query->have_posts() ):
			while ( $swipers_query->have_posts() ): $swipers_query->the_post();
		?>
		<figure class="swiper-slide"><a href="<?php the_permalink(); ?>">
			<?php CGh_get_full_thumbnail(); ?>
			</a>
			<div class="swiper-box">
				<?php the_title( '<h3><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
			</div>
		</figure>
		<!-- .swiper-slide end -->
		
		<?php

		endwhile;
		endif;
		wp_reset_postdata();

		?>
	</div>
	<!-- .swiper-wrapper end -->
	
	<?php

	if ( $CGh_swiper_pagination ) {
		echo '<div class="swiper-pagination"></div>';
	}
	if ( $CGh_swiper_navigation ) {
		echo '<div class="swiper-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
			  <div class="swiper-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>';
	};

	?>
</div>
<!-- .swiper-container end --> 

<script>
	var swiper = new Swiper('.swiper-container',
		{
			<?php
			
			// 自动轮播+停留时间
			if($CGh_swiper_autoplay){
				echo'autoplay: {delay: ' . $CGh_swiper_autoplay_time . ', disableOnInteraction: false,},';
			}
			
			// 动画速度
			echo'speed: ' . $CGh_swiper_speed . ',';
				
			// 轮播间距
			echo'spaceBetween:' . $CGh_swiper_spacebetween . ',';
			
			// 同时显示
			echo'slidesPerView: ' . $CGh_swiper_slidesperView . ',';
			
			?>

			loop: true,
		
			centeredSlides: true,
		
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
		
			navigation: {
				nextEl: '.swiper-next',
				prevEl: '.swiper-prev',
			},
		}
	);
</script>