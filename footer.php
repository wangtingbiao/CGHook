<?php
/**
 * 页尾
 *
 * @package CGHook
 */

?>
</div>
<!-- #content end -->
<footer id="colophon" class="site-footer" role="contentinfo">
	<?php
	$CGh_foo_site_desc = get_theme_mod( 'CGh_foo_site_desc', '' );
	$CGh_follow_open = get_theme_mod( 'CGh_follow_open', false );
	$CGh_qrcode_open = get_theme_mod( 'CGh_qrcode_open', false );

	if ( $CGh_foo_site_desc || is_active_sidebar( 'footer-sidebar' ) || $CGh_follow_open || $CGh_qrcode_open ):
		?>
	<div class="foo-flex max-w-13">
		<?php

		CGh_get_foo_site();

		if ( is_active_sidebar( 'footer-sidebar' ) ) {
			dynamic_sidebar( 'footer-sidebar' );
		}

		CGh_get_social();

		?>
	</div>
	<?php

	endif;

	CGh_get_copyright();

	?>
	<!-- .copyright end --> 
	
</footer>
<!-- #colophon end -->

</div>
<!-- #sitepage end -->

<?php wp_footer(); ?>
</body></html>