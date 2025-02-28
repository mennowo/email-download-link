<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
//ed_cls_common::ed_check_latest_update();

$ed_errors = array();
$ed_success = '';
$ed_error_found = FALSE;
$ed_success_msg = FALSE;

if (isset($_POST['frm_ed_display']) && $_POST['frm_ed_display'] == 'yes') {
	$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$result = ed_cls_filter::ed_filter_count($did);
	if ($result != '1') {
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'email-download-link'); ?></strong></p></div><?php
	}
	else {
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '') {
			check_admin_referer('ed_form_show');
			ed_cls_filter::ed_filter_del($did);
			$ed_success_msg = TRUE;
			$ed_success = __('Selected record was successfully deleted.', 'email-download-link');
		}
	}
}

if (isset($_POST['ed_form_submit']) && $_POST['ed_form_submit'] == 'yes') {
	check_admin_referer('ed_form_add');
	$form['ed_blocked_type'] 	= isset($_POST['ed_blocked_type']) ? sanitize_text_field($_POST['ed_blocked_type']) : '';
	$form['ed_blocked_value'] 	= isset($_POST['ed_blocked_value']) ? sanitize_text_field($_POST['ed_blocked_value']) : '';
	if ($form['ed_blocked_value'] == '') {
		$ed_errors[] = __('Please enter valid input.', 'email-download-link');
		$ed_error_found = TRUE;
	}
	
	if ($ed_error_found == FALSE) {
		ed_cls_filter::ed_filter_ins($form['ed_blocked_type'], $form['ed_blocked_value']);
		$ed_success = __('Detail was successfully inserted.', 'email-download-link');
	}
}

if ($ed_error_found == TRUE && isset($ed_errors[0]) == TRUE) {
	?><div class="error fade"><p><strong><?php echo $ed_errors[0]; ?></strong></p></div><?php
}
if ($ed_error_found == FALSE && isset($ed_success[0]) == TRUE) {
	?><div class="updated fade"><p><strong><?php echo $ed_success; ?></strong></p></div><?php
}
?>
<style>
.form-table th {
    width: 300px;
}
</style>
<div class="form-wrap">
	<form name="ed_form" method="post" action="#" onsubmit="return _ed_filter_submit()">
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="elp"><strong><?php _e('Blocked Details', 'email-download-link'); ?></strong>
					<p class="description"><?php _e('Seeing spam from particular domains? Enter domains/email/ip names that you want to block here.', 'email-download-link'); ?></p></label>
				</th>
				<td>
					<select name="ed_blocked_type" id="ed_blocked_type">
						<option value='Badword'>Block - Bad Word</option>
						<option value='Domain'>Block Domain</option>
						<option value='IP'>Block IP</option>
						<option value='Email'>Block Email</option>
						<option value='Others'>Others</option>
					</select>
					<input name="ed_blocked_value" type="text" id="ed_blocked_value" value="" size="45" maxlength="150" />
					<p class="description">Sample input : @example.com (or) 11.101.101.121 (or) test@test.com <br /> Bad Word : Submission rejected if name or email contain this word.</p>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="ed_form_submit" value="yes"/>
	<p class="submit">
		<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'email-download-link'); ?>" type="submit" />
		<input name="cancel" id="cancel" class="button button-primary" value="<?php _e('Cancel', 'email-download-link'); ?>" type="button" onclick="_ed_security_redirect('filter')" />
		<input name="help" id="help" class="button button-primary" value="<?php _e('Help', 'email-download-link'); ?>" type="button" onclick="_ed_security_help()" />
	</p>
	<?php wp_nonce_field('ed_form_add'); ?>
    </form>
</div>
<div class="wrap">
	<?php echo 'Your IP : ' . ed_cls_common::ed_get_subscriber_ip(); ?>
    <div class="tool-box">
	<?php
	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	$limit = 30;
	$offset = ($pagenum - 1) * $limit;
	$total = ed_cls_filter::ed_filter_count(0);
	$fulltotal = $total;
	$total = ceil( $total / $limit );

	$myData = array();
	$myData = ed_cls_filter::ed_filter_select(0, $offset, $limit);
	?>
	<form name="frm_ed_display" method="post" onsubmit="">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
		  	<th scope="col"><?php _e('No', 'email-download-link'); ?></th>
			<th scope="col"><?php _e('Blocked Type', 'email-download-link'); ?></th>
			<th scope="col"><?php _e('Blocked Value', 'email-download-link'); ?></th>
			<th scope="col"><?php _e('Created', 'email-download-link'); ?></th>
			<th scope="col"><?php _e('Action', 'email-download-link'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th scope="col"><?php _e('No', 'email-download-link'); ?></th>
			<th scope="col"><?php _e('Blocked Type', 'email-download-link'); ?></th>
			<th scope="col"><?php _e('Blocked Value', 'email-download-link'); ?></th>
			<th scope="col"><?php _e('Created', 'email-download-link'); ?></th>
			<th scope="col"><?php _e('Action', 'email-download-link'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0) {
				$i = 1;
				foreach ($myData as $data) {
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td><?php echo $i; ?></td>
						<td><?php echo esc_html($data['ed_blocked_type']); ?></td>
						<td><?php echo esc_html($data['ed_blocked_value']); ?></td>
						<td>
						<?php 
						$date_format = get_option( 'date_format' );
						$time_format = get_option( 'time_format' );
						echo date($date_format . ' ' . $time_format, strtotime($data['ed_blocked_created']));  
						?>
						</td>
						<td>
						<a title="Delete" onClick="javascript:_ed_filter_delete('<?php echo $data['ed_blocked_id']; ?>')" href="javascript:void(0);">
							<img alt="Delete" src="<?php echo ED_URL; ?>images/delete.gif" />
						</a>
						</td>
					</tr>
					<?php
					$i = $i+1;
				}
			}
			else {
				?><tr><td colspan="5" align="center"><?php _e('No records available.', 'email-download-link'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('ed_form_show'); ?>
		<input type="hidden" name="frm_ed_display" value="yes"/>
		<div style="padding-top:10px;"></div>
		<?php
		$page_links = paginate_links( array(
			'base' => add_query_arg( 'pagenum', '%#%' ),
			'format' => '',
			'prev_text' => __( ' &lt;&lt; ' ),
			'next_text' => __( ' &gt;&gt; ' ),
			'total' => $total,
			'show_all' => False,
			'current' => $pagenum
		) );
		?>
		<style>
		.page-numbers {
			background: none repeat scroll 0 0 rgba(0, 0, 0, 0.05);
    		border-color: #CCCCCC;
			color: #555555;
    		padding: 5px;
			text-decoration:none;
			margin-left:2px;
			margin-right:2px;
		}
		.current {
			background: none repeat scroll 0 0 #BBBBBB;
		}
		</style>
		<div class="tablenav">
			<div class="alignleft"></div>
			<div class="alignright"><?php echo $page_links; ?></div>
		</div>
      </form>
	</div>
</div>