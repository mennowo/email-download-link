<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php ed_cls_common::ed_check_latest_update(); ?>
<div class="wrap">
	<div id="icon-themes" class="icon32"></div>
	<h2><?php _e(ED_PLUGIN_DISPLAY, 'email-download-link'); ?></h2>
	<?php settings_errors(); ?>
	<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general'; ?>
	<h2 class="nav-tab-wrapper">
		<a href="?page=ed-settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'email-download-link'); ?></a>
		<a href="?page=ed-settings&tab=downloadmail" class="nav-tab <?php echo $active_tab == 'downloadmail' ? 'nav-tab-active' : ''; ?>"><?php _e('Download Mail', 'email-download-link'); ?></a>
		<a href="?page=ed-settings&tab=adminmail" class="nav-tab <?php echo $active_tab == 'adminmail' ? 'nav-tab-active' : ''; ?>"><?php _e('Admin Mail', 'email-download-link'); ?></a>
		<a href="?page=ed-settings&tab=messages" class="nav-tab <?php echo $active_tab == 'messages' ? 'nav-tab-active' : ''; ?>"><?php _e('Messages', 'email-download-link'); ?></a>
		<a href="?page=ed-settings&tab=cron" class="nav-tab <?php echo $active_tab == 'cron' ? 'nav-tab-active' : ''; ?>"><?php _e('Cron Details', 'email-download-link'); ?></a>
		<a href="<?php echo ED_FAV; ?>" target="_blank" class="nav-tab"><?php _e('FAQ', 'email-download-link'); ?></a>
		<a href="<?php echo ED_FAV; ?>" target="_blank" class="nav-tab"><?php _e('Help', 'email-download-link'); ?></a>
		<a href="?page=ed-settings&tab=gdpr" class="nav-tab <?php echo $active_tab == 'gdpr' ? 'nav-tab-active' : ''; ?>"><?php _e('GDPR Consent', 'email-download-link'); ?></a>
	</h2>
	<?php
	if( $active_tab == 'general' ) {
		require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-general.php');
	} 
	elseif( $active_tab == 'downloadmail' ) {
		require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-downloadmail.php');
	} 
	elseif( $active_tab == 'adminmail' ) {
		require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-adminmail.php');
	} 
	elseif( $active_tab == 'messages' ) {
		require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-messages.php');
	} 
	elseif( $active_tab == 'cron' ) {
		require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-cron.php');
	} 
	elseif( $active_tab == 'gdpr' ) {
		require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-gdpr.php');
	} 
	else {
		require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-general.php');
	}
	?>
	</form>
	<div class="clear"></div>
</div>