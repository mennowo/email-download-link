<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
if(isset($_GET['ed']))
{
	if($_GET['ed'] == "cron")
	{
		$guid = isset($_GET['guid']) ? sanitize_text_field($_GET['guid']) : '';  
		$guid = trim($guid);
		
		if($guid <> "")
		{
			ed_cls_security::ed_check_guid($guid);
			
			$data = array();
			$data = ed_cls_settings::ed_setting_select(1);
		
			$ed_c_cronurl 			= $data['ed_c_cronurl'];	
			$ed_c_cronmailcontent 	= esc_html(stripslashes($data['ed_c_cronmailcontent']));
			parse_str($ed_c_cronurl, $output);
			
			$ed_c_deletehistory = 0; 
			$ed_c_deletehistory = isset($data['ed_c_deletehistory']) ? $data['ed_c_deletehistory'] : '0';
			if(!is_numeric($ed_c_deletehistory)) { 
				$ed_c_deletehistory = 0; 
			}
			
			if($guid == $output['guid'])
			{
				ed_cls_downloads::ed_download_link_cron_refresh();
				ed_cls_sendemail::ed_sendemail_admincron();
			}
			
			if($ed_c_deletehistory > 0) {
				ed_cls_subscribers::ed_subscriber_delete_days($ed_c_deletehistory);
			}
		}
	}
}
die();
?>