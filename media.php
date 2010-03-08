	<div id="attachments-file-list">
		<p>Available attachments are listed from your <strong>Media Library</strong>. If you need to upload a new attachment, please close this dialog and use the available <strong>Add to Media Library</strong> button.</p>
		<p>Select/deselect an attachment by clicking its thumbnail. When you're done managing your attachments, click <strong>Apply</strong></p>

		<p class="attachments-actions"><a href="#" class="attachments-apply button button-highlighted">Apply</a></p>

		<div id="attachments-file-details">

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

	<p class="attachments-actions"><a href="#" class="attachments-apply button button-highlighted">Apply</a></p>

	</div>
