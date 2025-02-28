<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class ed_shortcode {

	public function __construct() {
	}
	
	public static function load_ed_shortcode( $atts ) {
		ob_start();
		
		if ( ! is_array( $atts ) )
		{
			return '';
		}
		
		//[email-download-link namefield="YES" group="Default"]
		//[email-download-link namefield="YES" group="Default" desc="Submit this form to get test download link email."]
		//[email-download-link namefield="YES" id="1"]
		//[email-download-link namefield="YES" group="Default" phone="YES"]
	
		$atts = shortcode_atts( array(
			'namefield' => '',
			'id'      	=> '',
			'group'     => '',
			'desc'     	=> '',
			'phone'     => ''
		), $atts, 'email-download-link' );

		$namefield 	= isset($atts['namefield']) ? $atts['namefield'] : '';
		$id 		= isset($atts['id']) ? $atts['id'] : '';
		$group 		= isset($atts['group']) ? $atts['group'] : '';
		$desc 		= isset($atts['desc']) ? $atts['desc'] : '';
		$phone 		= isset($atts['phone']) ? $atts['phone'] : '';

		$data = array(
			'ed_title' 		=> '',
			'ed_desc' 		=> $desc,
			'ed_name' 		=> $namefield,
			'ed_name_mand' 	=> $namefield,
			'ed_group' 		=> $group,
			'ed_form_id' 	=> $id,
			'ed_phone' 		=> $phone
		);

		self::render_ed_form( $data );

		return ob_get_clean();
	}
	
	public static function render_ed_form( $data = array() ) {	
		$ed = "";
		
		if(count($data) == 0) {
			return $ed;
		}

		$ed_title 		= $data['ed_title'];
		$ed_desc		= $data['ed_desc'];
		$ed_name		= $data['ed_name'];
		$ed_name_mand	= $data['ed_name_mand'];
		$ed_form_id		= $data['ed_form_id'];
		$ed_group		= $data['ed_group'];
		$ed_phone		= $data['ed_phone'];
		
		$ed_email_form_guid = "";
		if(trim($ed_group) == "") {
			$ed_form_downloaguid_array = array();
			if($ed_form_id == 0 || $ed_form_id == "" || $ed_form_id == "0") {
				$ed_form_downloaguid_array = ed_cls_downloads::ed_download_link_random(1);
				if(count($ed_form_downloaguid_array) > 0) {
					$ed_email_form_guid	 = $ed_form_downloaguid_array[0]['ed_form_guid'];
				}
			}
			else {
				$ed_form_downloaguid_array = ed_cls_downloads::ed_download_link_view($ed_form_id, "");
				if(count($ed_form_downloaguid_array) > 0) {
					$ed_email_form_guid	 = $ed_form_downloaguid_array['ed_form_guid'];
				}
			}
		}
		else {
			$ed_email_form_guid = "group-option";
		}
		
		$ed_desc_html = "";	
		$ed_name_html = "";	
		$ed_email_html = "";
		$ed_group_html = "";
		$ed_gdpr_html = "";
		$ed_phone_html = "";
		
		if($ed_desc	<> "") {
			$ed_desc_html = '<p>';
			$ed_desc_html .= '<span class="ed_short_desc" id="desc">' . esc_html($ed_desc) . '</span>';
			$ed_desc_html .= '</p>';
		}
		
		if($ed_name == "YES") {
			$ed_name_html = '<p>';
			$ed_name_html .= '<span class="name">';
			$ed_name_html .=  __('Name', 'email-download-link');
			if($ed_name_mand == "YES") {
				$ed_name_html .= ' *';
				$ed_name_mand = "required";
			}
			else {
				$ed_name_mand = "";
			}
			$ed_name_html .= '</span>';
			$ed_name_html .= '<br>';
			$ed_name_html .= '<input type="text" name="name" id="name" placeholder="' . __('Name', 'email-download-link') . '" value="" maxlength="50" ' . $ed_name_mand . '/>';
			$ed_name_html .= '</p>';
		}
		
		$ed_email_html = '<p>';
		$ed_email_html .= '<span class="email">';
		$ed_email_html .= __('Email *', 'email-download-link');
		$ed_email_html .= '</span>';
		$ed_email_html .= '<br>';
		$ed_email_html .= '<input class="" type="email" id="email" name="email" value="" placeholder="' . __('Email *', 'email-download-link') . '"  maxlength="225" required/>';
		$ed_email_html .= '</p>';
		
		if($ed_phone == "YES") {
			$ed_phone_html = '<p>';
			$ed_phone_html .= '<span class="phone">';
			$ed_phone_html .=  __('Phone', 'email-download-link');
			$ed_phone_html .= '</span>';
			$ed_phone_html .= '<br>';
			$ed_phone_html .= '<input type="text" name="phone" id="phone" placeholder="' . __('Phone', 'email-download-link') . '" value="" maxlength="20" />';
			$ed_phone_html .= '</p>';
		}
		
		if(trim($ed_group) <> "") {
			$groups = array();
			$select = "";
			$groups = ed_cls_downloads::ed_download_link_group_title($ed_group);
			if(count($groups) > 0) {
				foreach ($groups as $group) {
					$select = $select . '<option value='.$group['ed_form_guid'].'>'.esc_html(stripslashes($group['ed_form_title'])).'</option>';
				}
			}
			
			$ed_group_html = '<p>';
			$ed_group_html .= '<span class="email">';
			$ed_group_html .= __('Downloads *', 'email-download-link');
			$ed_group_html .= '</span>';
			$ed_group_html .= '<br>';
			$ed_group_html .= '<select name="group" id="group" required>';
			$ed_group_html .= '<option value="">'. __('Select', 'email-download-link').'</option>';
			$ed_group_html .= $select;
			$ed_group_html .= '</select>';			
			$ed_group_html .= '</p>';
		}
		
		$ed_gdpr = 'NO';
		$gdpr = ed_cls_settings::ed_setting_select(1);
		if(count($gdpr) > 0) {
			if($gdpr['ed_c_gdprstatus'] == 'YES') {
				$ed_gdpr_html = '<p>';
				$ed_gdpr_html .= '<input type="checkbox" name="gdpr" id="gdpr" value="YES"> ';
				$ed_gdpr_html .= stripslashes($gdpr['ed_c_gdprlink']);
				$ed_gdpr_html .= '</p>';
				$ed_gdpr = 'YES';
			}
		}
		
		
		
		$loading_image_path = ED_URL . 'images/ajax-loader.gif';
		$nonce = wp_create_nonce( 'ed-nonce' );
		$unique_no = time();
		
		//////////////////////////////Robot verification//////////////////////////////////////////////////
		$ed_recaptcha_js = '';
		$ed_recaptcha_html = '';
		$ed_captcha_widget = get_option('ed_captcha_widget', '');
		if($ed_captcha_widget == 'YES')
		{
			$ed_recaptcha_js = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
			$ed_captcha_sitekey = get_option('ed_captcha_sitekey');
			$ed_recaptcha_html = '<p>';
			$ed_recaptcha_html .= '<div class="g-recaptcha" data-sitekey="'.$ed_captcha_sitekey.'"></div>';
			$ed_recaptcha_html .= '</p>';
		}
		//////////////////////////////Robot verification//////////////////////////////////////////////////
		
		?>
		<?php echo $ed_recaptcha_js; ?>
		<div class="email_download_link">
			<?php echo $ed_desc_html; ?>
			<form action="#" method="post" class="ed_form" id="ed_form_<?php echo $unique_no; ?>">
				<?php echo $ed_name_html; ?>
				<?php echo $ed_email_html; ?>
				<?php echo $ed_phone_html; ?>
				<?php echo $ed_group_html; ?>
				<?php echo $ed_gdpr_html; ?>
				<?php echo $ed_recaptcha_html; ?>
				<br />
				<input name="submit" class="submit" id="ed_form_submit_<?php echo $unique_no; ?>" value="<?php _e('Send Download Link', 'email-download-link'); ?>" type="submit" />
				<span class="ed_form_spinner" id="loading-image" style="display:none;">
					<img src="<?php echo $loading_image_path; ?>" />
				</span>
				<input name="guid" id="guid" value="<?php echo $ed_email_form_guid; ?>" type="hidden"/>
				<input type="text" style="display:none;" id="email_name" name="email_name" value="" type="hidden"/>
				<input name="form_nonce" id="form_nonce" value="<?php echo $nonce; ?>" type="hidden"/>
				<input name="name_mand" id="name_mand" value="<?php echo esc_html($ed_name); ?>" type="hidden"/>
				<input name="gdpr_mand" id="gdpr_mand" value="<?php echo $ed_gdpr; ?>" type="hidden"/>
				<input name="phone_mand" id="phone_mand" value="<?php echo esc_html($ed_phone); ?>" type="hidden"/>
			</form>	
			<span class="ed_form_message" id="ed_form_message_<?php echo $unique_no; ?>"></span>
		</div>
	<?php
	}
}


?>