<?php

// Get posts
if ( ! function_exists( 'lsvr_townpress_toolkit_get_posts' ) ) {
    function lsvr_townpress_toolkit_get_posts( $post_type = 'post' ) {

        $posts_parsed = array();

        if ( post_type_exists( $post_type ) ) {

            // Get posts
            $posts = get_posts(array(
                'post_type' => $post_type,
                'posts_per_page' => 1000,
                'orderby' => 'title',
                'order' => 'ASC',
            ));

            // Parse posts
            if ( ! empty( $posts ) ) {
                foreach ( $posts as $post ) {
                    $posts_parsed[ $post->ID ] = $post->post_title;
                }
            }

        }

        return ! empty( $posts_parsed ) ? $posts_parsed : array();

    }
}

// Get taxonomy terms
if ( ! function_exists( 'lsvr_townpress_toolkit_get_terms' ) ) {
	function lsvr_townpress_toolkit_get_terms( $taxonomy ) {

		$terms_parsed = array();

        if ( taxonomy_exists( $taxonomy ) ) {

        	// Get terms
            $tax_terms = get_terms(array(
                'taxonomy' => $taxonomy,
                'orderby' => 'name',
                'hide_empty' => true,
            ));

            // Parse terms
            if ( ! empty( $tax_terms ) ) {
            	foreach ( $tax_terms as $term ) {
            		$terms_parsed[ $term->term_id ] = $term->name;
            	}
            }

        }

        return ! empty( $terms_parsed ) ? $terms_parsed : array();

    }
}

// Get menus
if ( ! function_exists( 'lsvr_townpress_toolkit_get_menus' ) ) {
	function lsvr_townpress_toolkit_get_menus() {

		$return = array();

		$menus = wp_get_nav_menus();
		if ( ! empty( $menus ) ) {
			foreach ( $menus as $menu ) {
				if ( ! empty( $menu->term_id ) && ! empty( $menu->name ) ) {
					$return[ $menu->term_id ] = $menu->name;
				}
			}
		}

		return $return;

	}
}

// Get custom sidebars
if ( ! function_exists( 'lsvr_townpress_toolkit_get_custom_sidebars' ) ) {
    function lsvr_townpress_toolkit_get_custom_sidebars() {

        $return = array();

        $custom_sidebars = get_theme_mod( 'custom_sidebars' );
        if ( ! empty( $custom_sidebars ) && '{' === substr( $custom_sidebars, 0, 1 ) ) {

            $custom_sidebars = (array) json_decode( $custom_sidebars );
            if ( ! empty( $custom_sidebars['sidebars'] ) ) {
                $custom_sidebars = $custom_sidebars['sidebars'];
                foreach ( $custom_sidebars as $sidebar ) {
                    $sidebar = (array) $sidebar;
                    if ( ! empty( $sidebar['id'] ) ) {

                        $sidebar_label = ! empty( $sidebar['label'] ) ? $sidebar['label'] : sprintf( esc_html__( 'Custom Sidebar %d', 'lsvr-townpress-toolkit' ), (int) $sidebar['id'] );
                        $return[ 'lsvr-townpress-custom-sidebar-' . $sidebar['id'] ] = $sidebar_label;

                    }
                }
            }

        }

        return $return;

    }
}

// Get sidebars
if ( ! function_exists( 'lsvr_townpress_toolkit_get_sidebars' ) ) {
    function lsvr_townpress_toolkit_get_sidebars() {

        $sidebar_list = array(
            'lsvr-townpress-default-sidebar-left' => esc_html__( 'Default Left Sidebar', 'lsvr-townpress-toolkit' ),
            'lsvr-townpress-default-sidebar-right' => esc_html__( 'Default Right Sidebar', 'lsvr-townpress-toolkit' ),
        );
        $custom_sidebars = lsvr_townpress_toolkit_get_custom_sidebars();
        if ( ! empty( $custom_sidebars ) ) {
            $sidebar_list = array_merge( $sidebar_list, $custom_sidebars );
        }

        return $sidebar_list;

    }
}

?>