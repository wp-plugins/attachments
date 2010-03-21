<?php

	error_reporting(0);
	require( dirname(__FILE__) . '/../../../wp-config.php' );

	global $wpdb;
	global $userdata;

	// set the user info in case we need to limit to the current author
	get_currentuserinfo();

	if( get_option('attachments_limit_to_user') == 'true' )
	{
		$attachments_sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' AND post_author = " . $userdata->ID . " ORDER BY post_modified DESC";
	}
	else
	{
		$attachments_sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' ORDER BY post_modified DESC";
	}

	$attachment_files = $wpdb->get_results( $attachments_sql );

?>

	<div id="attachments-file-list">
		<p><?php _e("Available attachments are listed from your", "attachments"); ?> <strong><?php _e("Media Library", "attachments"); ?></strong>. <?php _e("If you need to upload a new attachment, please close this dialog and use the available", "attachments"); ?> <strong><?php _e("Add to Media Library", "attachments"); ?></strong> <?php _e("button", "attachments"); ?></p>
		<p><?php _e("Select/deselect an attachment by clicking its thumbnail. When you're done managing your attachments, click ", "attachments")?><strong><?php _e("Apply", "attachments")?></strong></p>

		<p class="attachments-actions"><a href="#" class="attachments-apply button button-highlighted"><?php _e("Apply", "attachments"); ?></a></p>

		<div id="attachments-file-details">

			<?php

			// ================
			// = IMAGES FIRST =
			// ================
			echo '<div class="attachments-file-section attachments-images">';
			echo '<h2>' . __("Images", "attachments") . '</h2>';
			echo '<ul>';
			foreach ($attachment_files as $post)
			{
				if ( strpos($post->post_mime_type, 'image') !== false )
				{
					echo '<li>';
					echo '<a href="#">';
					echo '<span class="attachments-data">';
					echo '<span class="attachment-file-name">' . $post->post_name . '</span>';
					echo '<span class="attachment-file-id">' . $post->ID . '</span>';
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
			echo '<h2>' . __("Videos", "attachments") . '</h2>';
			echo '<ul>';
			foreach ($attachment_files as $post)
			{
				if ( strpos($post->post_mime_type, 'video') !== false )
				{
					echo '<li>';
					echo '<a href="#">';
					echo '<span class="attachments-data">';
					echo '<span class="attachment-file-name">' . $post->post_name . '</span>';
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




			// =============
			// = DOCUMENTS =
			// =============
			echo '<div class="attachments-file-section attachments-alt attachments-documents">';
			echo '<h2>' . __("Documents", "attachments") . '</h2>';
			echo '<ul>';
			foreach ($attachment_files as $post)
			{
				if ( strpos($post->post_mime_type, 'application') !== false )
				{
					echo '<li>';
					echo '<a href="#">';
					echo '<span class="attachments-data">';
					echo '<span class="attachment-file-name">' . $post->post_name . '</span>';
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




			// =========
			// = AUDIO =
			// =========
			echo '<div class="attachments-file-section attachments-alt attachments-audio">';
			echo '<h2>' . __("Audio", "attachments") . '</h2>';
			echo '<ul>';
			foreach ($attachment_files as $post)
			{
				if ( strpos($post->post_mime_type, 'audio') !== false )
				{
					echo '<li>';
					echo '<a href="#">';
					echo '<span class="attachments-data">';
					echo '<span class="attachment-file-name">' . $post->post_name . '</span>';
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

		?>

	</div>

	<p class="attachments-actions"><a href="#" class="attachments-apply button button-highlighted"><?php _e("Apply", "attachments"); ?></a></p>

	</div>
