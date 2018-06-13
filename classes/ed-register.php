<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class ed_cls_registerhook
{
	public static function ed_activation()
	{
		global $wpdb;
		
		add_option('email-download-link', "1.6.1");
		
		$charset_collate = '';
		$charset_collate = $wpdb->get_charset_collate();
		  
		$es_default_tables = "CREATE TABLE {$wpdb->prefix}ed_emaillist (
									ed_email_id INT unsigned NOT NULL AUTO_INCREMENT,
									ed_email_guid VARCHAR(255) NOT NULL,
									ed_email_name VARCHAR(255) NOT NULL,
									ed_email_mail VARCHAR(255) NOT NULL,
									ed_email_downloaddate datetime NOT NULL default '0000-00-00 00:00:00',
									ed_email_downloadcount INT unsigned NOT NULL,
									ed_email_downloadstatus VARCHAR(255) NOT NULL default 'Pending',
									ed_email_downloadid VARCHAR(255) NOT NULL,
									ed_email_form_guid VARCHAR(255) NOT NULL,
									PRIMARY KEY  (ed_email_id)
									) $charset_collate;
								CREATE TABLE {$wpdb->prefix}ed_downloadform (
									ed_form_id INT unsigned NOT NULL AUTO_INCREMENT,
									ed_form_guid VARCHAR(255) NOT NULL,
									ed_form_title VARCHAR(255) NOT NULL,
									ed_form_description VARCHAR(255) NOT NULL,
									ed_form_downloadurl VARCHAR(255) NOT NULL,
									ed_form_downloadabspath VARCHAR(255) NOT NULL,
									ed_form_downloadcount INT unsigned NOT NULL,
									ed_form_expirationtype VARCHAR(25) NOT NULL default 'Never',
									ed_form_expirationdate date NOT NULL default '9999-12-31',
									ed_form_status VARCHAR(25) NOT NULL default 'Published',
									ed_form_group VARCHAR(25) NOT NULL default 'Default',
									ed_form_mailtext TEXT NULL,
									ed_form_downloadid VARCHAR(255) NOT NULL,
									PRIMARY KEY  (ed_form_id)
									) $charset_collate;
								CREATE TABLE {$wpdb->prefix}ed_pluginconfig (
									ed_c_id INT unsigned NOT NULL AUTO_INCREMENT,
									ed_c_fromname VARCHAR(255) NOT NULL,
									ed_c_fromemail VARCHAR(255) NOT NULL,
									ed_c_mailtype VARCHAR(255) NOT NULL,
									ed_c_adminmailoption VARCHAR(255) NOT NULL,
									ed_c_adminemail VARCHAR(255) NOT NULL,
									ed_c_adminmailsubject VARCHAR(255) NOT NULL,
									ed_c_adminmailcontant TEXT NULL,
									ed_c_usermailoption VARCHAR(255) NOT NULL,
									ed_c_usermailsubject VARCHAR(255) NOT NULL,
									ed_c_usermailcontant TEXT NULL,
									ed_c_downloadstart VARCHAR(255) NOT NULL,
									ed_c_downloadpgtxt TEXT NULL,
									ed_c_crontype VARCHAR(255) NOT NULL default 'Sunday',
									ed_c_cronrefreshdate datetime NOT NULL default '0000-00-00 00:00:00',
									ed_c_cronurl VARCHAR(255) NOT NULL,
									ed_c_cronmailcontent VARCHAR(255) NOT NULL,
									ed_c_expiredlinkcontant TEXT NULL,
									ed_c_invalidlinkcontant TEXT NULL,
									ed_c_privacyconditionslink TEXT NULL,
									PRIMARY KEY  (ed_c_id)
								) $charset_collate;
							";
							
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $es_default_tables );
		
		// Plugin tables
		$array_tables_to_plugin = array('ed_emaillist','ed_downloadform','ed_pluginconfig');
		$errors = array();
		
		// list the tables that haven't been created
		$ed_has_errors = false;
        $ed_missing_tables=array();
        foreach($array_tables_to_plugin as $table_name) {
			if(strtoupper($wpdb->get_var("SHOW TABLES like  '". $wpdb->prefix.$table_name . "'")) != strtoupper($wpdb->prefix.$table_name)) {
                $ed_missing_tables[]=$wpdb->prefix.$table_name;
            }
        }
		
		// add error in to array variable
        if($ed_missing_tables) {
			$errors[] = __('These tables could not be created on installation ' . implode(', ',$missingtables), 'email-download-link');
            $ed_has_errors=true;
        }
		
		// if error call wp_die()
        if($ed_has_errors) {
			wp_die( __( $errors[0] , 'email-download-link' ) );
			return false;
		}
		else {
			ed_cls_default::ed_pluginconfig_default();
			ed_cls_default::ed_downloads_default();
		}
		
		if ( ! is_network_admin() && ! isset( $_GET['activate-multi'] ) ) {
			set_transient( '_ed_activation_redirect', 1, 30 );
		}
		
        return true;
	}

	public static function ed_deactivation() {
		// do not generate any output here
	}
	
	public static function ed_admin_option() {
		// do not generate any output here
	}
	
	public static function ed_adminmenu() {		
		add_menu_page( __( 'Email download link', 'email-download-link' ), 
			__( 'Download Link', 'email-download-link' ), 'admin_dashboard', 'email-download-link', 'ed_admin_option', ED_URL.'images/icon.png', 51 );
			
		add_submenu_page('email-download-link', __( 'Email download link', 'email-download-link' ), 
			__( 'Downloads', 'email-download-link' ), "manage_options", 'ed-downloads', array( 'ed_cls_intermediate', 'ed_downloads' ));
			
		add_submenu_page('email-download-link', __( 'Email download link', 'email-download-link' ), 
			__( 'Cron Details', 'email-download-link' ), "manage_options", 'ed-cron', array( 'ed_cls_intermediate', 'ed_cron' ));
			
		add_submenu_page('email-download-link', __( 'Email download link', 'email-download-link' ), 
			__( 'Settings', 'email-download-link' ), "manage_options", 'ed-settings', array( 'ed_cls_intermediate', 'ed_settings' ));
			
		add_submenu_page('email-download-link', __( 'Email download link', 'email-download-link' ), 
			__( 'Download History', 'email-download-link' ), "manage_options", 'ed-downloadhistory', array( 'ed_cls_intermediate', 'ed_downloadhistory' ));
	}
	
	public static function ed_widget_loading() {
		register_widget( 'ed_widget_register' );
	}	
	
	public static function ed_load_scripts() {
		if( !empty( $_GET['page'] ) )
		{
			switch ( $_GET['page'] ) 
			{
				case 'ed-downloads':
					wp_register_script( 'ed-downloads', ED_URL . 'downloads/downloads.js', '', '', true );
					wp_enqueue_script( 'ed-downloads' );
					$ed_script_params = array(
						'ed_delete_record'  => _x( 'Do you want to delete this record?', 'ed-download-script', 'email-download-link' ),
						'ed_add_title'   	=> _x( 'Please enter title for your download link.', 'ed-download-script', 'email-download-link' ),
						'ed_add_link'   	=> _x( 'Please upload your file to generate download link or enter your download link.', 'ed-download-script', 'email-download-link' ),
						'ed_add_expiration' => _x( 'Please enter expiration date for this download URL. YYYY-MM-DD.', 'ed-download-script', 'email-download-link' ),
						'ed_add_refresh' 	=> _x( 'Please select your refresh type for the download link.', 'ed-download-script', 'email-download-link' ),
						'ed_add_group' 		=> _x( 'Please select or enter your group name for this download link.', 'ed-download-script', 'email-download-link' ),
					);
					wp_localize_script( 'ed-downloads', 'ed_downloads_script', $ed_script_params );
					break;
					
				case 'ed-cron':
					wp_register_script( 'ed-cron', ED_URL . 'cron/cron.js', '', '', true );
					wp_enqueue_script( 'ed-cron' );
					$ed_script_params = array( );
					wp_localize_script( 'ed-cron', 'ed_cron_script', $ed_script_params );
					break;
					
				case 'ed-settings':
					wp_register_script( 'ed-settings', ED_URL . 'settings/settings.js', '', '', true );
					wp_enqueue_script( 'ed-settings' );
					$ed_script_params = array(	);
					wp_localize_script( 'ed-settings', 'ed_settings_script', $ed_script_params );
					break;	
					
				case 'ed-downloadhistory':
					wp_register_script( 'ed-downloadhistory', ED_URL . 'subscribers/subscribers.js', '', '', true );
					wp_enqueue_script( 'ed-downloadhistory' );
					$ed_script_params = array(
						'ed_delete_record'  	=> _x( 'Do you want to delete this record?', 'ed-download-script', 'email-download-link' ),
						'ed_exportcsv_record'  	=> _x( 'Do you want to export the emails?', 'ed-download-script', 'email-download-link' ),
					);
					wp_localize_script( 'ed-downloadhistory', 'ed_downloadhistory_script', $ed_script_params );
					break;
			}
		}
	
	}
	
	public static function ed_email_download_link_db_update() {
		if ( (get_option( 'email-download-link') === false) || (get_option( 'email-download-link') == '1.0') || (get_option( 'email-download-link') == '1.6') ) {
			ed_cls_registerhook::ed_activation();
			ed_cls_registerhook::ed_email_download_link_db_for_1_6();
		}
	}
	
	public static function ed_email_download_link_db_for_1_6() {
		global $wpdb;
		$sSql = "UPDATE ".$wpdb->prefix."ed_downloadform SET `ed_form_group` = 'Default' where ed_form_group=''";
		$wpdb->query( $sSql );
		update_option( 'email-download-link', '1.6.1' );
	}
	
	public static function ed_welcome() {

		if ( ! get_transient( '_ed_activation_redirect' ) ) {
			return;
		}

		// Delete the redirect transient
		delete_transient( '_ed_activation_redirect' );

		wp_redirect( admin_url( 'admin.php?page=ed-downloads' ) );
		exit;
	}
}

