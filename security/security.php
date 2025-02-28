<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php ed_cls_common::ed_check_latest_update(); ?>
<div class="wrap">
	<div id="icon-themes" class="icon32"></div>
	<h2><?php _e(ED_PLUGIN_DISPLAY, 'email-download-link'); ?></h2>
	<?php settings_errors(); ?>
	<?php
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'filter';
	?>
	<h2 class="nav-tab-wrapper">
		<a href="?page=ed-security&tab=filter" class="nav-tab <?php echo $active_tab == 'filter' ? 'nav-tab-active' : ''; ?>"><?php _e('Security Filter', 'email-download-link'); ?></a>
		<a href="?page=ed-security&tab=recaptcha" class="nav-tab <?php echo $active_tab == 'recaptcha' ? 'nav-tab-active' : ''; ?>"><?php _e('reCaptcha', 'email-download-link'); ?></a>
		<a href="<?php echo ED_FAV; ?>" target="_blank" class="nav-tab"><?php _e('FAQ', 'email-download-link'); ?></a>
		<a href="<?php echo ED_FAV; ?>" target="_blank" class="nav-tab"><?php _e('Help', 'email-download-link'); ?></a>
	</h2>

	<?php
	if( $active_tab == 'recaptcha' ) {
		require_once(ED_DIR.'security'.DIRECTORY_SEPARATOR.'recaptcha-add.php');
	} 
	elseif( $active_tab == 'filter' ) {
		require_once(ED_DIR.'security'.DIRECTORY_SEPARATOR.'filter-add.php');
	} 
	else {
		require_once(ED_DIR.'security'.DIRECTORY_SEPARATOR.'recaptcha-add.php');
	}
	?>
	</form>
	<div class="clear"></div>
</div>