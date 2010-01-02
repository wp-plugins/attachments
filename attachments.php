<?php
/*
Plugin Name: Attachments
Plugin URI: http://mondaybynoon.com/wordpress-attachments/
Description: Attachments gives the ability to append any number of Media Library items to Pages and Posts
Version: 1.0.5
Author: Jonathan Christopher
Author URI: http://jchristopher.me/
*/

/*  Copyright 2009 Jonathan Christopher  (email : jonathandchr@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// ===========
// = GLOBALS =
// ===========

global $wpdb;



// =========
// = HOOKS =
// =========

add_action('admin_menu', 'attachments_init');
add_action('admin_head', 'attachments_init_js');
add_action('save_post', 'attachments_save');
add_action('admin_menu', 'attachments_menu');



// =============
// = FUNCTIONS =
// =============

/**
 * Compares two array values with the same key "order"
 *
 * @param string $a First value
 * @param string $b Second value
 * @return int
 * @author Jonathan Christopher
 */
function cmp($a, $b)
{
    return strcmp($a["order"], $b["order"]);
}




/**
 * Creates the markup for the WordPress admin options page
 *
 * @return void
 * @author Jonathan Christopher
 */
function attachments_options()
{ ?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2>Attachments Options</h2>
		<form action="options.php" method="post">
			<?php wp_nonce_field('update-options'); ?>
			<div style="padding:20px 0 0 0; overflow:hidden; zoom:1;">
				<input type="checkbox" name="attachments_limit_to_user" style="display:block; float:left; margin-top:2px;" value="true"<?php if (get_option('attachments_limit_to_user')=='true') : ?> checked="checked"<?php endif ?> />
				<span style="display:block; float:left; padding:0 0 0 7px;">Users can only see their own attachments</span>
			</div>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="attachments_limit_to_user" />
			<p class="submit">
				<input type="submit" class="button-primary" value="Save" />
			</p>
		</form>
	</div>
<?php }




/**
 * Creates the entry for Attachments Options under Settings in the WordPress Admin
 *
 * @return void
 * @author Jonathan Christopher
 */
function attachments_menu()
{
	add_options_page('Settings', 'Attachments', 8, __FILE__, 'attachments_options');
}




/**
 * Inserts HTML for meta box, including all existing attachments
 *
 * @return void
 * @author Jonathan Christopher
 */
function attachments_add()
{?>
	
	<div id="attachments-inner">
		
		<ul id="attachments-actions">
			<li id="attachments-browse"><a href="#" class="button button-highlighted browse-attachments">Browse</a></li>
			<li id="attachments-add-new"><a href="media-upload.php?post_id=-1257080594&amp;type=image&amp;TB_iframe=true&amp;width=640&amp;height=523" class="button thickbox">Add New</a></li>
		</ul>
		
		<div id="attachments-list">
			<input type="hidden" name="attachments_nonce" id="attachments_nonce" value="<?php echo wp_create_nonce( plugin_basename(__FILE__) ); ?>" />
			<ul>
				<?php
					if( !empty($_GET['post']) )
					{
						$existing_attachments = unserialize(get_post_meta(intval($_GET['post']), '_attachments', true));
						if( count($existing_attachments) > 0 )
						{
							if( count($existing_attachments) > 1 )
							{
								usort($existing_attachments, "cmp");
							}
							$attachment_index = 0;
							if( is_array($existing_attachments) && !empty($existing_attachments) )
							{
								foreach ($existing_attachments as $attachment) : $attachment_index++; ?>
									<li class="attachments-file">
										<h2>
											<a href="#" class="attachment-handle">
												<span class="attachment-handle-icon"><img src="<?php echo WP_PLUGIN_URL; ?>/attachments/images/handle.gif" alt="Drag" /></span>
											</a>
											<span class="attachment-name"><?php echo $attachment['name']; ?></span>
											<span class="attachment-delete"><a href="#">Delete</a></span>
										</h2>
										<div class="attachments-fields">
											<div class="textfield" id="field_attachment_title_<?php echo $attachment_index ; ?>">
												<label for="attachment_title_<?php echo $attachment_index; ?>">Title</label>
												<input type="text" id="attachment_title_<?php echo $attachment_index; ?>" name="attachment_title_<?php echo $attachment_index; ?>" value="<?php echo $attachment['title']; ?>" size="20" />
											</div>
											<div class="textfield" id="field_attachment_caption_<?php echo $attachment_index; ?>">
												<label for="attachment_caption_<?php echo $attachment_index; ?>">Caption</label>
												<input type="text" id="attachment_caption_<?php echo $attachment_index; ?>" name="attachment_caption_<?php echo $attachment_index; ?>" value="<?php echo $attachment['caption']; ?>" size="20" />
											</div>
										</div>
										<div class="attachments-data">
											<input type="hidden" name="attachment_name_<?php echo $attachment_index; ?>" id="attachment_name_<?php echo $attachment_index; ?>" value="<?php echo $attachment['name']; ?>" />
											<input type="hidden" name="attachment_location_<?php echo $attachment_index; ?>" id="attachment_location_<?php echo $attachment_index; ?>" value="<?php echo $attachment['location']; ?>" />
											<input type="hidden" name="attachment_mime_<?php echo $attachment_index; ?>" id="attachment_mime_<?php echo $attachment_index; ?>" value="<?php echo $attachment['mime']; ?>" />
											<input type="hidden" name="attachment_id_<?php echo $attachment_index; ?>" id="attachment_id_<?php echo $attachment_index; ?>" value="<?php echo $attachment['id']; ?>" />
											<input type="hidden" class="attachment_order" name="attachment_order_<?php echo $attachment_index; ?>" id="attachment_order_<?php echo $attachment_index; ?>" value="<?php echo $attachment['order']; ?>" />
										</div>
										<div class="attachment-thumbnail">
											<span class="attachments-thumbnail">
												<?php echo wp_get_attachment_image( $attachment['id'], array(80, 60), true ); ?>
											</span>
										</div>
									</li>
								<?php endforeach;
							}
						}
					}
				?>
			</ul>
		</div>
		
	</div>
	
<?php }



