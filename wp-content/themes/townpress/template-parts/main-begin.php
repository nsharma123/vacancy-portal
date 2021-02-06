<!-- COLUMNS : begin -->
<div id="columns">
	<div class="columns__inner">
		<div class="lsvr-container">

			<?php if ( lsvr_townpress_has_page_sidebar_left() && lsvr_townpress_has_page_sidebar_right() ) : ?>
				<div class="lsvr-grid">
					<div class="columns__main lsvr-grid__col lsvr-grid__col--span-6 lsvr-grid__col--push-3">
			<?php elseif ( lsvr_townpress_has_page_sidebar_left() ) : ?>
				<div class="lsvr-grid">
					<div class="columns__main lsvr-grid__col lsvr-grid__col--span-9 lsvr-grid__col--push-3">
			<?php elseif ( lsvr_townpress_has_page_sidebar_right() ) : ?>
				<div class="lsvr-grid">
					<div class="columns__main lsvr-grid__col lsvr-grid__col--span-9">
			<?php endif; ?>

			<!-- MAIN : begin -->
			<main id="main">
				<div class="main__inner">