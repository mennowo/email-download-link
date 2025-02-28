<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

function ed_delete_plugin() {
	global $wpdb;

	delete_option( 'email-download-link' );
	delete_option( 'ed_captcha_widget' );
	delete_option( 'ed_captcha_sitekey' );
	delete_option( 'ed_captcha_secret' );

	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'ed_emaillist' ) );
		
	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'ed_downloadform' ) );
		
	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'ed_pluginconfig' ) );
		
	$wpdb->query( sprintf( "DROP TABLE IF EXISTS %s",
		$wpdb->prefix . 'ed_filter' ) );
}

ed_delete_plugin();