/**
 * Creates meta box on all Posts and Pages
 *
 * @return void
 * @author Jonathan Christopher
 */

function attachments_meta_box()
{
	// for posts
	add_meta_box( 'attachments_list', __( 'Attachments', 'attachments_textdomain' ), 'attachments_add', 'post', 'normal' );
	
	// for pages
	add_meta_box( 'attachments_list', __( 'Attachments', 'attachments_textdomain' ), 'attachments_add', 'page', 'normal' );
}



/**
 * Echos JavaScript that sets some required global variables
 *
 * @return void
 * @author Jonathan Christopher
 */
function attachments_init_js()
{
	echo '<script type="text/javascript" charset="utf-8">';
	echo '	var attachments_base = "' . WP_PLUGIN_URL . '/attachments"; ';
	echo '	var attachments_media = ""; ';
	echo '	Shadowbox.init({ skipSetup:true, onClose:attachments_update }); ';
	echo '</script>';
}



/**
 * Fired when Post or Page is saved. Serializes all attachment data and saves to post_meta
 *
 * @param int $post_id The ID of the current post
 * @return void
 * @author Jonathan Christopher
 */
function attachments_save($post_id)
{
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['attachments_nonce'], plugin_basename(__FILE__) )) {
		return $post_id;
	}

	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
	// to do anything
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	// Check permissions
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	// OK, we're authenticated: we need to find and save the data
	$total_attachments = 0;
	
	// We'll build our array of attachments
	foreach($_POST as $key => $data) {
		
		// Arbitrarily using the location input
		if( substr($key, 0, 20) == 'attachment_location_' )
		{
			$total_attachments++;
		}
		
		// If we have attachments, there's work to do
		if( $total_attachments > 0 )
		{
			$attachments_data = array();
			for ($i=1; $i <= $total_attachments; $i++)
			{
				if( !empty($_POST['attachment_location_' . $i]) )
				{
					$attachment_details = array(
							'title' 			=> $_POST['attachment_title_' . $i],
							'caption' 			=> $_POST['attachment_caption_' . $i],
							'name' 				=> $_POST['attachment_name_' . $i],
							'location' 			=> $_POST['attachment_location_' . $i],
							'mime' 				=> $_POST['attachment_mime_' . $i],
							'id' 				=> $_POST['attachment_id_' . $i],
							'order' 			=> $_POST['attachment_order_' . $i]
						);
					array_push($attachments_data, $attachment_details);
				}
			}
		}
		
	}
	
	// Serialization goodness
	$attachments_serialized = serialize($attachments_data);
	
	update_post_meta($post_id, '_attachments', $attachments_serialized);
}



/**
 * Retrieves all Attachments for provided Post or Page
 *
 * @param int $post_id (optional) ID of target Post or Page, otherwise pulls from global $post
 * @return array $post_attachments
 * @author Jonathan Christopher
 */
function attachments_get_attachments($post_id=null)
{
	global $post;
	
	if($post_id==null)
	{
		$post_id = $post->ID;
	}
	
	$existing_attachments = unserialize(get_post_meta($post_id, '_attachments', true));
	
	if( is_array($existing_attachments) && count($existing_attachments) > 0 )
	{
		$post_attachments = array();
		if( count($existing_attachments) > 1 )
		{
			usort($existing_attachments, "cmp");
		}
		foreach ($existing_attachments as $attachment)
		{
			array_push($post_attachments, array(
				'id' 			=> $attachment['id'],
				'mime' 			=> $attachment['mime'],
				'title' 		=> $attachment['title'],
				'caption' 		=> $attachment['caption'],
				'location' 		=> $attachment['location']
			));
		}
	}
	
	return $post_attachments;
}



/**
 * This is the main initialization function, it will invoke the necessary meta_box
 *
 * @return void
 * @author Jonathan Christopher
 */

function attachments_init()
{
	wp_enqueue_style('shadowbox', WP_PLUGIN_URL . '/attachments/lib/shadowbox/shadowbox.css');
	wp_enqueue_style('attachments', WP_PLUGIN_URL . '/attachments/css/attachments.css');
	wp_enqueue_script('shadowbox', WP_PLUGIN_URL . '/attachments/lib/shadowbox/shadowbox.js');
	wp_enqueue_script('attachments', WP_PLUGIN_URL . '/attachments/js/attachments.js');
	
	attachments_meta_box();
}