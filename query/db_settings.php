<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class ed_cls_settings
{
	public static function ed_setting_select($id = 1)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		$sSql = "SELECT * FROM `".$prefix."ed_pluginconfig` where 1=1";
		$sSql = $sSql . " and ed_c_id=".$id;
		$arrRes = $wpdb->get_row($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function ed_setting_count($id = "")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = '0';
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT COUNT(*) AS `count` FROM `".$prefix."ed_pluginconfig` WHERE `ed_c_id` = %s", array($id));
		}
		else
		{
			$sSql = "SELECT COUNT(*) AS `count` FROM `".$prefix."ed_pluginconfig`";
		}
		$result = $wpdb->get_var($sSql);
		return $result;
	}
	
	public static function ed_setting_update1($data = array())
	{
		
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("UPDATE `".$prefix."ed_pluginconfig` SET 
			`ed_c_fromname` = %s, `ed_c_fromemail` = %s, `ed_c_mailtype` = %s, `ed_c_adminmailoption` = %s, 
			`ed_c_adminemail` = %s, `ed_c_adminmailsubject` = %s, `ed_c_adminmailcontant` = %s, `ed_c_usermailoption` = %s, 
			`ed_c_usermailsubject` = %s, `ed_c_usermailcontant` = %s, `ed_c_downloadstart` = %s, `ed_c_downloadpgtxt` = %s,
			`ed_c_expiredlinkcontant` = %s, `ed_c_invalidlinkcontant` = %s, `ed_c_savenameemail` = %s, 
			`ed_c_successmessage` = %s, `ed_c_deletehistory` = %d, `ed_c_dowloadlink` = %s  
			 WHERE ed_c_id = %d	LIMIT 1", 
			array($data["ed_c_fromname"], $data["ed_c_fromemail"], $data["ed_c_mailtype"], $data["ed_c_adminmailoption"], 
			$data["ed_c_adminemail"], $data["ed_c_adminmailsubject"], $data["ed_c_adminmailcontant"], $data["ed_c_usermailoption"],
			$data["ed_c_usermailsubject"], $data["ed_c_usermailcontant"],  $data["ed_c_downloadstart"], $data["ed_c_downloadpgtxt"],  
			$data["ed_c_expiredlinkcontant"],  $data["ed_c_invalidlinkcontant"],  $data["ed_c_savenameemail"],  
			$data["ed_c_successmessage"],  $data["ed_c_deletehistory"],  $data["ed_c_dowloadlink"],  
			$data["ed_c_id"]));
		$wpdb->query($sSql);
		
		return "sus";
	}
	
	public static function ed_setting_update3()
	{
		
		global $wpdb;
		$prefix = $wpdb->prefix;
		$currentdate = date('Y-m-d G:i:s'); 
		
		$sSql = $wpdb->prepare("UPDATE `".$prefix."ed_pluginconfig` SET `ed_c_cronrefreshdate` = %s LIMIT 1", 
		array($currentdate ));
		$wpdb->query($sSql);
		
		return "sus";
	}
	
	public static function ed_setting_update_downloadmail($data = array()) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("UPDATE ".$prefix."ed_pluginconfig SET 
		ed_c_usermailsubject = %s, ed_c_usermailcontant = %s WHERE ed_c_id = %d LIMIT 1", 
		array($data["ed_c_usermailsubject"], $data["ed_c_usermailcontant"], $data["ed_c_id"]));
		$wpdb->query($sSql);
		return "sus";
	}

	public static function ed_setting_update_adminmail($data = array()) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("UPDATE ".$prefix."ed_pluginconfig SET ed_c_adminmailoption = %s, 
		ed_c_adminemail = %s, ed_c_adminmailsubject = %s, ed_c_adminmailcontant = %s WHERE ed_c_id = %d LIMIT 1", 
		array($data["ed_c_adminmailoption"], $data["ed_c_adminemail"], $data["ed_c_adminmailsubject"], $data["ed_c_adminmailcontant"], $data["ed_c_id"]));
		$wpdb->query($sSql);
		return "sus";
	}
	
	public static function ed_setting_update_messages($data = array()) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("UPDATE ".$prefix."ed_pluginconfig SET ed_c_expiredlinkcontant = %s, ed_c_invalidlinkcontant = %s, ed_c_successmessage = %s, 
		ed_c_toofastmessage = %s, ed_c_blockedmessage1 = %s, ed_c_blockedmessage2 = %s WHERE ed_c_id = %d LIMIT 1", 
		array($data["ed_c_expiredlinkcontant"], $data["ed_c_invalidlinkcontant"], $data["ed_c_successmessage"], $data["ed_c_toofastmessage"],  
		$data["ed_c_blockedmessage1"],  $data["ed_c_blockedmessage2"], $data["ed_c_id"]));
		$wpdb->query($sSql);
		return "sus";
	}
	
	public static function ed_setting_update_gdpr($data = array()) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("UPDATE ".$prefix."ed_pluginconfig SET ed_c_savenameemail = %s, ed_c_gdprstatus = %s, 
		ed_c_gdprlink = %s, ed_c_gdprmessage = %s WHERE ed_c_id = %d LIMIT 1", 
		array($data["ed_c_savenameemail"], $data["ed_c_gdprstatus"], $data["ed_c_gdprlink"], $data["ed_c_gdprmessage"], $data["ed_c_id"]));
		$wpdb->query($sSql);
		return "sus";
	}
	
	public static function ed_setting_update_general($data = array()) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("UPDATE ".$prefix."ed_pluginconfig SET ed_c_fromname = %s, ed_c_fromemail = %s, ed_c_mailtype = %s, 
		ed_c_deletehistory = %s, ed_c_dowloadlink = %s WHERE ed_c_id = %d LIMIT 1", 
		array($data["ed_c_fromname"], $data["ed_c_fromemail"], $data["ed_c_mailtype"], 
		$data["ed_c_deletehistory"], $data["ed_c_dowloadlink"], $data["ed_c_id"]));
		$wpdb->query($sSql);
		return "sus";
	}
	
	public static function ed_setting_update_cron($data = array()) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("UPDATE ".$prefix."ed_pluginconfig SET ed_c_cronmailcontent = %s, ed_c_crontype = %s WHERE ed_c_id = %d LIMIT 1", 
		array($data["ed_c_cronmailcontent"], $data["ed_c_crontype"], $data["ed_c_id"] ));
		$wpdb->query($sSql);
		return "sus";
	}
}
?>