class ed_form_submuit
{
	public static function ed_formdisplay($form_setting = array())
	{
		$ed = "";
		$ed_alt_nm = '';
		$ed_alt_em = '';
		$ed_alt_gp = '';
		$ed_alt_pr = '';
		$ed_alt_success = '';
		$ed_alt_techerror = '';
		$ed_error = false;
		
		if(count($form_setting) == 0)
		{
			return $es;
		}
		else
		{
			$ed_title 		= $form_setting['ed_title'];
			$ed_desc		= $form_setting['ed_desc'];
			$ed_name		= $form_setting['ed_name'];
			$ed_name_mand	= $form_setting['ed_name_mand'];
			$ed_form_id		= $form_setting['ed_form_id'];
			$ed_group		= $form_setting['ed_group'];
					
			$ed_email_form_guid = "";
			if(trim($ed_group) == "")
			{
				$ed_form_downloaguid_array = array();
				if($ed_form_id == 0 || $ed_form_id == "" || $ed_form_id == "0")
				{
					$ed_form_downloaguid_array = ed_cls_downloads::ed_download_link_random(1);
					if(count($ed_form_downloaguid_array) > 0)
					{
						$ed_email_form_guid	 = $ed_form_downloaguid_array[0]['ed_form_guid'];
					}
				}
				else
				{
					$ed_form_downloaguid_array = ed_cls_downloads::ed_download_link_view($ed_form_id, "");
					if(count($ed_form_downloaguid_array) > 0)
					{
						$ed_email_form_guid	 = $ed_form_downloaguid_array['ed_form_guid'];
					}
				}
			}
			else
			{
				//Group option
				$ed_email_form_guid = "group-option";
			}
		}
		
		if ( isset( $_POST['ed_btn'] ) ) 
		{
			check_admin_referer('ed_form_subscribers');
			
			if($ed_name == "YES")
			{
				$ed_txt_nm = isset($_POST['ed_txt_nm']) ? sanitize_text_field($_POST['ed_txt_nm']) : '';
			}
			else
			{
				$ed_txt_nm = "";
			}
			
			$ed_cb_pr = isset($_POST['ed_cb_pr']);
			$ed_txt_em = isset($_POST['ed_txt_em']) ? sanitize_text_field($_POST['ed_txt_em']) : '';
			$ed_id = isset($_POST['ed_txt_id']) ? sanitize_text_field($_POST['ed_txt_id']) : '';
			
			if($ed_name == "YES" && $ed_name_mand == "YES" && $ed_txt_nm == "")
			{
				$ed_alt_nm = '<span class="ed_validation" style="'.ED_MSG_05.'">'.ED_MSG_01.'</span>';
				$ed_error = true;
			}
			
			if( $ed_txt_nm  <> "")
			{
				$ed_txt_nm = sanitize_text_field($ed_txt_nm);
			}
			
			if($ed_txt_em == "")
			{
				$ed_alt_em = '<span class="ed_validation" style="'.ED_MSG_05.'">'.ED_MSG_01.'</span>';
				$ed_error = true;
			}
			
			if(!is_email($ed_txt_em) && $ed_txt_em <> "")
			{
				$ed_alt_em = '<span class="es_af_validation" style="'.ED_MSG_05.'">'.ED_MSG_02.'</span>';
				$ed_error = true;
			}
			
			if($ed_id == "group-option")
			{
				$ed_id = isset($_POST['ed_txt_group']) ? sanitize_text_field($_POST['ed_txt_group']) : '';
			}
			
			if($ed_id == "" || $ed_id == "group-option")
			{
				$ed_alt_gp = '<span class="ed_validation" style="'.ED_MSG_05.'">'.ED_MSG_07.'</span>';
				$ed_error = true;
			}

			if($ed_cb_pr <> "iagree")
			{
				$ed_alt_pr = '<span class="ed_validation" style="'.ED_MSG_05.'">'.ED_MSG_08.'</span>';
				$ed_error = true;
			}
			
			if(!$ed_error)
			{
				$homeurl = home_url();
				$samedomain = strpos($_SERVER['HTTP_REFERER'], $homeurl);
				if (($samedomain !== false) && $samedomain < 5) 
				{					
					$sts = ed_cls_subscribers::ed_subscriber_create($ed_txt_nm, $ed_txt_em, $ed_id);
					if($sts == "suss")
					{
						$ed_email_id = ed_cls_subscribers::ed_subscriber_foremail($ed_txt_em, $ed_id);
						
						if($ed_email_id > 0)
						{
							$ed_email_id = ed_cls_sendemail::ed_sendemail_prepare($ed_email_id);
						}
						$ed_alt_success = '<span class="ed_sent_successfully" style="'.ED_MSG_06.'">'.ED_MSG_04.'</span>';
					}
				}
			}
		}
		
		$ed = $ed . '<form method="post" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '">';
		
		if($ed_desc	<> "")
		{
			$ed = $ed . '<p>';
				$ed = $ed . '<span class="ed_short_desc">';
					$ed = $ed . $ed_desc;
				$ed = $ed . '</span>';
			$ed = $ed . '</p>';
		
		}
		
		if($ed_name == "YES")
		{
			$ed = $ed . '<p>';
				$ed = $ed . __('Name', 'email-download-link');
				if($ed_name_mand == "YES")
				{
					$ed = $ed . ' *';
				}
				$ed = $ed . '<br>';
				$ed = $ed . '<span class="ed_css_txt">';
					$ed = $ed . '<input class="ed_tb_css" name="ed_txt_nm" id="ed_txt_nm" value="" maxlength="225" type="text">';
				$ed = $ed . '</span>';
				$ed = $ed . $ed_alt_nm;
			$ed = $ed . '</p>';
		}
		
		$ed = $ed . '<p>';
			$ed = $ed . __('Email *', 'email-download-link');
			$ed = $ed . '<br>';
			$ed = $ed . '<span class="ed_css_txt">';
				$ed = $ed . '<input class="ed_tb_css" name="ed_txt_em" id="ed_txt_em" value="" maxlength="225" type="text">';
			$ed = $ed . '</span>';
			$ed = $ed . $ed_alt_em;
		$ed = $ed . '</p>';
		
		
		if(trim($ed_group) <> "")
		{
			$groups = array();
			$select = "";
			$groups = ed_cls_downloads::ed_download_link_group_title($ed_group);
			if(count($groups) > 0)
			{
				foreach ($groups as $group)
				{
					$select = $select . '<option value='.$group['ed_form_guid'].'>'.esc_html(stripslashes($group['ed_form_title'])).'</option>';
				}
			}
			
			$ed = $ed . '<p>';
			$ed = $ed . __('Downloads *', 'email-download-link');
			$ed = $ed . '<br>';
			$ed = $ed . '<span class="ed_css_drop">';				
				$ed = $ed . '<select name="ed_txt_group" id="ed_txt_group">';
					$ed = $ed . '<option value="">'. __('Select', 'email-download-link').'</option>';
					$ed = $ed . $select;
				$ed = $ed . '</select>';			
			$ed = $ed . '</span>';
			$ed = $ed . '<br>' . $ed_alt_gp;
			$ed = $ed . '</p>';
		}

        $settings = ed_cls_settings::ed_setting_select(1);
        if($settings['ed_c_privacyconditionslink'] !== '') {
            $ed = $ed . '<p>';
            $ed = $ed . __('I agree with the <a href="$ed_c_privacyconditionslink">privacy conditions</a> *', 'email-download-link');
            $ed = $ed . '<br>';
            $ed = $ed . '<span class="ed_css_chb">';
            $ed = $ed . '<input class="ed_cb_css" name="ed_cb_pr" id="ed_cb_pr" value="iagree" type="checkbox">';
            $ed = $ed . '</span>';
            $ed = $ed . '<br>' . $ed_alt_pr;
            $ed = $ed . '</p>';
        }

		$ed = $ed . '<p>';
			$ed = $ed . '<input class="ed_bt_css" name="ed_btn" id="ed_btn" value="'.__('Send Download Link', 'email-download-link').'" type="submit">';
			$ed = $ed . '<input name="ed_txt_id" id="ed_txt_id" value="'.$ed_email_form_guid.'" type="hidden">';
		$ed = $ed . '</p>';
		
		if($ed_error)
		{
			$ed = $ed . '<span class="ed_validation_full" style="'.ED_MSG_05.'">'.ED_MSG_03.'</span>';
		}
		else
		{
			$ed = $ed . $ed_alt_success;
		}
		
		$ed = $ed . wp_nonce_field('ed_form_subscribers');
		
		$ed = $ed . '</form>';
		
		return $ed;
	}
}
	
