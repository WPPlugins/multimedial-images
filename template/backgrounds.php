<script type="text/javascript">
jQuery(document).ready(function(){

var formfield;

	jQuery('#upload_image_button').click(function() {
		jQuery('html').addClass('Image');
		formfield = jQuery('#upload_image').attr('name');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	});

	// user inserts file into post. only run custom if user started process using the above process
	// window.send_to_editor(html) is how wp would normally handle the received data

	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html){

		if (formfield) {
			fileurl2 = String(jQuery('img',html).attr('class'));
			id = fileurl2.split('wp-image-');
			fileurl = jQuery('img',html).attr('src');
			
			jQuery('#upload_image').val(fileurl);
			jQuery('#upload_id').val(id[1]);
			tb_remove();

			jQuery('html').removeClass('Image');

		} else {
			window.original_send_to_editor(html);
		}
	};
	
  
});
</script>
<form method="post" action="options-general.php?page=mmi">
<label for="upload_image" class="uimm_label">Click upload to open the uploader. Upload the file. Find &amp; click <strong>insert into post</strong>. Then click Save.</label>
<br />
<input id="upload_image" type="text" size="36" name="upload_image" value="" />
<input id="upload_id" type="hidden" name="upload_id" value="" />
<input id="upload_image_button" type="button" value="Upload Image" />
<input name="submit_bg" class="button-primary" type="submit" value="<?php _e('Save');?>" />
<div id="box-images-load" style="width:100%;float:left; overflow:hidden; padding:50px 0;">
	<ul> 
	<?php
	foreach($bgs as $bg){
		echo '<li style="width:150px; float:left; padding:5px;"><a href="'.$bg->thumb.'" target="_blank" class="b_ver" title="'.$bg->thumb.'" style="display:block;float:left;"><img src="'.$bg->thumb.'" width="150" /></a> <a href="options-general.php?page=mmi&a=delbg&id='.$bg->id.'" class="b_quit" title="'.$bg->id.'" style="clear:both;">Remove</a></li>';	
	}?>
	</ul>
</div>

</form>
