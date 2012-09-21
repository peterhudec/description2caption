=== Description 2 Caption ===
Contributors: PeterHudec
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GB4S3N2XJMRCN
Tags: description, caption, IPTC, lightroom
Requires at least: 2.7
Tested up to: 3.4
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tweaks default Wordpress behaviour when IPTC caption of an uploaded image
gets to description instead of caption field of the uploaded media form.

== Description ==

This plugin allows you to override the default Wordpress behaviour
by which the IPTC caption of an uploaded image is passed to the description field instead of
the caption field of the uploaded media form.
The **Insert into Post** button then uses the caption in the **Caption shortcode** like this:
`[caption]<img (...) /> Caption[/caption]`

This is not quite desired if you frequently upload plenty of images
with IPTC caption written in Photomechanic, Lightroom, Photoshop or any other tool.

There is only one setting which gives you the option to choose
whether you want to copy or move the description to caption.

== Installation ==

Copy the **description2caption** folder into the plugins directory and activate.

== Frequently Asked Questions ==

== Screenshots ==

1. Media upload form `media-upload-form.png`
2. Plugin options `plugin-options.png`

== Changelog ==

= 1.0 =
* Innitial version


