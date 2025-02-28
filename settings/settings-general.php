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
		'ed_c_fromname' => '',
		'ed_c_fromemail' => '',
		'ed_c_mailtype' => '',
		'ed_c_deletehistory' => '',
		'ed_c_dowloadlink' => ''
	);
}
else {
	$data = array();
	$data = ed_cls_settings::ed_setting_select(1);
	$form = array(
		'ed_c_id' => $data['ed_c_id'],
		'ed_c_fromname' => $data['ed_c_fromname'],
		'ed_c_fromemail' => $data['ed_c_fromemail'],
		'ed_c_mailtype' => $data['ed_c_mailtype'],
		'ed_c_deletehistory' => $data['ed_c_deletehistory'],
		'ed_c_dowloadlink' => $data['ed_c_dowloadlink'],
	);
}

if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes') {
	check_admin_referer('ed_form_edit');

	$form['ed_c_id'] = 1;
	$form['ed_c_fromname'] 	= isset($_POST['ed_c_fromname']) ? sanitize_text_field($_POST['ed_c_fromname']) : '';
	$form['ed_c_fromemail'] = isset($_POST['ed_c_fromemail']) ? sanitize_text_field($_POST['ed_c_fromemail']) : '';
	$form['ed_c_mailtype'] = isset($_POST['ed_c_mailtype']) ? sanitize_text_field($_POST['ed_c_mailtype']) : '';
	$form['ed_c_deletehistory'] = isset($_POST['ed_c_deletehistory']) ? sanitize_text_field($_POST['ed_c_deletehistory']) : '';
	$form['ed_c_dowloadlink'] = isset($_POST['ed_c_dowloadlink']) ? sanitize_text_field($_POST['ed_c_dowloadlink']) : '';
	
	if ($ed_error_found == false) {	
		$action = "";
		$action = ed_cls_settings::ed_setting_update_general($form);
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
				<label for="ed"><strong><?php _e('Sender of notifications', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Choose a FROM name and FROM email address for all emails from this plugin.', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<input name="ed_c_fromname" type="text" id="ed_c_fromname" value="<?php echo esc_html(stripslashes($form['ed_c_fromname'])); ?>" maxlength="225" />
				<input name="ed_c_fromemail" type="text" id="ed_c_fromemail" value="<?php echo esc_html(stripslashes($form['ed_c_fromemail'])); ?>" size="35" maxlength="225" />
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Mail type', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Option 1 & 2 is to send mails with default Wordpress method wp_mail(). Option 3 & 4 is to send mails with PHP method mail()', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<select name="ed_c_mailtype" id="ed_c_mailtype">
					<option value='WP HTML MAIL' <?php if($form['ed_c_mailtype'] == 'WP HTML MAIL') { echo 'selected' ; } ?>>1. WP HTML MAIL</option>
					<option value='WP PLAINTEXT MAIL' <?php if($form['ed_c_mailtype'] == 'WP PLAINTEXT MAIL') { echo 'selected' ; } ?>>2. WP PLAINTEXT MAIL</option>
					<option value='PHP HTML MAIL' <?php if($form['ed_c_mailtype'] == 'PHP HTML MAIL') { echo 'selected' ; } ?>>3. PHP HTML MAIL</option>
					<option value='PHP PLAINTEXT MAIL' <?php if($form['ed_c_mailtype'] == 'PHP PLAINTEXT MAIL') { echo 'selected' ; } ?>>4. PHP PLAINTEXT MAIL</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Auto delete download history', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Automatically delete download history after specific number of days. Plugin use WP CRON option to delete the history.', 'email-download-link'); ?></p></label>
			</th>
			<td>			
				<select name="ed_c_deletehistory" id="ed_c_deletehistory">
					<option value='0' <?php if($form['ed_c_deletehistory'] == '0') { echo 'selected' ; } ?>>Do not delete</option>
					<option value='1' <?php if($form['ed_c_deletehistory'] == '1') { echo 'selected' ; } ?>>Delete after 1 day</option>
					<option value='7' <?php if($form['ed_c_deletehistory'] == '7') { echo 'selected' ; } ?>>Delete after 7 days</option>
					<option value='14' <?php if($form['ed_c_deletehistory'] == '14') { echo 'selected' ; } ?>>Delete after 14 days</option>
					<option value='21' <?php if($form['ed_c_deletehistory'] == '21') { echo 'selected' ; } ?>>Delete after 21 days</option>
					<option value='28' <?php if($form['ed_c_deletehistory'] == '28') { echo 'selected' ; } ?>>Delete after 28 days</option>
					<option value='31' <?php if($form['ed_c_deletehistory'] == '31') { echo 'selected' ; } ?>>Delete after 1 Month</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Show direct download', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('This option is to SHOW or HIDE direct download link in the download page. Set NO if you dont like to show direct download link to your users.', 'email-download-link'); ?></p></label>
			</th>
			<td>			
				<select name="ed_c_dowloadlink" id="ed_c_dowloadlink">
					<option value='YES' <?php if($form['ed_c_dowloadlink'] == 'YES') { echo 'selected' ; } ?>>YES</option>
					<option value='NO' <?php if($form['ed_c_dowloadlink'] == 'NO') { echo 'selected' ; } ?>>NO</option>
				</select>
			</td>
		</tr>
	</tbody>
	</table>
	<input type="hidden" name="ed_form_submit" value="yes"/>
	<input type="hidden" name="ed_c_id" id="ed_c_id" value="<?php echo $form['ed_c_id']; ?>"/>
	<p class="submit">
	<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'email-posts-to-subscribers'); ?>" type="submit" />
	<input name="cancel" id="cancel" class="button button-primary" value="<?php _e('Cancel', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_cancel('general')" />
	<input name="help" id="help" class="button button-primary" value="<?php _e('Help', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_help()" />
	</p>
	<?php wp_nonce_field('ed_form_edit'); ?>
    </form>
</div>