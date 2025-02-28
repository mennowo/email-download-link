<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$ed_errors = array();
$ed_success = '';
$ed_error_found = false;

$result = ed_cls_settings::ed_setting_count(1);
if ($result != '1') {
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'email-download-link'); ?></strong></p></div><?php
	$form = array(
		'ed_c_id' => '',
		'ed_c_usermailsubject' => '',
		'ed_c_usermailcontant' => ''
	);
}
else {
	$data = array();
	$data = ed_cls_settings::ed_setting_select(1);
	$form = array(
		'ed_c_id' => $data['ed_c_id'],
		'ed_c_usermailsubject' => $data['ed_c_usermailsubject'],
		'ed_c_usermailcontant' => $data['ed_c_usermailcontant'],
	);
}

if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes') {
	check_admin_referer('ed_form_edit');

	$form['ed_c_id'] = 1;
	$form['ed_c_usermailsubject'] = isset($_POST['ed_c_usermailsubject']) ? sanitize_text_field($_POST['ed_c_usermailsubject']) : '';
	$form['ed_c_usermailcontant'] = isset($_POST['ed_c_usermailcontant']) ? wp_filter_post_kses($_POST['ed_c_usermailcontant']) : '';

	if ($form['ed_c_usermailsubject'] == '') {
		$ed_errors[] = __('Please enter download link mail subject.', 'email-download-link');
		$ed_error_found = true;
	}
	
	if ($form['ed_c_usermailcontant'] == '') {
		$ed_errors[] = __('Please enter download link mail content.', 'email-download-link');
		$ed_error_found = true;
	}
	
	if ($ed_error_found == false) {	
		$action = "";
		$action = ed_cls_settings::ed_setting_update_downloadmail($form);
		if($action == "sus") {
			$ed_success = __('Details was successfully updated.', 'email-download-link');
		}
		else {
			$ed_error_found == true;
			$ed_errors[] = __('Oops.. Unexpected error occurred.', 'email-download-link');
		}
	}
}

if ($ed_error_found == true && count($ed_errors) > 0) {
	if(count($ed_errors) > 0) {
		for($i = 0; $i < count($ed_errors); $i++) {
			?><div class="error fade"><p><strong><?php echo $ed_errors[$i]; ?></strong></p></div><?php
		}
	}
}

if ($ed_error_found == false && strlen($ed_success) > 0) {
	?><div class="updated fade"><p><strong><?php echo $ed_success; ?></strong></p></div><?php
}
?>
<style>
.form-table th {
    width: 350px;
}
</style>
<div class="form-wrap">
	<form name="ed_form" method="post" action="#">
	<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">
				<label for="ed"><strong><?php _e('Download link mail subject', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Enter the mail subject for download link mail. This will send whenever user is requested download link.', 'email-download-link'); ?>
				<br />(Keyword: ###NAME###, ###EMAIL###, ###TITLE###)</p></label>
			</th>
			<td>
				<input name="ed_c_usermailsubject" type="text" id="ed_c_usermailsubject" value="<?php echo esc_html(stripslashes($form['ed_c_usermailsubject'])); ?>" size="60" maxlength="225" />
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Download link mail content', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Enter the mail content for download link mail. This will send whenever user requested the download link.', 'email-download-link'); ?> 
				<br />(Keyword: ###NAME###, ###EMAIL###, ###DOWNLOADLINK###, ###DOWNLOADLINKDIRECT###, ###TITLE###)</p></label>
			</th>
			<td>
				<textarea size="100" id="ed_c_usermailcontant" rows="12" cols="58" name="ed_c_usermailcontant"><?php echo esc_html(stripslashes($form['ed_c_usermailcontant'])); ?></textarea>
			</td>
		</tr>
	</tbody>
	</table>
	<input type="hidden" name="ed_form_submit" value="yes"/>
	<input type="hidden" name="ed_c_id" id="ed_c_id" value="<?php echo $form['ed_c_id']; ?>"/>
	<p class="submit">
	<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'email-posts-to-subscribers'); ?>" type="submit" />
	<input name="cancel" id="cancel" class="button button-primary" value="<?php _e('Cancel', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_cancel('downloadmail')" />
	<input name="help" id="help" class="button button-primary" value="<?php _e('Help', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_help()" />
	</p>
	<?php wp_nonce_field('ed_form_edit'); ?>
    </form>
</div>