<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php ed_cls_common::ed_check_latest_update(); ?>
<?php 
$home_url = home_url('/');
$cnt_unique_details = ed_cls_subscribers::ed_subscribers_distinct_count();;
$cnt_full_details = ed_cls_subscribers::ed_subscribers_count(0, "", "", "");
?>

<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
  <h2><?php _e(ED_PLUGIN_DISPLAY, 'email-download-link'); ?></h2>
  <div class="tool-box">
  <h3><?php _e('Export email address in csv format', 'email-download-link'); ?></h3>
  <form name="frm_ed_subscriberexport" method="post">
  <table width="100%" class="widefat" id="straymanage">
    <thead>
      <tr>
        <th scope="col"><?php _e('Sno', 'email-download-link'); ?></th>
        <th scope="col"><?php _e('Export option', 'email-download-link'); ?></th>
		<th scope="col"><?php _e('Total email', 'email-download-link'); ?></th>
        <th scope="col"><?php _e('Action', 'email-download-link'); ?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th scope="col"><?php _e('Sno', 'email-download-link'); ?></th>
        <th scope="col"><?php _e('Export option', 'email-download-link'); ?></th>
		<th scope="col"><?php _e('Total email', 'email-download-link'); ?></th>
        <th scope="col"><?php _e('Action', 'email-download-link'); ?></th>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <td>1</td>
        <td><?php _e('Export unique email address.', 'email-download-link'); ?></td>
		<td><?php echo $cnt_unique_details; ?></td>
        <td><a onClick="javascript:_ed_exportcsv('<?php echo $home_url. "?ed=export"; ?>', 'ed_unique_details')" href="javascript:void(0);"><?php _e('Click to export csv', 'email-download-link'); ?></a> </td>
      </tr>
      <tr class="alternate">
        <td>2</td>
        <td><?php _e('Export all email address with download details.', 'email-download-link'); ?></td>
		<td><?php echo $cnt_full_details; ?></td>
        <td><a onClick="javascript:_ed_exportcsv('<?php echo $home_url. "?ed=export"; ?>', 'ed_full_details')" href="javascript:void(0);"><?php _e('Click to export csv', 'email-download-link'); ?></a> </td>
      </tr>
	  <tr>
        <td>1</td>
        <td><?php _e('Export downloads with title .', 'email-download-link'); ?></td>
		<td><?php echo $cnt_full_details; ?></td>
        <td><a onClick="javascript:_ed_exportcsv('<?php echo $home_url. "?ed=export"; ?>', 'ed_full_details_withtitle')" href="javascript:void(0);"><?php _e('Click to export csv', 'email-download-link'); ?></a> </td>
      </tr>
    </tbody>
  </table>
  </form>
  <div style="height:10px;"></div>
  <div class="tablenav bottom">
		<div class="alignleft actions">
			<a href="<?php echo ED_ADMINURL; ?>?page=ed-downloadhistory"><input class="button button-primary" type="button" value="<?php _e('Back', 'email-download-link'); ?>" /></a>
			<a href="<?php echo ED_ADMINURL; ?>?page=ed-downloadhistory&ac=export"><input class="button button-primary" type="button" value="<?php _e('Export Emails', 'email-download-link'); ?>" /></a>
			<a href="<?php echo ED_FAV; ?>" target="_blank"><input class="button button-primary" type="button" value="<?php _e('Help', 'email-download-link'); ?>" /></a>
		</div>
	</div>
  </div>
</div>