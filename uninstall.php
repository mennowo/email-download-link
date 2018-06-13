<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

function ed_delete_plugin() {
	global $wpdb;

	delete_option( 'email-download-link' );

	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'ed_emaillist' ) );
		
	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'ed_downloadform' ) );
		
	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'ed_pluginconfig' ) );
}

ed_delete_plugin();