=== Email download link ===
Original author: gopiplus, www.gopiplus.com
Author for version 2.0.0: Menno van der Woude, www.codingconnected.eu
Author URI: https://www.codingconnected.eu/
Tags: contact form, download, download form, email link
Requires at least: 4.0
Tested up to: 4.9.6
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This will send a download link to user after they have submitted a form.  i.e. Send email with download link to users after signing up.

== Description ==

This plugin will send a download link to user after they have submitted a form. i.e. Send email with download link to users after signing up. There are lots of reasons you might want to send to a download link to your user after they have submitted a form.

### Benefits of this plugin

*  Send free PDF/IMG/ZIP document download link after signing up for a newsletter.
*  Protect your download link from anonymous users.
*  Create download link with expiration date.
*  Track your download history.
*  Export signing up email address.
*  Refresh download link automatically with specific interval.

### Plugin configuration

= Short code for posts and pages =

This can be used in any page or post within your blog. When your blog encounters text formatted in this style and recognizes it as a >Email download link subscription box.

`[email-download-link namefield="YES" desc=""]`

`[email-download-link namefield="YES" group="Default"]`

= Add directly in the theme =

Copy and past the below mentioned php code to your desired template location (i.e in theme PHP file).

`<?php ed_download_link( $namefield = "YES", $desc = ""); ?>`

= Widget option =

To add Email download link Subscriptions Box widget to your sidebar, go to your Dashboard. and then click on Widgets menu. You will see a widget called Email download link. Click Add Widget button or drag it to the sidebar on the right.

= Translators =

Translations inside plugin :

Portuguese (Brazil) [Flavio Escobar](http://www.flavioescobar.com.br)
Dutch (Netherlands) [Menno van der Woude](https://www.codingconnected.eu)

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

= 2.0.0 =

* Added an option to display a checkbox for privacy consent.

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

= 2.0.0 =

* Added an option to display a checkbox for privacy consent.