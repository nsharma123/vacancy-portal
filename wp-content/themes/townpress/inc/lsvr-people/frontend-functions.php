<?php

// Person archive grid class
if ( ! function_exists( 'lsvr_townpress_the_person_post_archive_grid_class' ) ) {
	function lsvr_townpress_the_person_post_archive_grid_class() {

		$number_of_columns = ! empty( get_theme_mod( 'lsvr_person_archive_grid_columns', 2 ) ) ? (int) get_theme_mod( 'lsvr_person_archive_grid_columns', 2 ) : 2;
		$span = 12 / $number_of_columns;
		$md_cols = $span > 2 ? 2 : $span;

		echo 'lsvr-grid lsvr-grid--' . esc_attr( $number_of_columns ) . '-cols lsvr-grid--md-' . esc_attr( $md_cols ) . '-cols';

	}
}

// Person archive grid column class
if ( ! function_exists( 'lsvr_townpress_the_person_post_archive_grid_column_class' ) ) {
	function lsvr_townpress_the_person_post_archive_grid_column_class() {

		$number_of_columns = ! empty( get_theme_mod( 'lsvr_person_archive_grid_columns', 2 ) ) ? (int) get_theme_mod( 'lsvr_person_archive_grid_columns', 2 ) : 2;
		$span = 12 / $number_of_columns;
		$span_class = ' lsvr-grid__col--span-' . $span;
		$span_md_class = 3 === $span || 4 === $span || 6 === $span ? ' lsvr-grid__col--md-span-6' : '';

		echo 'lsvr-grid__col ' . esc_attr( $span_class . $span_md_class );

	}
}

// Person role
if ( ! function_exists( 'lsvr_townpress_the_person_role' ) ) {
	function lsvr_townpress_the_person_role( $post_id ) {

		$person_role = lsvr_townpress_get_person_role( $post_id );
		echo ! empty( $person_role ) ? esc_html( $person_role ) : '';

	}
}

// Person contact info
if ( ! function_exists( 'lsvr_townpress_the_person_contact_info' ) ) {
	function lsvr_townpress_the_person_contact_info( $post_id ) {

		if ( lsvr_townpress_has_person_contact_info( $post_id ) ) { ?>

			<ul class="post__contact">

				<?php // Add custom code at the top of person contact info
				do_action( 'lsvr_townpress_person_single_contact_top' ); ?>

				<?php // Phone
				if ( lsvr_townpress_has_person_phone( $post_id ) ) : ?>
					<li class="post__contact-item post__contact-item--phone"><?php echo esc_html( lsvr_townpress_get_person_phone( $post_id) ); ?></li>
				<?php endif; ?>

				<?php // Email
				if ( lsvr_townpress_get_person_email( $post_id ) ) : ?>
					<li class="post__contact-item post__contact-item--email">
						<a href="mailto:<?php echo esc_attr( lsvr_townpress_get_person_email( $post_id ) ); ?>" class="post__contact-item-link"><?php echo esc_html( lsvr_townpress_get_person_email( $post_id ) ); ?></a>
					</li>
				<?php endif; ?>

				<?php // Website
				if ( lsvr_townpress_has_person_website( $post_id ) ) : ?>
					<li class="post__contact-item post__contact-item--website">
						<a href="<?php echo esc_url( lsvr_townpress_get_person_website( $post_id ) ); ?>" class="post__contact-item-link" target="_blank"><?php echo esc_html( lsvr_townpress_get_person_website( $post_id ) ); ?></a>
					</li>
				<?php endif; ?>

				<?php // Add custom code at the bottom of person contact info
				do_action( 'lsvr_townpress_person_single_contact_bottom' ); ?>

			</ul>

		<?php }

	}
}

// Person social links
if ( ! function_exists( 'lsvr_townpress_the_person_social_links' ) ) {
	function lsvr_townpress_the_person_social_links( $post_id ) {

		$social_links = lsvr_townpress_get_person_social_links( $post_id );
		if ( ! empty( $social_links ) ) { ?>

			<ul class="post__social-list">
				<?php foreach ( $social_links as $type => $link ) : ?>
					<li class="post__social-item">
						<a href="<?php echo esc_url( $link ); ?>" class="post__social-link" target="_blank">
							<i class="post__social-icon lsvr_person-social-icon lsvr_person-social-icon--<?php echo esc_attr( $type ); ?>"></i>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

		<?php }

	}
}

?>