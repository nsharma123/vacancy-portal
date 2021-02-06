<?php
/**
 * Return person social links.
 *
 * @param int 	$person_id		Post ID of lsvr_person post.
 *
 * @return array 	Social links.
 */
if ( ! function_exists( 'lsvr_people_get_person_social_links' ) ) {
	function lsvr_people_get_person_social_links( $person_id ) {

		$social_links = array();
		$social_profiles = array( 'twitter', 'facebook', 'skype', 'linkedin' );

		foreach ( $social_profiles as $profile ) {
			$social_link = get_post_meta( $person_id, 'lsvr_person_' . $profile, true );
			if ( ! empty( $social_link ) ) {
				$social_links[ $profile ] = $social_link;
			}
		}

		return ! empty( $social_links ) ? $social_links : false;

	}
}
?>