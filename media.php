<?php
error_reporting(0);
require( dirname(__FILE__) . '/../../../wp-config.php' );

global $wpdb;

$attachment_files = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' ORDER BY post_modified DESC" );


// ================
// = IMAGES FIRST =
// ================
echo '<div class="attachments-file-section attachments-images">';
echo '<h2>Images</h2>';
echo '<ul>';
foreach ($attachment_files as $post)
{
	if ( strpos($post->post_mime_type, 'image') !== false )
	{
		echo '<li>';
		echo '<a href="#">';
		echo '<span class="attachments-data">';
		echo '<span class="attachment-file-name">' . $post->post_name . '</span>';
		echo '<span class="attachment-file-location">' . $post->guid . '</span>';
		echo '<span class="attachment-file-id">' . $post->ID . '</span>';
		echo '<span class="attachment-file-mime">' . $post->post_mime_type . '</span>';
		echo '</span>';
		echo '<span class="attachments-thumbnail">';
		echo wp_get_attachment_image( $post->ID, array(80, 60), true );
		echo '</span>';
		echo '</a>';
		echo '</li>';
	}
}
echo '</ul>';
echo '</div>';



// ==========
// = VIDEOS =
// ==========
echo '<div class="attachments-file-section attachments-alt attachments-videos">';
echo '<h2>Videos</h2>';
echo '<ul>';
foreach ($attachment_files as $post)
{
	if ( strpos($post->post_mime_type, 'video') !== false )
	{
		echo '<li>';
		echo '<a href="#">';
		echo '<span class="attachments-data">';
		echo '<span class="attachment-file-name">' . $post->post_name . '</span>';
		echo '<span class="attachment-file-location">' . $post->guid . '</span>';
		echo '<span class="attachment-file-id">' . $post->ID . '</span>';
		echo '<span class="attachment-file-mime">' . $post->post_mime_type . '</span>';
		echo '</span>';
		echo '<span class="attachments-thumbnail">';
		echo wp_get_attachment_image( $post->ID, array(80, 60), true );
		echo '</span>';
		echo '<h2 class="attachments-title-display">';
		echo $post->post_name;
		echo '</h2>';
		echo '</a>';
		echo '</li>';
	}
}
echo '</ul>';
echo '</div>';




// =============
// = DOCUMENTS =
// =============
echo '<div class="attachments-file-section attachments-alt attachments-documents">';
echo '<h2>Documents</h2>';
echo '<ul>';
foreach ($attachment_files as $post)
{
	if ( strpos($post->post_mime_type, 'application') !== false )
	{
		echo '<li>';
		echo '<a href="#">';
		echo '<span class="attachments-data">';
		echo '<span class="attachment-file-name">' . $post->post_name . '</span>';
		echo '<span class="attachment-file-location">' . $post->guid . '</span>';
		echo '<span class="attachment-file-id">' . $post->ID . '</span>';
		echo '<span class="attachment-file-mime">' . $post->post_mime_type . '</span>';
		echo '</span>';
		echo '<span class="attachments-thumbnail">';
		echo wp_get_attachment_image( $post->ID, array(80, 60), true );
		echo '</span>';
		echo '<h2 class="attachments-title-display">';
		echo $post->post_name;
		echo '</h2>';
		echo '</a>';
		echo '</li>';
	}
}
echo '</ul>';
echo '</div>';




// =========
// = AUDIO =
// =========
echo '<div class="attachments-file-section attachments-alt attachments-audio">';
echo '<h2>Audio</h2>';
echo '<ul>';
foreach ($attachment_files as $post)
{
	if ( strpos($post->post_mime_type, 'audio') !== false )
	{
		echo '<li>';
		echo '<a href="#">';
		echo '<span class="attachments-data">';
		echo '<span class="attachment-file-name">' . $post->post_name . '</span>';
		echo '<span class="attachment-file-location">' . $post->guid . '</span>';
		echo '<span class="attachment-file-id">' . $post->ID . '</span>';
		echo '</span>';
		echo '<span class="attachments-thumbnail">';
		echo wp_get_attachment_image( $post->ID, array(80, 60), true );
		echo '</span>';
		echo '<h2 class="attachments-title-display">';
		echo $post->post_name;
		echo '</h2>';
		echo '</a>';
		echo '</li>';
	}
}
echo '</ul>';
echo '</div>';