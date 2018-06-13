<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$ed_email_download_link_ver = get_option('email-download-link');
if ( $ed_email_download_link_ver != "1.6.1" ) {
	?><div class="error fade">
		<p>
		Note: You have recently upgraded the plugin and your tables are not sync.
		Please <a title="Sync plugin tables." href="<?php echo ED_ADMINURL; ?>?page=ed-settings&amp;ac=sync"><?php echo __( 'Click Here', 'email-download-link' ); ?></a> to sync the table.
		This is mandatory and it will not affect your data.
		</p>
	</div><?php
}
?>
<div class="wrap">
<?php
$ed_errors = array();
$ed_success = '';
$ed_error_found = false;

$result = ed_cls_settings::ed_setting_count(1);
if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'email-download-link'); ?></strong></p></div><?php
	$form = array(
		'ed_c_id' 				=> '',
		'ed_c_fromname' 		=> '',
		'ed_c_fromemail' 		=> '',
		'ed_c_mailtype' 		=> '',
		'ed_c_adminmailoption' 	=> '',
		'ed_c_adminemail' 		=> '',
		'ed_c_adminmailsubject' => '',
		'ed_c_adminmailcontant' => '',
		'ed_c_usermailoption' 	=> '',
		'ed_c_usermailsubject' 	=> '',
		'ed_c_usermailcontant' 	=> '',
		'ed_c_downloadstart' 	=> '',
		'ed_c_downloadpgtxt' 	=> '',
		'ed_c_crontype' 		=> '',
		'ed_c_cronrefreshdate' 	=> '',
		'ed_c_cronurl' 			=> '',
		'ed_c_cronmailcontent' 	=> ''
	);
}
else
{
	$ed_errors = array();
	$ed_success = '';
	$ed_error_found = false;
	
	$data = array();
	$data = ed_cls_settings::ed_setting_select(1);
		
	// Preset the form fields
	$form = array(
		'ed_c_id' 				=> $data['ed_c_id'],
		'ed_c_fromname' 		=> $data['ed_c_fromname'],
		'ed_c_fromemail' 		=> $data['ed_c_fromemail'],
		'ed_c_mailtype' 		=> $data['ed_c_mailtype'],
		'ed_c_adminmailoption' 	=> $data['ed_c_adminmailoption'],
		'ed_c_adminemail'		=> $data['ed_c_adminemail'],
		'ed_c_adminmailsubject' => $data['ed_c_adminmailsubject'],
		'ed_c_adminmailcontant' => $data['ed_c_adminmailcontant'],
		'ed_c_usermailoption' 	=> $data['ed_c_usermailoption'],
		'ed_c_usermailsubject' 	=> $data['ed_c_usermailsubject'],
		'ed_c_usermailcontant' 	=> $data['ed_c_usermailcontant'],
		'ed_c_downloadstart' 	=> $data['ed_c_downloadstart'],
		'ed_c_downloadpgtxt' 	=> $data['ed_c_downloadpgtxt'],
		'ed_c_crontype' 		=> $data['ed_c_crontype'],
		'ed_c_cronrefreshdate' 	=> $data['ed_c_cronrefreshdate'],
		'ed_c_cronurl' 			=> $data['ed_c_cronurl'],
		'ed_c_cronmailcontent' 	=> $data['ed_c_cronmailcontent']
	);
}

// Form submitted, check the data
if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('ed_form_add');
	
	$ed_c_id 						= isset($_POST['ed_c_id']) ? sanitize_text_field($_POST['ed_c_id']) : '1';
	$ed_c_cronmailcontent 			= isset($_POST['ed_c_cronmailcontent']) ? wp_filter_post_kses($_POST['ed_c_cronmailcontent']) : '';
	$form['ed_c_cronmailcontent'] 	= $ed_c_cronmailcontent;
	$ed_c_crontype 					= isset($_POST['ed_c_crontype']) ? wp_filter_post_kses($_POST['ed_c_crontype']) : '';
	
	//	No errors found, we can add this Group to the table
	if ($ed_error_found == false)
	{
		$action = "";
		$action = ed_cls_settings::ed_setting_update2($ed_c_cronmailcontent, $ed_c_id, $ed_c_crontype);
		
		if($action == "sus")
		{
			$ed_success = __('Details was successfully updated.', 'email-download-link');
		}
		else
		{
			$ed_error_found == true;
			$ed_errors[] = __('Oops, details not update.', 'email-download-link');
		}
	}
}

