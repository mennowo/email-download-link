=== Email download link ===
Contributors: gopiplus, www.gopiplus.com
Donate link: http://www.gopiplus.com/work/donation.php
Author URI: http://www.gopiplus.com/work/
Plugin URI: http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/
Tags: contact form, download, download form, email link
Requires at least: 4.0
Tested up to: 6.0
Stable tag: 3.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This will send a download link to user after they have submitted a form.  i.e. Send email with download link to users after signing up.

== Description ==

This plugin will send a download link to user after they have submitted a form. i.e. Send email with download link to users after signing up. There are lots of reasons you might want to send to a download link to your user after they have submitted a form.

Check official website for live demo [http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/](http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/)

*   [Live Demo](http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/ "Live Demo")
*   [Documentation](http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/ "Documentation")
*   [Video Tutorial](http://www.gopiplus.com/work/2016/03/01/email-download-link-wordpress-plugin/ "Video Tutorial")

### Benefits of this plugin

*  Send free PDF/IMG/ZIP document download link after signing up for a newsletter.
*  Protect your download link from anonymous users.
*  Create download link with expiration date.
*  Track your download history.
*  Export signing up email address.
*  Refresh download link automatically with specific interval.
*  Google reCAPTCHA option.
*  Security/badword filter to protect download form.
*  Throttling mechanism to protect spam submission.
*  Option to enable/disable GDPR checkbox.

### Plugin configuration

= Short code for posts and pages =

This can be used in any page or post within your blog. When your blog encounters text formatted in this style and recognizes it as a >Email download link subscription box.

`[email-download-link namefield="YES" id="1"]`

`[email-download-link namefield="YES" group="Default"]`

`[email-download-link namefield="NO" group="Default" phone="YES"]`

Please check official website for more info about short code.

= Add directly in the theme =

Copy and past the below mentioned php code to your desired template location (i.e in theme PHP file).

`<?php ed_download_link( $namefield = "YES", $desc = ""); ?>`

= Widget option =

To add Email download link Subscriptions Box widget to your sidebar, go to your Dashboard. and then click on Widgets menu. You will see a widget called Email download link. Click Add Widget button or drag it to the sidebar on the right.

= Translators =

Translations inside plugin :

Portuguese (Brazil) [Flavio Escobar](http://www.flavioescobar.com.br)

== Installation ==

Option 1:

1. Go to WordPress Dashboard->Plugins->Add New
2. Search Email download link plugin using search option
3. Find the plugin and click Install Now button
4. After installtion, click on Activate Plugin link to activate the plugin.

Option 2:

1. Download the plugin email-download-link.zip
2. Unpack the email-download-link.zip file and extract the email-download-link folder
3. Upload the plugin folder to your /wp-content/plugins/ directory
4. Go to WordPress dashboard, click on Plugins from the menu
5. Locate the Email download link plugin and click on Activate link to activate the plugin.

Option 3:

1. Download the plugin email-download-link.zip
2. Go to WordPress Dashboard->Plugins->Add New
3. Click on Upload Plugin link from top
4. Upload the downloaded email-download-link.zip file and click on Install Now
5. After installtion, click on Activate Plugin link to activate the plugin.

== Frequently Asked Questions ==

*  Q1. What are all the steps to do after plugin activation?
*  Q2. How to setup download link box in widget?
*  Q3. How to update default messages from this plugin?
*  Q4. How to update default messages from this plugin?
*  Q5. How to refresh/change the download link automatically?

== Screenshots ==

1. Front Page - Subscription download link box

2. Admin 1 - Create download link page

2. Admin 2 - Cron Details page

2. Admin 3 - Admin Settings page

2. Admin 4 - Admin download history page

3. Admin 5 - Admin widget settings page

== Changelog ==

= 1.0 =

* First version

= 1.1 =

* Download link creation validation issue has been fixed.
* HTML content allowed in mail description.

= 1.2 =

* Tested up to 4.6

= 1.3 =

* Tested up to 4.7
* Option added to export email address.

= 1.3.1 =

* Verion 1.3 design issue fixed.

= 1.4 =

* Tested up to 4.8

= 1.5 =

* Tested up to 4.9

= 1.6 =

* Version 1.5 bug fix
* WP Cron option to refresh download link
* Group option in download form to group the download links

= 1.6.1 =

* Version 1.6 bug fix

= 1.7 =

* Google reCAPTCHA option added in the plugin. reCAPTCHA helps prevent bots from adding fake or malicious email addresses to your list.

= 1.8 =

* Tested up to 5.0
* Typo error in Download Form is fixed
* "Updating Failed" error message when adding plugin shortcode in Shortcode Block is fixed

= 1.9 =

* Tested up to 5.1

= 2.0 =

* Tested up to 5.2

= 2.0 =

* Tested up to 5.2
* New keywords (###NAME###, ###EMAIL###, ###TITLE###) added for download link email subject
* Feature added to set the position after form submit.

= 2.1 =

* Tested up to 5.3
* Option added to NOT SAVE name and email address. This will be useful those who don't want to save their downloader name and email. Save downloader name/email option at plugin setting page. This option is useful for GDPR privacy policy.

= 2.2 =

* Changes in the download forms, Ajax submission introduced to stop duplicate email.

= 2.3 =

* Bug in the uninstall.php is fixed.
* Direct download link is added in the download page.
* Admin option added to update form successful submit message (Go to setting page in the admin dashboard to find the option).
* Download history (Name and Email) will be deleted automatically after N number of days. (Go to setting page in the admin dashboard to find the option to set number of days).

= 2.4 =

* Option added in the setting admin page to SHOW or HIDE direct download link in the download page.

= 2.5 =

1. New admin layout for settings and security menu. 
2. Added security option in the download form submission (Option to block the submission by Domain, IP).
3. Throttling mechanism is added to protect spam submission.
4. Option added to filter bad word in the download form name.
5. Plugin date and time format is changed in the admin display as per default format of the blog.
6. New default template design is added in the plugin template section.
7. Option added to enable/disable GDPR checkbox in download form.

= 2.6 =

* Bug fix - Email not send if GDPR checkbox is not checked.

= 2.7 =

1. Phone number input box added in the download form. (New parameter in short code)
2. <span> tag added for the download box caption. Now we can hide Name and Email caption in the download form using below CSS class.

= 2.8 =

* Tested up to 5.4

= 2.9 =

* Tested up to 5.5

= 3.0 =

* Tested up to 5.6
* New export option added to export download emails with download form title.

= 3.1 =

* CURLOPT_USERAGENT parameter added in the download code.
* Minor cosmetic change in the form. 

= 3.2 =

* Tested up to 5.7

= 3.3 =

* Tested up to 5.8
* Use plugin short code in the widget.

= 3.4 =

* Added new keyword ###PHONE### in the admin mail content.

= 3.5 =

* Tested up to 5.9
* Added new option in the cron run (Refresh on every Mon, Wed and Friday)

= 3.6 =

* Tested up to 5.9.3
* Added CSS class to the download form to use it to change the form design.

= 3.7 =

* Tested up to 6.0
* Security fix

== Upgrade Notice ==

= 1.0 =

* First version

= 1.1 =

* Download link creation validation issue has been fixed.
* HTML content allowed in mail description.

= 1.2 =

* Tested up to 4.6

= 1.3 =

* Tested up to 4.7
* Option added to export email address.

= 1.3.1 =

* Verion 1.3 design issue fixed.

= 1.4 =

* Tested up to 4.8

= 1.5 =

* Tested up to 4.9

= 1.6 =

* Version 1.5 bug fix
* WP Cron option to refresh download link
* Group option in download form to group the download links

= 1.6.1 =

* Version 1.6 bug fix

= 1.7 =

* Google reCAPTCHA option added in the plugin. reCAPTCHA helps prevent 
bots from adding fake or malicious email addresses to your list.

= 1.8 =

* Tested up to 5.0
* Typo error in Download Form is fixed
* "Updating Failed" error message when adding plugin shortcode in Shortcode Block is fixed

= 1.9 =

* Tested up to 5.1

= 2.0 =

* Tested up to 5.2
* New keywords (###NAME###, ###EMAIL###, ###TITLE###) added for download link email subject
* Feature added to set the position after form submit.

= 2.1 =

* Tested up to 5.3
* Option added to NOT SAVE name and email address. This will be useful those who don't want to save their downloader name and email. Save downloader name/email option at plugin setting page. This option is useful for GDPR privacy policy.

= 2.2 =

* Changes in the download forms, Ajax submission introduced to stop duplicate email.

= 2.3 =

* Bug in the uninstall.php is fixed.
* Direct download link is added in the download page.
* Admin option added to update form successful submit message (Go to setting page in the admin dashboard to find the option).
* Download history (Name and Email) will be deleted automatically after N number of days. (Go to setting page in the admin dashboard to find the option to set number of days).

= 2.4 =

* Option added in the setting admin page to SHOW or HIDE direct download link in the download page.

= 2.5 =

1. New admin layout for settings and security menu. 
2. Added security option in the download form submission (Option to block the submission by Domain, IP).
3. Throttling mechanism is added to protect spam submission.
4. Option added to filter bad word in the download form name.
5. Plugin date and time format is changed in the admin display as per default format of the blog.
6. New default template design is added in the plugin template section.
7. Option added to enable/disable GDPR checkbox in download form.

= 2.6 =

* Bug fix - Email not send if GDPR checkbox is not checked.

= 2.7 =

1. Phone number input box added in the download form. (New parameter in short code)
2. <span> tag added for the download box caption. Now we can hide Name and Email caption in the download form using below CSS class.

= 2.8 =

* Tested up to 5.4

= 2.9 =

* Tested up to 5.5

= 3.0 =

* Tested up to 5.6
* New export option added to export download emails with download form title.

= 3.1 =

* CURLOPT_USERAGENT parameter added in the download code.
* Minor cosmetic change in the form. 

= 3.2 =

* Tested up to 5.7

= 3.3 =

* Tested up to 5.8
* Use plugin short code in the widget.

= 3.4 =

* Added new keyword ###PHONE### in the admin mail content.

= 3.5 =

* Tested up to 5.9
* Added new option in the cron run (Refresh on every Mon, Wed and Friday)

= 3.6 =

* Tested up to 5.9.3
* Added CSS class to the download form to use it to change the form design.

= 3.7 =

* Tested up to 6.0
* Security fix
