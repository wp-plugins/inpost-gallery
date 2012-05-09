=== InPost Gallery ===
Contributors: RealMag777
Donate link: http://www.pluginus.net/
Tags: gallery, image, gallery image, album, foto, fotoalbum, website gallery, multiple pictures, pictures, photo, photoalbum, photogallery, post, Posts, plugin
Requires at least: 3.0.0
Tested up to: 3.3.2
Stable tag: 1.0.2

Set gallery in post, page or everywere on your site by shortcode.

== Description ==

Set gallery everywere on your site using shortcodes like [inpost_gallery post_id=1] in post
or <?=do_shortcode("[inpost_gallery post_id=1]") ?> in wp theme.
Each gallery belongs to post or page. To start using this plugin simply install it. Now, in pages/posts appears panel "InPost Gallery".
Upload images you want see in your post, insert shortcode that is under "InPost Gallery" panel.

ATTENTION:
<strong>If plugin after upgrading from 1.0.1 to 1.0.2 doesn work, please do this instructions in your wp database:</strong>

* ALTER TABLE inpostgallery ADD sort INT(11) NOT NULL
* UPDATE `inpostgallery` SET `sort` = `id`


== Installation ==

= New Installations =
0.      Download plugin and then go by link http://your_site/wp-admin/plugin-install.php?tab=upload
	press "Install a plugin in .zip format", select inpost-gallery.zip, press "Install Now".

OR

1.	Download plugin archive in zip or gzipped tar format and
	extract the files on your computer.

2.	Create a new directory named `inpost-gallery` in the `wp-content/plugins`
	directory of your WordPress installation. Use an FTP or SFTP client to
	upload the contents of plugin archive to the new directory
	that you just created on your web host.

3.	Log in to the WordPress http://your_site/wp-admin/plugins.php and activate the plugin.

4.	Configure the plugin and add it to the plugin settings page.


== Frequently Asked Questions ==

Q: Where can I see demo?
R: http://pluginus.net/inpost-gallery/1

== Screenshots ==

1. In admin panel
2. On front

== Changelog ==

= 1.0.2 =
Couple of bugs. Images sorting.
If plugin after upgrading from 1.0.1 to 1.0.2 doesn work, please do this instructions in your wp database:
ALTER TABLE inpostgallery ADD sort INT(11) NOT NULL
UPDATE `inpostgallery` SET `sort` = `id`

= 1.0.1 =
Plugin release. Operate all the basic functions.

== License ==

This plugin is copyright pluginus.net © 2012 with [GNU General Public License][] by realmag777.

This program is free software; you can redistribute it and/or modify it under
the terms of the [GNU General Public License][] as published by the Free
Software Foundation; either version 2 of the License, or (at your option) any
later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY. See the GNU General Public License for more details.

  [GNU General Public License]: http://www.gnu.org/copyleft/gpl.html
== Upgrade Notice ==


== ToDo ==
The next version or later:


