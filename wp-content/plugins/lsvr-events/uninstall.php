<?php
// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// Remove event occurrences table
global $wpdb;
$occurrences_table_name = esc_attr( $wpdb->prefix ) . 'lsvr_event_occurrences';
$wpdb->query( 'DROP TABLE IF EXISTS ' . $occurrences_table_name );

?>