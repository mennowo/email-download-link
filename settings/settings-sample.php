<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php

?>
<style>
.form-table th {
    width: 350px;
}
</style>
<div class="form-wrap">
	<form name="ed_form" method="post" action="#">
	<table class="form-table">
	<tbody>
		<tr>
			<th scope="row">
				<label for="ed"><strong></strong>
				<p class="description"></p></label>
			</th>
			<td>
				
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong></strong>
				<p class="description"></p></label>
			</th>
			<td>
				
			</td>
		</tr>
		<tr>
			<th scope="row"> 
				<label for="ed"><strong></strong>
				<p class="description"></p></label>
			</th>
			<td>			
				
			</td>
		</tr>
	</tbody>
	</table>
	<input type="hidden" name="ed_form_submit" value="yes"/>
	<input type="hidden" name="ed_c_id" id="ed_c_id" value="<?php echo $form['ed_c_id']; ?>"/>
	<p class="submit">
	<input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'email-posts-to-subscribers'); ?>" type="submit" />
	<input name="cancel" id="cancel" class="button button-primary" value="<?php _e('Cancel', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_cancel('common')" />
	<input name="help" id="help" class="button button-primary" value="<?php _e('Help', 'email-posts-to-subscribers'); ?>" type="button" onclick="_ed_help()" />
	</p>
	<?php wp_nonce_field('ed_form_edit'); ?>
    </form>
</div>