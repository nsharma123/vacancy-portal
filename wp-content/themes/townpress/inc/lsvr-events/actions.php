<?php

// Page title
add_filter( 'document_title_parts', 'lsvr_townpress_event_title', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_event_title' ) ) {
	function lsvr_townpress_event_title( $title ) {

		if ( is_post_type_archive( 'lsvr_event' ) ) {
			$title['title'] = sanitize_text_field( lsvr_townpress_get_event_archive_title() );
		}
		return $title;

	}
}

// Breadcrumbs
add_filter( 'lsvr_townpress_add_to_breadcrumbs', 'lsvr_townpress_event_breadcrumbs', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_event_breadcrumbs' ) ) {
	function lsvr_townpress_event_breadcrumbs( $breadcrumbs ) {

		if ( lsvr_townpress_is_event() && ! is_post_type_archive( 'lsvr_event' ) ) {
			$breadcrumbs = array(
				array(
					'url' => get_post_type_archive_link( 'lsvr_event' ),
					'label' => lsvr_townpress_get_event_archive_title(),
				),
			);
		}
		return $breadcrumbs;

	}
}

// Left sidebar ID
add_filter( 'lsvr_townpress_sidebar_left_id', 'lsvr_townpress_event_sidebar_left_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_event_sidebar_left_id' ) ) {
	function lsvr_townpress_event_sidebar_left_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_event' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_event_single_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		// Archive
		else if ( lsvr_townpress_is_event() ) {
			$sidebar_id = get_theme_mod( 'lsvr_event_archive_sidebar_left_id', 'lsvr-townpress-default-sidebar-left' );
		}

		return $sidebar_id;

	}
}

// Right sidebar ID
add_filter( 'lsvr_townpress_sidebar_right_id', 'lsvr_townpress_event_sidebar_right_id', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_event_sidebar_right_id' ) ) {
	function lsvr_townpress_event_sidebar_right_id( $sidebar_id ) {

		// Single
		if ( is_singular( 'lsvr_event' ) ) {
			$sidebar_id = get_theme_mod( 'lsvr_event_single_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		// Archive
		else if ( lsvr_townpress_is_event() ) {
			$sidebar_id = get_theme_mod( 'lsvr_event_archive_sidebar_right_id', 'lsvr-townpress-default-sidebar-right' );
		}

		return $sidebar_id;

	}
}


// Add post meta data
add_action( 'lsvr_townpress_event_single_bottom', 'lsvr_townpress_add_event_single_meta', 10, 2 );
if ( ! function_exists( 'lsvr_townpress_add_event_single_meta' ) ) {
	function lsvr_townpress_add_event_single_meta() { ?>

		<script type="application/ld+json">
		{
			"@context" : "http://schema.org",
			"@type" : "Event",
			"eventStatus" : "EventScheduled",
			"name": "<?php echo esc_js( get_the_title() ); ?>",
			"url" : "<?php echo esc_url( get_permalink() ); ?>",
			"mainEntityOfPage" : "<?php echo esc_url( get_permalink() ); ?>",
		 	"description" : "<?php echo esc_js( get_the_excerpt() ); ?>",
		 	"startDate" : "<?php echo lsvr_townpress_get_next_event_occurrence_start( get_the_ID(), 'Y-m-d H:i:s' ); ?>",
		 	"endDate" : "<?php echo lsvr_townpress_get_next_event_occurrence_end( get_the_ID(), 'Y-m-d H:i:s' ); ?>"

		 	<?php if ( lsvr_townpress_has_event_location( get_the_ID() ) ) : ?>
			,"location" : {
			    "@type" : "Place",
			    "name" : "<?php echo esc_js( lsvr_townpress_get_event_location_name( get_the_ID() ) ); ?>",
			    <?php if ( lsvr_townpress_has_event_location_acurrate_address( get_the_ID() ) ) : ?>
			    "address" : "<?php echo esc_js( lsvr_townpress_get_event_location_accurate_address( get_the_ID() ) ); ?>"
			    <?php elseif ( lsvr_townpress_has_event_location_address( get_the_ID() ) ) : ?>
			    "address" : "<?php echo esc_js( preg_replace( "/\r|\n/", "", lsvr_townpress_get_event_location_address( get_the_ID() ) ) ); ?>"
			    <?php endif; ?>
			}
		 	<?php endif; ?>

			<?php if ( has_post_thumbnail() ) : ?>
		 	,"image": {
		 		"@type" : "ImageObject",
		 		"url" : "<?php the_post_thumbnail_url( 'full' ); ?>",
		 		"width" : "<?php echo esc_js( lsvr_townpress_get_image_width( get_post_thumbnail_id( get_the_ID() ), 'full' ) ); ?>",
		 		"height" : "<?php echo esc_js( lsvr_townpress_get_image_height( get_post_thumbnail_id( get_the_ID() ), 'full' ) ); ?>",
		 		"thumbnailUrl" : "<?php the_post_thumbnail_url( 'thumbnail' ); ?>"
		 	}
		 	<?php endif; ?>

		}
		</script>

	<?php }
}

?>