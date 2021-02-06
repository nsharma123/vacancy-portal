<?php if ( is_active_sidebar( lsvr_townpress_get_page_sidebar_right_id() ) ) : ?>
<!-- RIGHT SIDEBAR : begin -->
<aside id="sidebar-right">
	<div class="sidebar-right__inner">

		<?php dynamic_sidebar( lsvr_townpress_get_page_sidebar_right_id() ); ?>

	</div>
</aside>
<!-- RIGHT SIDEBAR : end -->
<?php endif; ?>
