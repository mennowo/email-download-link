<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

?>

<div class="wrap">
	<?php
		// Form submitted, check the data
		if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes') {
			check_admin_referer('ed_form_sync');

			$ed_success = __( 'Table sync completed successfully.', 'email-download-link' );
			ed_cls_registerhook::ed_email_download_link_db_update();
			?><div class="notice notice-success is-dismissible">
				<p><strong>
					<?php echo $ed_success; ?>
				</strong></p>
			</div><?php
		}
	?>
	<div class="form-wrap">
		<div id="icon-plugins" class="icon32"></div>
		<h2><?php echo __( ED_PLUGIN_DISPLAY, 'email-download-link' ); ?></h2>
		<form name="form_sync" id="form_sync" method="post" action="#" >
			<h3 class="title"><?php echo __( 'Sync plugin tables', 'email-download-link' ); ?></h3>
			<input type="hidden" name="ed_form_submit" value="yes"/>
			<div style="padding-top:5px;"></div>
			<p>
				<input type="submit" name="publish" lang="publish" class="button-primary" value="<?php echo __( 'Click to sync tables', 'email-download-link' ); ?>" />
			</p>
			<?php wp_nonce_field('ed_form_sync'); ?>
		</form>
	</div>
</div>