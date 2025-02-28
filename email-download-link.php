<?php
/*
Plugin Name: Email download link
Plugin URI: http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/
Description: This plugin will send a download link to user after they have submitted a form. i.e. Send email with download link to users after signing up. There are lots of reasons you might want to send to a download link to your user after they have submitted a form.
Version: 3.7
Author: Gopi Ramasamy
Donate link: http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/
Author URI: http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/
Text Domain: email-download-link
Domain Path: /languages
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*  
Copyright 2022 Email download link (http://www.gopiplus.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'base'.DIRECTORY_SEPARATOR.'ed-defined.php');
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'ed-stater.php');

add_action('admin_menu', array( 'ed_cls_registerhook', 'ed_adminmenu' ));
register_activation_hook(ED_FILE, array( 'ed_cls_registerhook', 'ed_activation' ));
register_deactivation_hook(ED_FILE, array( 'ed_cls_registerhook', 'ed_deactivation' ));
add_action( 'widgets_init', array( 'ed_cls_registerhook', 'ed_widget_loading' ));
add_action( 'admin_enqueue_scripts', array( 'ed_cls_registerhook', 'ed_load_scripts' ) );
add_action( 'admin_init', array( 'ed_cls_registerhook', 'ed_welcome' ) );
add_action( 'wp_enqueue_scripts', array( 'ed_cls_registerhook', 'ed_load_scripts_front' ) );
add_filter('wp_head', array( 'ed_cls_registerhook', 'ed_load_style_front' ));

//add_shortcode( 'email-download-link', 'emaildownload_shortcode' );
add_shortcode( 'email-download-link', array( 'ed_shortcode', 'load_ed_shortcode' ) );

function ed_textdomain() {
	  load_plugin_textdomain( 'email-download-link' , false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'ed_textdomain');

register_activation_hook(__FILE__, 'ed_cron_activation');
register_deactivation_hook(__FILE__, 'ed_cron_deactivation');
add_action( 'wp_ajax_email_download_link', array( 'ed_senddownload', 'ed_process_download' ), 10 );
add_action( 'wp_ajax_nopriv_email_download_link', array( 'ed_senddownload', 'ed_process_download' ), 10 );
?>