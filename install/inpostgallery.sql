CREATE TABLE IF NOT EXISTS `inpostgallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `image_file_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `image_title` text COLLATE utf8_unicode_ci NOT NULL,
  `image_description` text COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;