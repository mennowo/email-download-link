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
		'ed_c_savenameemail' => '',
		'ed_c_gdprstatus' => '',
		'ed_c_gdprlink' => '',
		'ed_c_gdprmessage' => ''
	);
}
else {
	$data = array();
	$data = ed_cls_settings::ed_setting_select(1);
	$form = array(
		'ed_c_id' => $data['ed_c_id'],
		'ed_c_savenameemail' => $data['ed_c_savenameemail'],
		'ed_c_gdprstatus' => $data['ed_c_gdprstatus'],
		'ed_c_gdprlink' => $data['ed_c_gdprlink'],
		'ed_c_gdprmessage' => $data['ed_c_gdprmessage'],
	);
}

if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes') {
	check_admin_referer('ed_form_edit');

	$form['ed_c_id'] = 1;
	$form['ed_c_savenameemail'] 	= isset($_POST['ed_c_savenameemail']) ? sanitize_text_field($_POST['ed_c_savenameemail']) : '';
	$form['ed_c_gdprstatus'] 	= isset($_POST['ed_c_gdprstatus']) ? sanitize_text_field($_POST['ed_c_gdprstatus']) : '';
	$form['ed_c_gdprlink'] 		= isset($_POST['ed_c_gdprlink']) ? wp_filter_post_kses($_POST['ed_c_gdprlink']) : '';
	$form['ed_c_gdprmessage'] 	= isset($_POST['ed_c_gdprmessage']) ? wp_filter_post_kses($_POST['ed_c_gdprmessage']) : '';
	
	if ($ed_error_found == false) {	
		$action = "";
		$action = ed_cls_settings::ed_setting_update_gdpr($form);
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
				<label for="ed"><strong><?php _e('Save downloader name/email', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Set NO if you do not want to save downloader name and email, instead plugin use default name and email to count the download history.', 'email-download-link'); ?></p></label>
			</th>
			<td>			
				<select name="ed_c_savenameemail" id="ed_c_savenameemail">
					<option value='YES' <?php if($form['ed_c_savenameemail'] == 'YES') { echo 'selected' ; } ?>>YES</option>
					<option value='NO' <?php if($form['ed_c_savenameemail'] == 'NO') { echo 'selected' ; } ?>>NO</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="ed"><strong><?php _e('Enable GDPR', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('To enable GDPR check box in the download form, this option must be set to YES. Name and email will be saved only if the above save downloader option is YES and user select the GDPR check box in the download form if GDPR is enabled.', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<select name="ed_c_gdprstatus" id="ed_c_gdprstatus">
					<option value='NO' <?php if($form['ed_c_gdprstatus'] == 'NO') { echo 'selected' ; } ?>>NO</option>
					<option value='YES' <?php if($form['ed_c_gdprstatus'] == 'YES') { echo 'selected' ; } ?>>YES</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('GDPR text', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Text to display after GDPR checkbox in the download form.', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<textarea size="100" id="ed_c_gdprlink" rows="3" cols="58" name="ed_c_gdprlink"><?php echo esc_html(stripslashes($form['ed_c_gdprlink'])); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('GDPR description', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Detailed description for GDPR checkbox.', 'email-download-link'); ?></p></label>
			</th>
			<td>			
				<textarea size="100" id="ed_c_gdprmessage" rows="3" cols="58" name="ed_c_gdprmessage"><?php echo esc_html(stripslashes($form['ed_c_gdprmessage'])); ?></textarea>
			</td>
		</tr>
	</tbody>
	</table>
	<input type="hidden" name="ed_form_submit" value="yes"/>
	<input type="hidden" name="ed_c_id" id="ed_c_id" value="<?php echo $form['ed_c_id']; ?>"/>
	<p class="submit">
	<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'email-posts-to-subscribers'); ?>" type="submit" />
	<input name="cancel" id="cancel" class="button button-primary" value="<?php _e('Cancel', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_cancel('gdpr')" />
	<input name="help" id="help" class="button button-primary" value="<?php _e('Help', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_help()" />
	</p>
	<?php wp_nonce_field('ed_form_edit'); ?>
    </form>
</div>