=== Attachments ===
Contributors: jchristopher
Donate link: http://mondaybynoon.com/donate/
Tags: post, page, posts, pages, images, PDF, doc, Word, image, jpg, jpeg, picture, pictures, photos, attachment
Requires at least: 2.8
Tested up to: 2.9
Stable tag: 1.0

Attachments allows you to append any number of items from your WordPress Media Library to Posts and Pages

== Description ==

Attachments allows you to append any number of items from your WordPress Media Library to Posts and Pages. This plugin *does not* directly interact with your theme, you will need to edit your template files.

There is a **screencast available** on the [plugin home page](http://mondaybynoon.com/wordpress-attachments/)

== Installation ==

1. Download the plugin and extract the files
1. Upload `attachments` to your `~/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Update your templates where applicable (see **Usage**)

== Usage ==

After installing Attachments, you will need to update your template files in order to pull the data to the front end.

To pull all Attachments for a Post or Page, fire `attachments_get_attachments()`. There is one optional parameter which can force a Post ID if `attachments_get_attachments()` is fired outside The Loop. If used inside The Loop, all Attachments will be pulled for the current Post or Page.

Firing `attachments_get_attachments()` returns an array consisting of all available Attachments. Currently each Attachment has four pieces of data available:

* **title** - The attachment Title
* **caption** - The attachment Caption
* **id** - The WordPress assigned attachment id (for use with other WordPress media functions)
* **location** - The attachment URI

Here is a basic implementation:

`<?php 
  $attachments = attachments_get_attachments();
  $total_attachments = count($attachments);
  if( $total_attachments > 0 )
  {
    echo '<ul>';
    for ($i=0; $i < $total_attachments; $i++)
    {
      echo '<li>' . $attachments[$i]['title'] . '</li>';
      echo '<li>' . $attachments[$i]['caption'] . '</li>';
      echo '<li>' . $attachments[$i]['id'] . '</li>';
      echo '<li>' . $attachments[$i]['location'] . '</li>';
    }
    echo '</ul>';
  }
?>`

You can elaborate on this implementation in any way you see fit.

== Frequently Asked Questions ==

= Attachments are not showing up in my theme =

You will need to edit your theme files where applicable. Please reference the **Usage** instructions

= Where are uploads saved? =

Attachments uses WordPress' built in Media library for uploads and storage.

== Screencast ==

There is a **screencast available** on the [plugin home page](http://mondaybynoon.com/wordpress-attachments/)

== Changelog ==

= 1.0 =
* First stable release