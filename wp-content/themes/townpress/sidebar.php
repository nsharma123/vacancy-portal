<?php if ( is_active_sidebar( lsvr_townpress_get_page_sidebar_left_id() ) ) : ?>
<!-- LEFT SIDEBAR : begin -->
<aside id="sidebar-left">
	<div class="sidebar-left__inner">

		<?php dynamic_sidebar( lsvr_townpress_get_page_sidebar_left_id() ); ?>

	</div>
</aside>
<!-- LEFT SIDEBAR : end -->
<?php endif; ?>
