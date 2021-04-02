<?php
/**
 * 页头
 *
 * @package CGHook
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php esc_attr(body_class()); ?>>
<?php wp_body_open(); ?>
<div id="site-page" class="max-w-15">
<header id="masthead" class="site-header" role="banner">
	<div class="site-header-flex max-w-15"><a id="nav-btn" class="navsea-btn nav-btn"><i class="fa fa-bars" aria-hidden="true"></i></a>
		<?php CGh_get_hea_site(); ?>
		<!-- .site-title end -->
		
		<div id="nav-box" class="nav-box">
			<?php if ( has_nav_menu( 'main-menu' ) ) { ?>
			<nav id="nav" class="nav" aria-label="<?php esc_attr_e( 'Horizontal', 'text-cgh' ); ?>" role="navigation">
				<?php

				wp_nav_menu(
					array(
						'container' => '',
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'theme_location' => 'main-menu',
					)
				);

				?>
			</nav>
			<!-- #nav end -->
			
			<?php

			}

			CGh_get_register_login();

			?>
			<!-- .register-login end --> 
			
		</div>
		<a href="#sea-btn" class="navsea-btn sea-btn"><i class="fa fa-search" aria-hidden="true"></i></a>
		<div id="sea-btn" class="search-box modal"><i class="search-icon fa fa-user-secret" aria-hidden="true"></i>
			<p>
				<?php esc_html_e('有深度的搜索','text-cgh');?>
			</p>
			<?php get_search_form(); ?>
		</div>
		<!-- #site-search end --> 
		
	</div>
</header>
<!-- #masthead end -->

<div id="content" class="site-content">
<?php CGh_get_top_adv(); ?>
