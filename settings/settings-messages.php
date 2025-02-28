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
		'ed_c_expiredlinkcontant' => '',
		'ed_c_invalidlinkcontant' => '',
		'ed_c_successmessage' => '',
		'ed_c_toofastmessage' => '',
		'ed_c_blockedmessage1' => '',
		'ed_c_blockedmessage2' => ''
	);
}
else {
	$data = array();
	$data = ed_cls_settings::ed_setting_select(1);
	$form = array(
		'ed_c_id' => $data['ed_c_id'],
		'ed_c_expiredlinkcontant' => $data['ed_c_expiredlinkcontant'],
		'ed_c_invalidlinkcontant' => $data['ed_c_invalidlinkcontant'],
		'ed_c_successmessage' => $data['ed_c_successmessage'],
		'ed_c_toofastmessage' => $data['ed_c_toofastmessage'],
		'ed_c_blockedmessage1' => $data['ed_c_blockedmessage1'],
		'ed_c_blockedmessage2' => $data['ed_c_blockedmessage2'],
	);
}

if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes') {
	check_admin_referer('ed_form_edit');

	$form['ed_c_id'] = 1;
	$form['ed_c_expiredlinkcontant'] = isset($_POST['ed_c_expiredlinkcontant']) ? wp_filter_post_kses($_POST['ed_c_expiredlinkcontant']) : '';
	$form['ed_c_invalidlinkcontant'] = isset($_POST['ed_c_invalidlinkcontant']) ? wp_filter_post_kses($_POST['ed_c_invalidlinkcontant']) : '';
	$form['ed_c_successmessage'] = isset($_POST['ed_c_successmessage']) ? wp_filter_post_kses($_POST['ed_c_successmessage']) : '';
	$form['ed_c_toofastmessage'] = isset($_POST['ed_c_toofastmessage']) ? wp_filter_post_kses($_POST['ed_c_toofastmessage']) : '';
	$form['ed_c_blockedmessage1'] = isset($_POST['ed_c_blockedmessage1']) ? wp_filter_post_kses($_POST['ed_c_blockedmessage1']) : '';
	$form['ed_c_blockedmessage2'] = isset($_POST['ed_c_blockedmessage2']) ? wp_filter_post_kses($_POST['ed_c_blockedmessage2']) : '';
	
	if ($ed_error_found == false) {	
		$action = "";
		$action = ed_cls_settings::ed_setting_update_messages($form);
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
				<label for="ed"><strong><?php _e('Expired link content', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Message to display if download link has expired.', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<textarea size="100" id="ed_c_expiredlinkcontant" rows="3" cols="58" name="ed_c_expiredlinkcontant"><?php echo esc_html(stripslashes($form['ed_c_expiredlinkcontant'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Invalid link content', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Message to display if download link is invalid.', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<textarea size="100" id="ed_c_invalidlinkcontant" rows="3" cols="58" name="ed_c_invalidlinkcontant"><?php echo esc_html(stripslashes($form['ed_c_invalidlinkcontant'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Successful message', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Message to display if download link form submitted successfully.', 'email-download-link'); ?></p></label>
			</th>
			<td>			
				<textarea size="100" id="ed_c_successmessage" rows="3" cols="58" name="ed_c_successmessage"><?php echo esc_html(stripslashes($form['ed_c_successmessage'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Too fast message', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Message to display if user trying to submit download form too fast.', 'email-download-link'); ?></p></label>
			</th>
			<td>			
				<textarea size="100" id="ed_c_toofastmessage" rows="3" cols="58" name="ed_c_toofastmessage"><?php echo esc_html(stripslashes($form['ed_c_toofastmessage'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Blocked message 1', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Message to display if Email/Domain/IP is blocked by plugin security.', 'email-download-link'); ?></p></label>
			</th>
			<td>			
				<textarea size="100" id="ed_c_blockedmessage1" rows="3" cols="58" name="ed_c_blockedmessage1"><?php echo esc_html(stripslashes($form['ed_c_blockedmessage1'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Blocked message 2', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Message to display if entered name or email is in filter list.', 'email-download-link'); ?></p></label>
			</th>
			<td>			
				<textarea size="100" id="ed_c_blockedmessage2" rows="3" cols="58" name="ed_c_blockedmessage2"><?php echo esc_html(stripslashes($form['ed_c_blockedmessage2'])); ?></textarea>
			</td>
		</tr>
	</tbody>
	</table>
	<input type="hidden" name="ed_form_submit" value="yes"/>
	<input type="hidden" name="ed_c_id" id="ed_c_id" value="<?php echo $form['ed_c_id']; ?>"/>
	<p class="submit">
	<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'email-posts-to-subscribers'); ?>" type="submit" />
	<input name="cancel" id="cancel" class="button button-primary" value="<?php _e('Cancel', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_cancel('messages')" />
	<input name="help" id="help" class="button button-primary" value="<?php _e('Help', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_help()" />
	</p>
	<?php wp_nonce_field('ed_form_edit'); ?>
    </form>
</div>