if ($ed_error_found == true && isset($ed_errors[0]) == true)
{
	?><div class="error fade"><p><strong><?php echo $ed_errors[0]; ?></strong></p></div><?php
}

if ($ed_error_found == false && strlen($ed_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $ed_success; ?></strong></p>
	</div>
	<?php
}
?>
<div class="form-wrap">
	<div id="icon-plugins" class="icon32"></div>
	<h2><?php _e(ED_PLUGIN_DISPLAY, 'email-download-link'); ?></h2>
	<h3><?php _e('Cron Details', 'email-download-link'); ?></h3>
	<form name="ed_form" method="post" action="#" onsubmit="return _ed_submit()"  >
      
	  <label for="tag-link"><?php _e('WordPress Cron', 'email-download-link'); ?></label>
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
		<option value='NO' <?php if($form['ed_c_crontype'] == 'NO') { echo 'selected="selected"' ; } ?>>NO (Do not use WP CRON)</option>
      </select>
      <p>
	  <?php _e('YES : Plugin will use WP CRON option to refresh download URLs. No manual configuration is required.', 'email-download-link'); ?><br />
	  <?php _e('NO : Plugin will not use WP CRON option to refresh download URLs you have to configure CRON JOB in your server using below Cron job URL.', 'email-download-link'); ?>
	  </p>
	  
      <label for="tag-link"><?php _e('Cron job URL', 'email-download-link'); ?></label>
      <input name="ed_c_cronurl" type="text" id="ed_c_cronurl" value="<?php echo esc_html(stripslashes($form['ed_c_cronurl'])); ?>" maxlength="225" size="90"  />
      <p><?php _e('Please find your cron job URL. This is read only field not able to modify from admin.', 'email-download-link'); ?></p>
	  
	  <label for="tag-link"><?php _e('Admin mail content', 'email-download-link'); ?></label>
	  <textarea size="100" id="ed_c_cronmailcontent" rows="8" cols="87" name="ed_c_cronmailcontent"><?php echo esc_html(stripslashes($form['ed_c_cronmailcontent'])); ?></textarea>
	  <p><?php _e('Enter the mail content for admin. This will send whenever cron URL is triggered.', 'email-download-link'); ?><br />(Keywords: ###DATE###)</p>

      <input type="hidden" name="ed_form_submit" value="yes"/>
	  <input type="hidden" name="ed_c_id" id="ed_c_id" value="<?php echo $form['ed_c_id']; ?>"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Submit', 'email-download-link'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_ed_redirect()" value="<?php _e('Cancel', 'email-download-link'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_ed_help()" value="<?php _e('Help', 'email-download-link'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('ed_form_add'); ?>
    </form>
	
	<?php
	$timestamp = wp_next_scheduled('ed_cron_daily_event');
	$currentday = date_i18n("l");
	
	$next_run = "";
	if($form['ed_c_crontype'] == "Daily")
	{
		$next_run = "Tomorrow";
	}
	elseif($form['ed_c_crontype'] == "SundayWednesday")
	{
		$current_day_num = date("w", strtotime($currentday));
		if($current_day_num < 4)
		{
			$next_run = "Wednesday";
		}
		else
		{
			$next_run = "Sunday";
		}
	}
	else
	{
		$next_run = $form['ed_c_crontype'];
	}
	
	if( strtoupper($next_run) == strtoupper($currentday) )
	{
		$next_run = "Next " . $next_run;
	}
	
	?>
	<table class="widefat striped">
		<thead>
			<tr>
				<th scope="col"><?php _e('Hook name', 'email-posts-to-subscribers'); ?></th>
				<th scope="col"><?php _e('Actions', 'email-posts-to-subscribers'); ?></th>
				<th scope="col"><?php _e('Last run', 'email-posts-to-subscribers'); ?></th>
				<th scope="col"><?php _e('Next download link refresh', 'email-posts-to-subscribers'); ?></th>
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
<p class="description"><?php echo ED_OFFICIAL; ?></p>
</div>