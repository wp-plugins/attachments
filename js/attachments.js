function attachments_update() {
	jQuery('div#attachments_file_list').html(attachments_media);
}

function init_attachments_sortable() {
	jQuery('div#attachments-list ul').sortable({
		containment: 'parent',
		stop: function(e, ui) {
			jQuery('#attachments-list ul li').each(function(i, id) {
				jQuery(this).find('input.attachment_order').val(i+1);
			});
		}
	});
}

jQuery(document).ready(function() {
	
	// Hook our Browse button
	jQuery('a.browse-attachments').click(function() {
		jQuery.get(attachments_base + '/media.php', function(data) {
			attachments_media = data;
			Shadowbox.open({
				title: 'Attachments',
				player: 'html',
				content: '<div id="attachments-file-list"><p>Available attachments are listed from your <strong>Media Library</strong>. If you need to upload a new attachment, please close this dialog and use the available <strong>Add New</strong> button.</p><p>Select an attachment by clicking its thumbnail. When you\'re done adding attachments, click <strong>Apply</strong></p><p class="attachments-actions"><a href="#" class="attachments-apply button button-highlighted">Apply</a></p><div id="attachments-file-details">' + data + '</div><p class="attachments-actions"><a href="#" class="attachments-apply button button-highlighted">Apply</a></p></div>',
				width:640,
				height:444
			});
		});
		return false;
	});
	
	
	// If there are no attachments, let's hide this thing...
	if(jQuery('div#attachments-list li').length == 0) {
		jQuery('#attachments-list').hide();
	}
	else
	{
		init_attachments_sortable();
	}
		
	
	// Keep track of our browse dialog selections
	jQuery('#attachments-file-details li a').live('click', function() {
		jQuery(this).toggleClass('attachments-selected');
		return false;
	});
	
	
	// Hook our delete links
	jQuery('span.attachment-delete a').live('click', function() {
		attachment_parent = jQuery(this).parent().parent().parent();
		attachment_parent.slideUp(function() {
			attachment_parent.remove();
			jQuery('#attachments-list ul li').each(function(i, id) {
				jQuery(this).find('input.attachment_order').val(i+1);
			});
			if(jQuery('div#attachments-list li').length == 0) {
				jQuery('#attachments-list').slideUp(function() {
					jQuery('#attachments-list').hide();
				});
			}
		});		
		return false;
	});
	
	
	// Hook the all important Apply button
	jQuery('a.attachments-apply').live('click', function() {
		attachment_index = jQuery('li.attachments-file').length;
		new_attachments = '';
		jQuery('a.attachments-selected').each(function() {
			
			attachment_name 		= jQuery(this).find('span.attachment-file-name').text();
			attachment_location 	= jQuery(this).find('span.attachment-file-location').text();
			attachment_id			= jQuery(this).find('span.attachment-file-id').text();
			attachment_thumbnail	= jQuery(this).find('span.attachments-thumbnail').html();
			
			attachment_index++;
			new_attachments += '<li class="attachments-file">';
			new_attachments += '<h2><a href="#" class="attachment-handle"><span class="attachment-handle-icon"><img src="' + attachments_base + '/images/handle.gif" alt="Drag" /></span></a><span class="attachment-name">' + attachment_name + '</span><span class="attachment-delete"><a href="#">Delete</a></span></h2>';
			new_attachments += '<div class="attachments-fields">';
			new_attachments += '<div class="textfield" id="field_attachment_title_' + attachment_index + '"><label for="attachment_title_' + attachment_index + '">Title</label><input type="text" id="attachment_title_' + attachment_index + '" name="attachment_title_' + attachment_index + '" value="" size="20" /></div>';
			new_attachments += '<div class="textfield" id="field_attachment_caption_' + attachment_index + '"><label for="attachment_caption_' + attachment_index + '">Caption</label><input type="text" id="attachment_caption_' + attachment_index + '" name="attachment_caption_' + attachment_index + '" value="" size="20" /></div>';
			new_attachments += '</div>';
			new_attachments += '<div class="attachments-data">';
			new_attachments += '<input type="hidden" name="attachment_name_' + attachment_index + '" id="attachment_name_' + attachment_index + '" value="' + attachment_name + '" />';
			new_attachments += '<input type="hidden" name="attachment_location_' + attachment_index + '" id="attachment_location_' + attachment_index + '" value="' + attachment_location + '" />';
			new_attachments += '<input type="hidden" name="attachment_id_' + attachment_index + '" id="attachment_id_' + attachment_index + '" value="' + attachment_id + '" />';
			new_attachments += '<input type="hidden" class="attachment_order" name="attachment_order_' + attachment_index + '" id="attachment_order_' + attachment_index + '" value="' + attachment_index + '" />';
			new_attachments += '</div>';
			new_attachments += '<div class="attachment-thumbnail"><span class="attachments-thumbnail">';
			new_attachments += attachment_thumbnail;
			new_attachments += '</span></div>';
			new_attachments += '</li>';
		});
		jQuery('div#attachments-list ul').append(new_attachments);
		Shadowbox.close();
		
		if(jQuery('#attachments-list li').length > 0) {

			// We've got some attachments
			jQuery('#attachments-list').show();

			// Cleanup
			jQuery('div#attachments-list ul').sortable('destroy');
			
			// Init sortable
			init_attachments_sortable();
			
		}
	});
	
});