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
		'ed_c_crontype' => '',
		'ed_c_cronurl' => '',
		'ed_c_cronmailcontent' => '',
		'ed_c_cronrefreshdate' => ''
	);
}
else {
	$data = array();
	$data = ed_cls_settings::ed_setting_select(1);
	$form = array(
		'ed_c_id' => $data['ed_c_id'],
		'ed_c_crontype' => $data['ed_c_crontype'],
		'ed_c_cronurl' => $data['ed_c_cronurl'],
		'ed_c_cronmailcontent' => $data['ed_c_cronmailcontent'],
		'ed_c_cronrefreshdate' => $data['ed_c_cronrefreshdate'],
	);
}

if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes') {
	check_admin_referer('ed_form_edit');

	$form['ed_c_id'] = 1;
	$form['ed_c_crontype'] = isset($_POST['ed_c_crontype']) ? sanitize_text_field($_POST['ed_c_crontype']) : '';
	$form['ed_c_cronmailcontent'] = isset($_POST['ed_c_cronmailcontent']) ? sanitize_text_field($_POST['ed_c_cronmailcontent']) : '';
	
	if ($ed_error_found == false) {	
		$action = "";
		$action = ed_cls_settings::ed_setting_update_cron($form);
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
				<label for="ed"><strong><?php _e('WordPress Cron', 'email-download-link'); ?></strong>
				<p class="description">
				<?php _e('YES : Plugin will use WP CRON option to refresh download URLs. No manual configuration is required.', 'email-download-link'); ?><br />
		  		<?php _e('NO : Plugin will not use WP CRON option to refresh download URLs you have to configure CRON JOB in your server using below Cron job URL.', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<select name="ed_c_crontype" id="ed_c_crontype">
					<option value='Daily' <?php if($form['ed_c_crontype'] == 'Daily') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Daily refresh)', 'email-download-link'); ?></option>
					<option value='Sunday' <?php if($form['ed_c_crontype'] == 'Sunday') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Refresh on every Sunday)', 'email-download-link'); ?></option>
					<option value='Monday' <?php if($form['ed_c_crontype'] == 'Monday') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Refresh on every Monday)', 'email-download-link'); ?></option>
					<option value='Tuesday' <?php if($form['ed_c_crontype'] == 'Tuesday') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Refresh on every Tuesday)', 'email-download-link'); ?></option>
					<option value='Wednesday' <?php if($form['ed_c_crontype'] == 'Wednesday') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Refresh on every Wednesday)', 'email-download-link'); ?></option>
					<option value='Thursday' <?php if($form['ed_c_crontype'] == 'Thursday') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Refresh on every Thursday)', 'email-download-link'); ?></option>
					<option value='Friday' <?php if($form['ed_c_crontype'] == 'Friday') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Refresh on every Friday)', 'email-download-link'); ?></option>
					<option value='Saturday' <?php if($form['ed_c_crontype'] == 'Saturday') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Refresh on every Saturday)', 'email-download-link'); ?></option>
					<option value='SundayWednesday' <?php if($form['ed_c_crontype'] == 'SundayWednesday') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Refresh on every Sunday and Wednesday)', 'email-download-link'); ?></option>
					<option value='MondayWedFriday' <?php if($form['ed_c_crontype'] == 'MondayWedFriday') { echo 'selected="selected"' ; } ?>><?php _e('YES (Use WP CRON, Refresh on every Mon, Wed and Fri)', 'email-download-link'); ?></option>
					<option value='NO' <?php if($form['ed_c_crontype'] == 'NO') { echo 'selected="selected"' ; } ?>>NO (Do not use WP CRON)</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Cron job URL', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Please find your cron job URL. This is read only field not able to modify from admin.', 'email-download-link'); ?></p></label>
			</th>
			<td>
				<input name="ed_c_cronurl" type="text" id="ed_c_cronurl" value="<?php echo esc_html(stripslashes($form['ed_c_cronurl'])); ?>" maxlength="225" size="90"  />
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong><?php _e('Admin mail content', 'email-download-link'); ?></strong>
				<p class="description"><?php _e('Enter the mail content for admin. This will send whenever cron URL is triggered.', 'email-download-link'); ?><br />(Keywords: ###DATE###)</p></label>
			</th>
			<td>			
				<textarea size="100" id="ed_c_cronmailcontent" rows="8" cols="87" name="ed_c_cronmailcontent"><?php echo esc_html(stripslashes($form['ed_c_cronmailcontent'])); ?></textarea>
			</td>
		</tr>
	</tbody>
	</table>
	<input type="hidden" name="ed_form_submit" value="yes"/>
	<input type="hidden" name="ed_c_id" id="ed_c_id" value="<?php echo $form['ed_c_id']; ?>"/>
	<p class="submit">
	<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'email-posts-to-subscribers'); ?>" type="submit" />
	<input name="cancel" id="cancel" class="button button-primary" value="<?php _e('Cancel', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_cancel('cron')" />
	<input name="help" id="help" class="button button-primary" value="<?php _e('Help', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_help()" />
	</p>
	<?php wp_nonce_field('ed_form_edit'); ?>
    </form>
	<?php
	$timestamp = wp_next_scheduled('ed_cron_daily_event');
	$currentday = date_i18n("l");
	$next_run = "";
	if($form['ed_c_crontype'] == "Daily") {
		$next_run = "Tomorrow";
	}
	elseif($form['ed_c_crontype'] == "SundayWednesday") {
		$current_day_num = date("w", strtotime($currentday));
		if($current_day_num < 4) {
			$next_run = "Wednesday";
		}
		else {
			$next_run = "Sunday";
		}
	}
	elseif($form['ed_c_crontype'] == "MondayWedFriday") {
		$current_day_num = date("w", strtotime($currentday));
		if($current_day_num == 0) {
			$next_run = "Monday";
		}
		elseif($current_day_num < 3) {
			$next_run = "Wednesday";
		}
		elseif($current_day_num < 5) {
			$next_run = "Friday";
		}
		else {
			$next_run = "Monday";
		}
	}
	else {
		$next_run = $form['ed_c_crontype'];
	}
	
	if( strtoupper($next_run) == strtoupper($currentday) ) {
		$next_run = "Next " . $next_run;
	}
	?>
	<table class="widefat striped">
		<thead>
			<tr>
				<th scope="col"><?php _e('Hook name', 'email-posts-to-subscribers'); ?></th>
				<th scope="col"><?php _e('Actions', 'email-posts-to-subscribers'); ?></th>
				<th scope="col"><?php _e('Last run', 'email-posts-to-subscribers'); ?></th>
				<th scope="col"><?php _e('Next run', 'email-posts-to-subscribers'); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>ed_cron_downloadlink</td>
				<td><code>ed_cron_trigger_event()</code></td>
				<td><?php echo $form['ed_c_cronrefreshdate']; ?></td>
				<td><?php echo $next_run; ?></td>
			</tr>
		</tbody>
	</table>
</div>