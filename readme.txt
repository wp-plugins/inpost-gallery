=== InPost Gallery ===
Contributors: RealMag777
Donate link: http://www.pluginus.net/
Tags: gallery, album, photo, photoalbum, photogallery, custom, website, multiple, pictures, post, plugin
Requires at least: 3.5.0
Tested up to: 3.5.1
Stable tag: 1.1.5


== Description ==

Set gallery everywere on your site using shortcodes like [inpost_gallery post_id=1] in post (page and custom post types optional) or <?php echo do_shortcode("[inpost_gallery post_id=1]") ?> in theme.
Each gallery belongs to post or page, but you can dispay it where you want by shortcode. To start using this plugin simply install it.
Good for photographers. Supports multiple image uploading and adding.

* [inpost_gallery post_id=1 group=20].
* [inpost_gallery post_id=1 thumb_width=200 thumb_height=200].
* [inpost_gallery post_id=1 id=2,5,9,3 thumb_width=200 thumb_height=200].
* [inpost_gallery post_id=1 random=5 thumb_width=200 thumb_height=200].
* [inpost_gallery post_id=1 random=-1 thumb_width=200 thumb_height=200].
* [inpost_gallery post_id=1 random=-1 thumb_width=200 thumb_height=200 border="solid 1px #000"].
* group - you can categorize gallery images by groups (numbers 1 - 100).
* thumb_width and thumb_height - works only in timthumb mode.
* id=2,5,9,3 - out slides whith number (white number on thumb in admin). Works if no group or group="all".
* random=-1 - random slides and out all.
* random=5 - shuffle slides and out 5 of them.
* border - set border around thumbnail image. Use CSS rule.



== Installation ==
* Download to your plugin directory. Or simply install via Wordpress admin interface.
* Activate.
* Configure the plugin in settings page <your_site>/wp-admin/options-general.php?page=inpost-gallery-settings.


== Frequently Asked Questions ==

Q: Where can I see demo?
R: http://pluginus.net/inpost-gallery


== Screenshots ==

1. In post/page panel
2. Settings page


== Changelog ==

= 1.1.5 =
In http://<your_site>/wp-admin/options-general.php?page=inpost-gallery-settings new ability to check custom post types (post and page too) where you want to use plugin.

= 1.1.4 =
Added attribute in shortcode "border". Example: [inpost_gallery post_id=327 random=-1 thumb_width=150 thumb_height=150 border="solid 2px #000"]. Useful to set border around of image by CCS syntax.

= 1.1.3 =
2 big improvements: multiple image adding and categorizing by groups. Them both very convinient for photographers.

= 1.1.2 =
Code fully rewritten. Added settings page <your_site>/wp-admin/options-general.php?page=inpost-gallery-settings. Able to switch of timthumb (recomend). Margin of thumbs on front are in settings. A lot of improvements.

= 1.1.1 =
1 warning removed

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

This plugin is copyright pluginus.net ɠ2012 with [GNU General Public License][] by realmag777.

This program is free software; you can redistribute it and/or modify it under
the terms of the [GNU General Public License][] as published by the Free
Software Foundation; either version 2 of the License, or (at your option) any
later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY. See the GNU General Public License for more details.

  [GNU General Public License]: http://www.gnu.org/copyleft/gpl.html


== Upgrade Notice ==
If you are upgrading to v.1.1.2 and timthumb (plugin) works well, do not switch it off. Just set margins of front thumbs on settings page.
