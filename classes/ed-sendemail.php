<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class ed_cls_sendemail
{
	public static function ed_sendemail_prepare($ed_email_id = 0)
	{
		$subscribers = array();
		$subscribers = ed_cls_subscribers::ed_subscribers_view_page(0, 1, $ed_email_id, "", "");
		$replacefrom = array("<ul><br />", "</ul><br />", "<li><br />", "</li><br />", "<ol><br />", "</ol><br />", "</h2><br />", "</h1><br />");
		$replaceto = array("<ul>", "</ul>", "<li>" ,"</li>", "<ol>", "</ol>", "</h2>", "</h1>");
		
		if(count($subscribers) > 0)
		{
			$ed_email_guid 			= $subscribers[0]['ed_email_guid'];
			$ed_email_downloadid 	= $subscribers[0]['ed_email_downloadid'];
			$ed_email_name 			= $subscribers[0]['ed_email_name'];
			$ed_email_mail 			= $subscribers[0]['ed_email_mail'];
			$ed_form_title			= "";
			
			if($ed_email_name == "")
			{
				$ed_email_name 		= $ed_email_mail;
			}
			
			$home_url 	= home_url('/');
			$downloadurl_direct = $home_url . "?ed=download&guid=".$ed_email_downloadid."--".$ed_email_guid;
			
			if($ed_email_downloadid <> "")
			{
				$downloads = array();
				$downloads = ed_cls_downloads::ed_downloads_downloadid($ed_email_downloadid);			
				$ed_form_title = $downloads['ed_form_title'];
			}
		}
		else
		{
			return false;
		}
		
		$settings = array();
		$settings = ed_cls_settings::ed_setting_select(1);
		
		$htmlmail = false;
		$wpmail = false;
		
		if( $settings['ed_c_mailtype'] == "WP HTML MAIL" || $settings['ed_c_mailtype'] == "PHP HTML MAIL" )  
		{
			$htmlmail = true;
		}
		
		if( $settings['ed_c_mailtype'] == "WP HTML MAIL" || $settings['ed_c_mailtype'] == "WP PLAINTEXT MAIL" )  
		{
			$wpmail = true;
		}
		
		if( trim($settings['ed_c_fromname']) == "" || trim($settings['ed_c_fromemail']) == '' )
		{
			get_currentuserinfo();
			$sender_name = $user_login;
			$sender_email = $user_email;
		}
		else
		{
			$sender_name = $settings['ed_c_fromname'];
			$sender_email = $settings['ed_c_fromemail'];
		}
		
		$headers  = "From: \"$sender_name\" <$sender_email>\n";
		$headers .= "Return-Path: <" . $sender_email . ">\n";
		$headers .= "Reply-To: \"" . $sender_name . "\" <" . $sender_email . ">\n";
		$headers .= "X-Mailer: PHP" . phpversion() . "\n";
		
		if($htmlmail)
		{
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: " . get_bloginfo('html_type') . "; charset=\"". get_bloginfo('charset') . "\"\n";
			$headers .= "Content-type: text/html\r\n"; 
		}
		else
		{
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/plain; charset=\"". get_bloginfo('charset') . "\"\n";
		}
		
		$subject = stripslashes($settings['ed_c_usermailsubject']);
		$content = stripslashes($settings['ed_c_usermailcontant']);
		
		
		if ( $settings['ed_c_mailtype'] == "WP HTML MAIL" || $settings['ed_c_mailtype'] == "PHP HTML MAIL" )
		{
			$content = nl2br($content);
			$content = str_replace($replacefrom, $replaceto, $content);
		}
		else
		{
			$content = str_replace("<br />", "\r\n", $content);
			$content = str_replace("<br>", "\r\n", $content);
		}
		
		$subject = str_replace("###NAME###", $ed_email_name, $subject);
		$subject = str_replace("###EMAIL###", $ed_email_mail, $subject);
		
		$content = str_replace("###NAME###", $ed_email_name, $content);
		$content = str_replace("###EMAIL###", $ed_email_mail, $content);
		$content = str_replace("###DOWNLOADLINK###", $downloadurl_direct, $content);
		$content = str_replace("###DOWNLOADLINKDIRECT###", $downloadurl_direct, $content);
		$content = str_replace("###TITLE###", $ed_form_title, $content);
		
		if($wpmail) 
		{
			wp_mail($ed_email_mail, $subject, $content, $headers);
		}
		else
		{
			mail($ed_email_mail ,$subject, $content, $headers);
		}
		
		// Mail to admin
		if($settings['ed_c_adminmailoption'] == "YES")
		{
			$ed_c_adminemail = $settings['ed_c_adminemail'];
			$ed_c_adminmailsubject = $settings['ed_c_adminmailsubject'];
			$ed_c_adminmailcontant = $settings['ed_c_adminmailcontant'];
			
			$ed_c_adminmailsubject = str_replace("###NAME###", $ed_email_name, $ed_c_adminmailsubject);
			$ed_c_adminmailsubject = str_replace("###EMAIL###", $ed_email_mail, $ed_c_adminmailsubject);
			$ed_c_adminmailsubject = str_replace("###TITLE###", $ed_form_title, $ed_c_adminmailsubject);
			
			$ed_c_adminmailcontant = str_replace("###NAME###", $ed_email_name, $ed_c_adminmailcontant);
			$ed_c_adminmailcontant = str_replace("###EMAIL###", $ed_email_mail, $ed_c_adminmailcontant);
			$ed_c_adminmailcontant = str_replace("###DOWNLOADLINK###", $downloadurl_direct, $ed_c_adminmailcontant);
			$ed_c_adminmailcontant = str_replace("###DOWNLOADLINKDIRECT###", $downloadurl_direct, $ed_c_adminmailcontant);
			$ed_c_adminmailcontant = str_replace("###TITLE###", $ed_form_title, $ed_c_adminmailcontant);
			
			if ( $settings['ed_c_mailtype'] == "WP HTML MAIL" || $settings['ed_c_mailtype'] == "PHP HTML MAIL" )
			{
				$ed_c_adminmailcontant = nl2br($ed_c_adminmailcontant);
				$ed_c_adminmailcontant = str_replace($replacefrom, $replaceto, $ed_c_adminmailcontant);
			}
			else
			{
				$ed_c_adminmailcontant = str_replace("<br />", "\r\n", $ed_c_adminmailcontant);
				$ed_c_adminmailcontant = str_replace("<br>", "\r\n", $ed_c_adminmailcontant);
			}
			
			if($wpmail) 
			{
				wp_mail($ed_c_adminemail, $ed_c_adminmailsubject, $ed_c_adminmailcontant, $headers);
			}
			else
			{
				mail($ed_c_adminemail ,$ed_c_adminmailsubject, $ed_c_adminmailcontant, $headers);
			}
		}
	}
	
	public static function ed_sendemail_admincron()
	{
		$settings = array();
		$settings = ed_cls_settings::ed_setting_select(1);
		$replacefrom = array("<ul><br />", "</ul><br />", "<li><br />", "</li><br />", "<ol><br />", "</ol><br />", "</h2><br />", "</h1><br />");
		$replaceto = array("<ul>", "</ul>", "<li>" ,"</li>", "<ol>", "</ol>", "</h2>", "</h1>");
		
		$htmlmail = false;
		$wpmail = false;
		
		if( $settings['ed_c_mailtype'] == "WP HTML MAIL" || $settings['ed_c_mailtype'] == "PHP HTML MAIL" )  
		{
			$htmlmail = true;
		}
		
		if( $settings['ed_c_mailtype'] == "WP HTML MAIL" || $settings['ed_c_mailtype'] == "WP PLAINTEXT MAIL" )  
		{
			$wpmail = true;
		}
		
		if( trim($settings['ed_c_fromname']) == "" || trim($settings['ed_c_fromemail']) == '' )
		{
			get_currentuserinfo();
			$sender_name = $user_login;
			$sender_email = $user_email;
		}
		else
		{
			$sender_name = $settings['ed_c_fromname'];
			$sender_email = $settings['ed_c_fromemail'];
		}
		
		$headers  = "From: \"$sender_name\" <$sender_email>\n";
		$headers .= "Return-Path: <" . $sender_email . ">\n";
		$headers .= "Reply-To: \"" . $sender_name . "\" <" . $sender_email . ">\n";
		$headers .= "X-Mailer: PHP" . phpversion() . "\n";
		
		if($htmlmail)
		{
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: " . get_bloginfo('html_type') . "; charset=\"". get_bloginfo('charset') . "\"\n";
			$headers .= "Content-type: text/html\r\n"; 
		}
		else
		{
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/plain; charset=\"". get_bloginfo('charset') . "\"\n";
		}
		
		$blogname = get_option('blogname');
		$subject = $blogname . " : Download link refreshed";
		$content = stripslashes($settings['ed_c_cronmailcontent']);
		$ed_c_adminemail = $settings['ed_c_adminemail'];
		
		$currentdate = date('Y-m-d G:i:s'); 
		$content = str_replace("###DATE###", $currentdate, $content);
		
		
		if ( $settings['ed_c_mailtype'] == "WP HTML MAIL" || $settings['ed_c_mailtype'] == "PHP HTML MAIL" )
		{
			$content = nl2br($content);
			$content = str_replace($replacefrom, $replaceto, $content);
		}
		else
		{
			$content = str_replace("<br />", "\r\n", $content);
			$content = str_replace("<br>", "\r\n", $content);
		}
			
			
		if($wpmail) 
		{
			wp_mail($ed_c_adminemail, $subject, $content, $headers);
		}
		else
		{
			mail($ed_c_adminemail ,$subject, $content, $headers);
		}
	}
}
?>