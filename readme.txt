=== InPost Gallery ===
Contributors: RealMag777
Donate link: http://www.pluginus.net/
Tags: gallery, image, gallery image, album, foto, fotoalbum, website gallery, multiple pictures, pictures, photo, photoalbum, photogallery, post, Posts, plugin
Requires at least: 3.0.0
Tested up to: 3.4.2
Stable tag: 1.1.0

Set gallery in post, page or everywere on your site by shortcode.

== Description ==

Set gallery everywere on your site using shortcodes like [inpost_gallery post_id=1] in post
or <?php echo do_shortcode("[inpost_gallery post_id=1]") ?> in wp theme.
Each gallery belongs to post or page. To start using this plugin simply install it. Now, in pages/posts appears panel "InPost Gallery".
Upload images you want see in your post, insert shortcode that is under "InPost Gallery" panel.

* [inpost_gallery post_id=1 thumb_width=200 thumb_height=200]
* [inpost_gallery post_id=1 id=77,23,44,66 thumb_width=200 thumb_height=200]
* [inpost_gallery post_id=1 random=5 thumb_width=200 thumb_height=200]
* [inpost_gallery post_id=1 random=-1 thumb_width=200 thumb_height=200]


ATTENTION:
<strong>Set folder permissons for wp-content/plugins/inpost-gallery/inpost-gallery as 0777 by your ftp client</strong>


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
R: http://pluginus.net/mea/inpost-gallery/1

== Screenshots ==

1. In admin panel

== Changelog ==

= 1.1.0 =
Fixed bug in jquery.yoxview-2.21.js, for uploading images appointed wordpress uploader, couple of bugs removed + a lot of improvements...

= 1.0.5 =
Upload folder moved to wp-content uploads and named as inpost-gallery-uploads

= 1.0.4 =
Empty folder was in zip, sorry....

= 1.0.3 =
Fixed bugs in admin panel with javascript. random mode - [inpost_gallery post_id=1 random=10], where 10 is count of random pictures.
Width of thumbnail is changeable.

= 1.0.2 =
Couple of bugs. Images sorting.


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


