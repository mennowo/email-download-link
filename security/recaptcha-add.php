<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$ed_errors = array();
$ed_success = '';
$ed_error_found = false;

if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes') {
	check_admin_referer('ed_form_add');
	
	$ed_captcha_widget 		= isset($_POST['ed_captcha_widget']) ? wp_filter_post_kses($_POST['ed_captcha_widget']) : '';
	$ed_captcha_sitekey 	= isset($_POST['ed_captcha_sitekey']) ? wp_filter_post_kses($_POST['ed_captcha_sitekey']) : '';
	$ed_captcha_secret 		= isset($_POST['ed_captcha_secret']) ? wp_filter_post_kses($_POST['ed_captcha_secret']) : '';

	if ($ed_error_found == FALSE) {
		update_option('ed_captcha_widget', $ed_captcha_widget );
		update_option('ed_captcha_sitekey', $ed_captcha_sitekey );
		update_option('ed_captcha_secret', $ed_captcha_secret );
		$ed_success = __('reCaptcha details successfully updated.', 'email-download-link');
	}
}

$ed_captcha_widget = get_option('ed_captcha_widget', '');
if($ed_captcha_widget == "") {
	add_option('ed_captcha_widget', "NO");
}

$ed_captcha_sitekey = get_option('ed_captcha_sitekey', '');
if($ed_captcha_sitekey == "") {
	add_option('ed_captcha_sitekey', "NA");
	$ed_captcha_sitekey = get_option('ed_captcha_sitekey');
}

$ed_captcha_secret = get_option('ed_captcha_secret', '');
if($ed_captcha_secret == "") {
	add_option('ed_captcha_secret', "NA");
	$ed_captcha_secret = get_option('ed_captcha_secret');
}

if ($ed_captcha_sitekey == "NA") {
	$ed_captcha_sitekey = "";
}

if ($ed_captcha_secret == "NA") {
	$ed_captcha_secret = "";
}


if ($ed_error_found == TRUE && isset($ed_errors[0]) == TRUE) {
	?><div class="error fade"><p><strong><?php echo $ed_errors[0]; ?></strong></p></div><?php
}
if ($ed_error_found == FALSE && strlen($ed_success) > 0) {
	?><div class="updated fade"><p><strong><?php echo $ed_success; ?></strong></p></div><?php
}
?>
<style>
.form-table th {
    width: 300px;
}
</style>
<div class="form-wrap">
	<form name="ed_form" method="post" action="#" onsubmit="return _ed_captcha_submit()" >
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"> 
					<label for="elp">
						<strong><?php _e('reCaptcha', 'email-download-link'); ?></strong>
						<p class="description"><?php _e('Add reCaptcha in the download link form.', 'email-download-link'); ?></p>
					</label>
				</th>
				<td>
				 <select name="ed_captcha_widget" id="ed_captcha_widget">
					<option value='NO' <?php if($ed_captcha_widget == 'NO') { echo 'selected="selected"' ; } ?>>NO  - Disable reCaptcha</option>
					<option value='YES' <?php if($ed_captcha_widget == 'YES') { echo 'selected="selected"' ; } ?>>YES - Enable reCaptcha</option>
				  </select>
				</td>
			</tr>
			<tr>
				<th scope="row"> 
					<label for="elp">
						<strong><?php _e('reCaptcha Secret key', 'email-download-link'); ?></strong>
						<p class="description"><?php _e('Please enter your secret key for reCaptcha.', 'email-download-link'); ?></p>
					</label>
				</th>
				<td>
					<input name="ed_captcha_secret" type="text" id="ed_captcha_secret" value="<?php echo $ed_captcha_secret; ?>" maxlength="225" size="75"  />
				</td>
			</tr>
			<tr>
				<th scope="row"> 
					<label for="elp">
						<strong><?php _e('reCaptcha Site key', 'email-download-link'); ?></strong>
						<p class="description"><?php _e('Please enter your site key for reCaptcha.', 'email-download-link'); ?></p>
					</label>
				</th>
				<td>
					<input name="ed_captcha_sitekey" type="text" id="ed_captcha_sitekey" value="<?php echo $ed_captcha_sitekey; ?>" maxlength="225" size="75"  />
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="ed_form_submit" value="yes"/>
	<p class="submit">
		<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'email-download-link'); ?>" type="submit" />
		<input name="cancel" id="cancel" class="button button-primary" onclick="_ed_security_redirect('recaptcha')" value="<?php _e('Cancel', 'email-download-link'); ?>" type="button" />
		<input name="help" id="help" class="button button-primary" onclick="_ed_security_help()" value="<?php _e('Help', 'email-download-link'); ?>" type="button" />
	</p>
	<?php wp_nonce_field('ed_form_add'); ?>
	</form>
</div>