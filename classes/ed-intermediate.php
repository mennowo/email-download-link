<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class ed_cls_intermediate
{
	public static function ed_downloads()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ED_DIR.'downloads'.DIRECTORY_SEPARATOR.'downloads-add.php');
				break;
			case 'edit':
				require_once(ED_DIR.'downloads'.DIRECTORY_SEPARATOR.'downloads-edit.php');
				break;
			case 'view':
				require_once(ED_DIR.'downloads'.DIRECTORY_SEPARATOR.'downloads-view.php');
				break;
			case 'details':
				require_once(ED_DIR.'downloads'.DIRECTORY_SEPARATOR.'downloads-view.php');
				break;
			default:
				require_once(ED_DIR.'downloads'.DIRECTORY_SEPARATOR.'downloads-show.php');
				break;
		}
	}
	
	public static function ed_settings()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-add.php');
				break;
			case 'sync':
				require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings-sync.php');
				break;
			default:
				require_once(ED_DIR.'settings'.DIRECTORY_SEPARATOR.'settings.php');
				break;
		}
	}
	
	public static function ed_cron()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ED_DIR.'cron'.DIRECTORY_SEPARATOR.'cron-add.php');
				break;
			default:
				require_once(ED_DIR.'cron'.DIRECTORY_SEPARATOR.'cron-add.php');
				break;
		}
	}
	
	public static function ed_downloadhistory()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'email':
				require_once(ED_DIR.'subscribers'.DIRECTORY_SEPARATOR.'subscribers-email.php');
				break;
			case 'downloads':
				require_once(ED_DIR.'subscribers'.DIRECTORY_SEPARATOR.'subscribers-downloads.php');
				break;
			case 'export':
				require_once(ED_DIR.'subscribers'.DIRECTORY_SEPARATOR.'subscribers-export.php');
				break;
			default:
				require_once(ED_DIR.'subscribers'.DIRECTORY_SEPARATOR.'subscribers-show.php');
				break;
		}
	}
	
	public static function ed_recaptcha()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ED_DIR.'recaptcha'.DIRECTORY_SEPARATOR.'recaptcha-add.php');
				break;
			default:
				require_once(ED_DIR.'recaptcha'.DIRECTORY_SEPARATOR.'recaptcha-add.php');
				break;
		}
	}
	
	public static function ed_security()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(ED_DIR.'security'.DIRECTORY_SEPARATOR.'security.php');
				break;
			default:
				require_once(ED_DIR.'security'.DIRECTORY_SEPARATOR.'security.php');
				break;
		}
	}
}
?>