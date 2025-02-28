<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class ed_cls_filter
{
	public static function ed_filter_ins($type = '', $value = '') {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$guid = ed_cls_common::ed_generate_guid(60);
		if($value <> '') {
			$value = strtoupper($value);
		}		
		$sSql = "INSERT INTO " . $prefix . "ed_filter (`ed_blocked_guid`, `ed_blocked_type`, `ed_blocked_value`) VALUES (%s, %s, %s)";
		$sSql = $wpdb->prepare($sSql, $guid, trim($type), trim($value));
		$wpdb->query($sSql);
		return true;
	}
	
	public static function ed_filter_del($id = '') {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("DELETE FROM ".$prefix."ed_filter WHERE ed_blocked_id = %d LIMIT 1", $id);
		$wpdb->query($sSql);
		return true;
	}
	
	public static function ed_filter_count($id = 0) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = '0';
		if($id > 0) {
			$sSql = $wpdb->prepare("SELECT COUNT(*) AS count FROM " . $prefix . "ed_filter WHERE ed_blocked_id = %d", array($id));
		}
		else {
			$sSql = "SELECT COUNT(*) AS count FROM " . $prefix . "ed_filter";
		}
		$result = $wpdb->get_var($sSql);
		return $result;
	}
	
	public static function ed_filter_select($id = 0, $offset = 0, $limit = 0) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		$sSql = "SELECT * FROM " . $prefix . "ed_filter where ed_blocked_type <> 'Squeeze' ";
		if($id > 0) {
			$sSql = $sSql . " and ed_blocked_id = ".$id;
			$arrRes = $wpdb->get_row($sSql, ARRAY_A);
		}
		else {
			$sSql = $sSql . " order by ed_blocked_created desc limit $offset, $limit";
			$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		}
		return $arrRes;
	}
	
	public static function ed_filter_blocked($name = '', $email = '') {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = 0;
			
		// Block by ALL
		$sSql = "SELECT COUNT(*) AS count FROM " . $prefix . "ed_filter WHERE";
		$sSql = $sSql . " ed_blocked_value = %s";
		$sSql = $wpdb->prepare($sSql, trim($email));
		$result = $wpdb->get_var($sSql);
		if($result > 0) {
			return true;
		}
		
		// Block by IP
		$subscriber_ip = ed_cls_common::ed_get_subscriber_ip();
		$sSql = "SELECT COUNT(*) AS count FROM " . $prefix . "ed_filter WHERE";
		$sSql = $sSql . " ed_blocked_type = 'IP' and ed_blocked_value = %s";
		$sSql = $wpdb->prepare($sSql, trim($subscriber_ip));
		$result = $wpdb->get_var($sSql);
		if($result > 0) {
			return true;
		}
		
		// Block by Email
		if($email <> '') {
			$email = strtoupper($email);
		}
		$sSql = "SELECT COUNT(*) AS count FROM " . $prefix . "ed_filter WHERE";
		$sSql = $sSql . " ed_blocked_type = 'Email' and ed_blocked_value = %s";
		$sSql = $wpdb->prepare($sSql, trim($email));
		$result = $wpdb->get_var($sSql);
		if($result > 0) {
			return true;
		}
		
		// Block by Domain
		$domain = '';
		if($email <> '') {
			if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
				$domain = substr(strrchr($email, "@"), 1);
			}
			$domain = '@'.strtoupper($domain);
		}
		$sSql = "SELECT COUNT(*) AS count FROM " . $prefix . "ed_filter WHERE";
		$sSql = $sSql . " ed_blocked_type = 'Domain' and ed_blocked_value = %s";
		$sSql = $wpdb->prepare($sSql, trim($domain));
		$result = $wpdb->get_var($sSql);
		if($result > 0) {
			return true;
		}
				
		return false;
	}
	
	public static function ed_filter_badword($name = '', $email = '', $phone = '') {
		global $wpdb;
		$prefix = $wpdb->prefix;
		
		// Security - reject entry if it contain bad word
		$sSql = "SELECT * FROM " . $prefix . "ed_filter WHERE ";
		$sSql = $sSql . " ed_blocked_type = 'Badword'";
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		if(count($myData) > 0) {
			foreach ($myData as $data) {
				if( $data['ed_blocked_value'] <> '') {
					if($name <> '') {
						if(strpos(strtoupper($name), strtoupper($data['ed_blocked_value'])) !== false) {
							return true; 
						}
					}
					if($email <> '') {
						if(strpos(strtoupper($email), strtoupper($data['ed_blocked_value'])) !== false) {
							return true; 
						}
					}
					if($phone <> '') {
						if(strpos(strtoupper($phone), strtoupper($data['ed_blocked_value'])) !== false) {
							return true; 
						}
					}
				}
			}
		}
		
		return false;
	}
	
	public static function ed_squeeze_check() {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$subscriber_ip = ed_cls_common::ed_get_subscriber_ip();

		if ( ! empty( $subscriber_ip ) ) {
			
			$sSql = "SELECT count(*) as count from " . $prefix . "ed_filter";
			$sSql = $sSql . " WHERE ed_blocked_value = %s AND ( `ed_blocked_created` >= NOW() - INTERVAL 300 SECOND ) AND ed_blocked_type = 'Squeeze'";
			$sSql = $wpdb->prepare($sSql, $subscriber_ip);
			$cnt_last300 = $wpdb->get_var($sSql);
			
			//15 entry allowed in 5 mins, 16th entry error.
			if ( $cnt_last300 > 16 ) {
				ed_cls_filter::ed_filter_ins('IP', $subscriber_ip);
				return 'blocked';
			}
			
			$sSql = "SELECT count(*) as count from " . $prefix . "ed_filter";
			$sSql = $sSql . " WHERE ed_blocked_value = %s AND ( `ed_blocked_created` >= NOW() - INTERVAL 15 SECOND ) AND ed_blocked_type = 'Squeeze'";
			$sSql = $wpdb->prepare($sSql, $subscriber_ip);
			$cnt_last15 = $wpdb->get_var($sSql);
			
			//One entry allowed in 15 second, 2nd entry error.
			if ( $cnt_last15 > 0 ) { 
				return 'squeeze';
			}
			
			return 'sus';
		}
		return 'err';
	}
	
	public static function ed_squeeze_del() {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = "DELETE FROM " . $prefix . "ed_filter WHERE (`ed_blocked_created` < NOW() - INTERVAL 600 SECOND ) AND ed_blocked_type = 'Squeeze'";
		$wpdb->query($sSql);
		return true;
	}
	
	public static function ed_squeeze_ins() {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$guid = ed_cls_common::ed_generate_guid(60);
		$subscriber_ip = ed_cls_common::ed_get_subscriber_ip();
		if ( ! empty( $subscriber_ip ) ) {
			$sSql = "INSERT INTO " . $prefix . "ed_filter (`ed_blocked_guid`, `ed_blocked_type`, `ed_blocked_value`) VALUES (%s, %s, %s)";
			$sSql = $wpdb->prepare($sSql, $guid, 'Squeeze', $subscriber_ip);
			$wpdb->query($sSql);
		}
		return true;
	}
}
?>