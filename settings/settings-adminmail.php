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
		'ed_c_adminmailoption' => '',
		'ed_c_adminemail' => '',
		'ed_c_adminmailsubject' => '',
		'ed_c_adminmailcontant' => ''
	);
}
else {
	$data = array();
	$data = ed_cls_settings::ed_setting_select(1);
	$form = array(
		'ed_c_id' => $data['ed_c_id'],
		'ed_c_adminmailoption' 	=> $data['ed_c_adminmailoption'],
		'ed_c_adminemail' 		=> $data['ed_c_adminemail'],
		'ed_c_adminmailsubject' => $data['ed_c_adminmailsubject'],
		'ed_c_adminmailcontant' => $data['ed_c_adminmailcontant'],
	);
}

if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes') {
	check_admin_referer('ed_form_edit');

	$form['ed_c_id'] = 1;
	$form['ed_c_adminmailoption'] 	= isset($_POST['ed_c_adminmailoption']) ? sanitize_text_field($_POST['ed_c_adminmailoption']) : '';
	$form['ed_c_adminemail'] 		= isset($_POST['ed_c_adminemail']) ? sanitize_text_field($_POST['ed_c_adminemail']) : '';
	$form['ed_c_adminmailsubject'] 	= isset($_POST['ed_c_adminmailsubject']) ? sanitize_text_field($_POST['ed_c_adminmailsubject']) : '';
	$form['ed_c_adminmailcontant'] 	= isset($_POST['ed_c_adminmailcontant']) ? wp_filter_post_kses($_POST['ed_c_adminmailcontant']) : '';
	
	if ($ed_error_found == false) {	
		$action = "";
		$action = ed_cls_settings::ed_setting_update_adminmail($form);
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
				<label for="ed"><strong><?php _e('Mail to admin', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('To send admin notifications for new download email, This option must be set to YES.', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<select name="ed_c_adminmailoption" id="ed_c_adminmailoption">
					<option value='YES' <?php if($form['ed_c_adminmailoption'] == 'YES') { echo 'selected' ; } ?>>YES</option>
					<option value='NO' <?php if($form['ed_c_adminmailoption'] == 'NO') { echo 'selected' ; } ?>>NO</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Admin email addresses', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Enter the admin email addresses that should receive notifications (separate by comma).', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<input name="ed_c_adminemail" type="text" id="ed_c_adminemail" value="<?php echo esc_html(stripslashes($form['ed_c_adminemail'])); ?>" size="60" maxlength="225" />
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Admin mail subject', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Enter the subject for admin mail. This will send whenever new download email sent to requester.', 'email-download-link'); ?></p></label>
			</th>
			<td>			
				<input name="ed_c_adminmailsubject" type="text" id="ed_c_adminmailsubject" value="<?php echo esc_html(stripslashes($form['ed_c_adminmailsubject'])); ?>" size="60" maxlength="225" />
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Admin mail content', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Enter the mail content for admin. This will send whenever new download email sent to requester.', 'email-download-link'); ?> 
				<br />(Keyword: ###NAME###, ###EMAIL###, ###DOWNLOADLINK###, ###DOWNLOADLINKDIRECT###, ###TITLE###, ###PHONE###)</p></label>
			</th>
			<td>			
				<textarea size="100" id="ed_c_adminmailcontant" rows="10" cols="58" name="ed_c_adminmailcontant"><?php echo esc_html(stripslashes($form['ed_c_adminmailcontant'])); ?></textarea>
			</td>
		</tr>
	</tbody>
	</table>
	<input type="hidden" name="ed_form_submit" value="yes"/>
	<input type="hidden" name="ed_c_id" id="ed_c_id" value="<?php echo $form['ed_c_id']; ?>"/>
	<p class="submit">
	<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'email-posts-to-subscribers'); ?>" type="submit" />
	<input name="cancel" id="cancel" class="button button-primary" value="<?php _e('Cancel', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_cancel('adminmail')" />
	<input name="help" id="help" class="button button-primary" value="<?php _e('Help', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_help()" />
	</p>
	<?php wp_nonce_field('ed_form_edit'); ?>
    </form>
</div>