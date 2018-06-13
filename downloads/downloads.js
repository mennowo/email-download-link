function _ed_downloads_submit()
{
	if( document.ed_form.ed_form_group_txt.value != "" )
	{
		document.ed_form.ed_form_group_txt.value = document.ed_form.ed_form_group_txt.value.replace(/[^a-zA-Z0-9]/g, '');
	}
	
	if(document.ed_form.ed_form_downloadurl.value == "")
	{
		alert(ed_downloads_script.ed_add_link)
		document.ed_form.ed_form_downloadurl.focus();
		return false;
	}
	else if(document.ed_form.ed_form_title.value == "")
	{
		alert(ed_downloads_script.ed_add_title)
		document.ed_form.ed_form_title.focus();
		return false;
	}
	else if( (document.ed_form.ed_form_group.value == "") && (document.ed_form.ed_form_group_txt.value == "") )
	{
		alert(ed_downloads_script.ed_add_group)
		document.ed_form.ed_form_group_txt.focus();
		return false;
	}
	else if(document.ed_form.ed_form_expirationdate.value == "")
	{
		alert(ed_downloads_script.ed_add_expiration)
		document.ed_form.ed_form_expirationdate.focus();
		return false;
	}
}

function _ed_delete(guid)
{
	if(confirm(ed_downloads_script.ed_delete_record))
	{
		document.frm_ed_display.action="admin.php?page=ed-downloads&ac=del&guid="+guid;
		document.frm_ed_display.submit();
	}
}

function _ed_redirect()
{
	window.location = "admin.php?page=ed-downloads";
}

function _ed_help()
{
	window.open("http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/");
}