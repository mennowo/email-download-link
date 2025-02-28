function _ed_security_help() {
	window.open("http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/");
}

function _ed_security_redirect(action) {
	window.location = "admin.php?page=ed-security&tab=" + action;
}

function _ed_filter_delete(id) {
	if(confirm(ed_security_script.ed_delete_record))
	{
		document.frm_ed_display.action="admin.php?page=ed-security&tab=filter&ac=del&did="+id;
		document.frm_ed_display.submit();
	}
}

function _ed_captcha_submit() {
	if(document.ed_form.ed_captcha_widget.value == "YES" && document.ed_form.ed_captcha_sitekey.value == "") {
		alert(ed_security_script.ed_recaptcha_sitekey_add);
		document.ed_form.ed_captcha_sitekey.focus();
		return false;
	}
	else if(document.ed_form.ed_captcha_widget.value == "YES" && document.ed_form.ed_captcha_secret.value == "") {
		alert(ed_security_script.ed_recaptcha_secretkey_add);
		document.ed_form.ed_captcha_secret.focus();
		return false;
	}
	else if(document.ed_form.ed_captcha_widget.value == "YES" && document.ed_form.ed_captcha_sitekey.value.length < 20)	{
		alert(ed_security_script.ed_recaptcha_sitekey_add);
		document.ed_form.ed_captcha_sitekey.focus();
		return false;
	}
	else if(document.ed_form.ed_captcha_widget.value == "YES" && document.ed_form.ed_captcha_secret.value.length < 20) {
		alert(ed_security_script.ed_recaptcha_secretkey_add);
		document.ed_form.ed_captcha_secret.focus();
		return false;
	}
}

function _ed_filter_submit() {
	if(document.ed_form.ed_blocked_type.value == "") {
		alert(ed_security_script.ed_blocked_type);
		document.ed_form.ed_blocked_type.focus();
		return false;
	}
	else if(document.ed_form.ed_blocked_value.value == "") {
		alert(ed_security_script.ed_blocked_value);
		document.ed_form.ed_blocked_value.focus();
		return false;
	}
}