class ed_widget_register extends WP_Widget 
{
	function __construct() 
	{
		$widget_ops = array('classname' => 'widget_text ed-widget', 'description' => __(ED_PLUGIN_DISPLAY, 'email-download-link'), ED_PLUGIN_NAME);
		parent::__construct(ED_PLUGIN_NAME, __(ED_PLUGIN_DISPLAY, 'email-download-link'), $widget_ops);
	}
	
	function widget( $args, $instance ) 
	{
		extract( $args, EXTR_SKIP );
		
		$ed_title 		= apply_filters( 'widget_title', empty( $instance['ed_title'] ) ? '' : $instance['ed_title'], $instance, $this->id_base );
		$ed_desc		= $instance['ed_desc'];
		$ed_name		= $instance['ed_name'];
		$ed_name_mand	= $instance['ed_name_mand'];
		$ed_group		= isset($instance['ed_group']) ? $instance['ed_group'] : '';
		$ed_form_id		= $instance['ed_form_id'];

		echo $args['before_widget'];
		if ( ! empty( $ed_title ) )
		{
			echo $args['before_title'] . $ed_title . $args['after_title'];
		}
		
		if( (trim($ed_form_id) <> "999") && (trim($ed_form_id) <> 999) )
		{
			$ed_group = "";
		}
			
		$form_setting = array(
			'ed_title' 		=> $ed_title,
			'ed_desc' 		=> $ed_desc,
			'ed_name' 		=> $ed_name,
			'ed_name_mand' 	=> $ed_name_mand,
			'ed_group' 		=> $ed_group,
			'ed_form_id' 	=> $ed_form_id
		);
		
		$ed = ed_form_submuit::ed_formdisplay($form_setting);
		echo $ed;
		
		echo $args['after_widget'];
	}
	
