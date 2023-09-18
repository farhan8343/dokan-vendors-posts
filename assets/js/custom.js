jQuery(document).ready(function(){ 
	
	// Adding New Post 	
    jQuery('.dokan-post-edit-form').submit(function(e){
		e.preventDefault();
        var formData = {
            title : jQuery('#post_title').val(),
            thumbnail : jQuery('#feat_image_id').val(),
            categories : jQuery('#category').val(),
            tags : jQuery('#post_tag').val(),
            short_description : jQuery('#post_excerpt').val(),
            description : jQuery('#post_content').val()
        };
        jQuery.ajax({
            type:'post',
            url: dokan.ajaxurl,
            data: {
                action: 'vendor_save_new_post',
                data: formData 
            },
            success: function(res){
                window.location.href= '/martfury/dashboard/vendor-posts/?message=success';
            }
        });
    });
	
	// Update Post 	
    jQuery('.dokan-update-post-form').submit(function(e){
		e.preventDefault();
        var formData = {
			id : jQuery('#post_id').val(),
            title : jQuery('#post_title').val(),
            thumbnail : jQuery('#feat_image_id').val(),
            categories : jQuery('#category').val(),
            tags : jQuery('#post_tag').val(),
            short_description : jQuery('#post_excerpt').val(),
            description : jQuery('#post_content').val()
        };
        jQuery.ajax({
            type:'post',
            url: dokan.ajaxurl,
            data: {
                action: 'vendor_update_post',
                data: formData 
            },
            success: function(res){
                window.location.href= '/martfury/dashboard/vendor-posts/?message=updated';
            }
        });
    });
	
	// Deleting Post
	jQuery('.delete a').click(function(){
		var id = jQuery(this).attr('data-post-id'); 
		jQuery.ajax({
            type:'post',
            url: dokan.ajaxurl,
            data: {
                action: 'vendor_delete_post',
                id: id
            },
            success: function(res){
                window.location.href= '/martfury/dashboard/vendor-posts/?message=deleted';
            }
        });
	}); 	
});