	function update( $new_instance, $old_instance ) 
	{		
		$instance 					= $old_instance;
		$instance['ed_title'] 		= ( ! empty( $new_instance['ed_title'] ) ) ? strip_tags( $new_instance['ed_title'] ) : '';
		$instance['ed_desc'] 		= ( ! empty( $new_instance['ed_desc'] ) ) ? strip_tags( $new_instance['ed_desc'] ) : '';
		$instance['ed_name'] 		= ( ! empty( $new_instance['ed_name'] ) ) ? strip_tags( $new_instance['ed_name'] ) : '';
		$instance['ed_name_mand'] 	= ( ! empty( $new_instance['ed_name_mand'] ) ) ? strip_tags( $new_instance['ed_name_mand'] ) : '';
		$instance['ed_group'] 		= ( ! empty( $new_instance['ed_group'] ) ) ? strip_tags( $new_instance['ed_group'] ) : '';
		$instance['ed_form_id'] 	= ( ! empty( $new_instance['ed_form_id'] ) ) ? strip_tags( $new_instance['ed_form_id'] ) : '';
		return $instance;
	}
	
	function form( $instance ) 
	{
		$defaults = array(
			'ed_title' 		=> '',
		    'ed_desc' 		=> '',
			'ed_name' 		=> '',
			'ed_name_mand' 	=> '',
			'ed_group' 		=> '',
			'ed_form_id' 	=> ''
        );
		
		$instance 		= wp_parse_args( (array) $instance, $defaults);
		$ed_title 		= $instance['ed_title'];
        $ed_desc 		= $instance['ed_desc'];
        $ed_name 		= $instance['ed_name'];
		$ed_name_mand 	= $instance['ed_name_mand'];
		$ed_group 		= isset($instance['ed_group']) ? $instance['ed_group'] : '';
		$ed_form_id 	= $instance['ed_form_id'];
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id('ed_title'); ?>"><?php _e('Widget title', 'email-download-link'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('ed_title'); ?>" name="<?php echo $this->get_field_name('ed_title'); ?>" type="text" value="<?php echo $ed_title; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('ed_desc'); ?>"><?php _e('Short description for your download form.', 'email-download-link'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('ed_desc'); ?>" name="<?php echo $this->get_field_name('ed_desc'); ?>" type="text" value="<?php echo $ed_desc; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('ed_name'); ?>"><?php _e('Display NAME box', 'email-download-link'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('ed_name'); ?>" name="<?php echo $this->get_field_name('ed_name'); ?>">
				<option value="YES" <?php $this->ed_selected($ed_name == 'YES'); ?>>YES</option>
				<option value="NO" <?php $this->ed_selected($ed_name == 'NO'); ?>>NO</option>
			</select>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('ed_name_mand'); ?>"><?php _e('Set NAME box is mandatory box?', 'email-download-link'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('ed_name_mand'); ?>" name="<?php echo $this->get_field_name('ed_name_mand'); ?>">
				<option value="YES" <?php $this->ed_selected($ed_name_mand == 'YES'); ?>>YES</option>
				<option value="NO" <?php $this->ed_selected($ed_name_mand == 'NO'); ?>>NO</option>
			</select>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('ed_form_id'); ?>"><?php _e('Select download link for this form.', 'email-download-link'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('ed_form_id'); ?>" name="<?php echo $this->get_field_name('ed_form_id'); ?>">
			<option value="0">Random download link</option>
			<option value="999" <?php $this->ed_selected("999" == $ed_form_id); ?>>Use download group</option>
			<?php
			$download = array();
			$download = ed_cls_downloads::ed_download_link_view_page(0, 500, 0);
			
			if(count($download) > 0)
			{
				foreach ($download as $download_data)
				{
					?>
					<option value="<?php echo $download_data['ed_form_id']; ?>" <?php $this->ed_selected($download_data['ed_form_id'] == $ed_form_id); ?>>
					<?php echo $download_data['ed_form_title']; ?> (<?php echo $download_data['ed_form_id']; ?>)
					</option>
					<?php
				}
			}
			?>
			</select>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id('ed_form_id'); ?>"><?php _e('Select download group for this form.', 'email-download-link'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('ed_group'); ?>" name="<?php echo $this->get_field_name('ed_group'); ?>">
			<?php
			$groups = array();
			$groups = ed_cls_downloads::ed_download_link_group("");
			
			if(count($groups) > 0)
			{
				foreach ($groups as $group)
				{
					?>
					<option value="<?php echo $group['ed_form_group']; ?>" <?php $this->ed_selected($group['ed_form_group'] == $ed_group); ?>>
					<?php echo $group['ed_form_group']; ?>
					</option>
					<?php
				}
			}
			?>
			</select>
        </p>
			
		<?php
	}
	
	function ed_selected($var) 
	{
		if ($var==1 || $var==true) 
		{
			echo 'selected="selected"';
		}
	}
}

function emaildownload_shortcode( $atts ) 
{
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$id = "";
	
	//[email-download-link namefield="YES" group="Default"]
	//[email-download-link namefield="YES" id="1"]
	//[email-download-link namefield="YES" id="0"]
	$namefield 	= isset($atts['namefield']) ? $atts['namefield'] : 'YES';
	$id 		= isset($atts['id']) ? $atts['id'] : '';
	$group 		= isset($atts['group']) ? $atts['group'] : '';
	
	if( $group == "" && $id == "") // Set random if both group & id are null
	{
		$id = 0; 
	}
	
	if( $group <> "" ) // If group available, set id = null
	{
		$id = ""; 
	}
	
	if(!is_numeric($id) && $group == "")
	{
		$id = 0;
	}
	
	if($namefield <> "YES")
	{
		$namefield = "NO";
	}
	
	$arr = array();
	$arr["ed_title"] 		= "";
	$arr["ed_desc"] 		= "";
	$arr["ed_name"] 		= $namefield;
	$arr["ed_name_mand"] 	= $namefield;
	$arr["ed_group"] 		= $group;
	$arr["ed_form_id"] 		= $id;
	
	return ed_form_submuit::ed_formdisplay($arr);
}

function ed_download_link( $namefield = "YES", $id = 0 )
{
	if($namefield <> "YES")
	{
		$namefield = "NO";
	}

	if(!is_numeric($id))
	{
		$id = 0;
	}
	
	$arr = array();
	$arr["ed_title"] 		= "";
	$arr["ed_desc"] 		= "";
	$arr["ed_name"] 		= $namefield;
	$arr["ed_name_mand"] 	= $namefield;
	$arr["ed_group"] 		= "";
	$arr["ed_form_id"] 		= $id;
	echo ed_form_submuit::ed_formdisplay($arr);
}

function ed_cron_activation() 
{
	if (! wp_next_scheduled ( 'ed_cron_downloadlink' )) 
	{
		wp_schedule_event(time(), 'daily', 'ed_cron_downloadlink');
    }
}

function ed_cron_deactivation() 
{
	wp_clear_scheduled_hook('ed_cron_downloadlink');
}

function ed_cron_trigger_event() 
{
	$data = array();
	$data = ed_cls_settings::ed_setting_select(1);
	$ed_c_crontype = $data['ed_c_crontype'];
	
	$urlrefresh = "NO";
	if($ed_c_crontype <> "NO")
	{
		$current_day = date_i18n("l");
		if($ed_c_crontype == "Daily")
		{
			$urlrefresh = "YES";
		}
		elseif(strtoupper($ed_c_crontype) == strtoupper($current_day))
		{
			$urlrefresh = "YES";
		}
		elseif($ed_c_crontype == "SundayWednesday")
		{
			if(strtoupper($current_day) == "SUNDAY" || strtoupper($current_day) == "WEDNESDAY")
			{
				$urlrefresh = "YES";
			}
		}
	}
	
	if($urlrefresh == "YES")
	{
		ed_cls_downloads::ed_download_link_cron_refresh();
		ed_cls_sendemail::ed_sendemail_admincron();
	}
}
add_action('ed_cron_downloadlink', 'ed_cron_trigger_event');
?>