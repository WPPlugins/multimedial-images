<script type="text/javascript">
jQuery(document).ready(function(){

var formfield;

	jQuery('#upload_image_button2').click(function() {
		jQuery('html').addClass('Image');
		formfield = jQuery('#upload_image2').attr('name');
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
			
			jQuery('#upload_image2').val(fileurl);
			jQuery('#upload_id2').val(id[1]);
			tb_remove();

			jQuery('html').removeClass('Image');

		} else {
			window.original_send_to_editor(html);
		}
	};
	
  
});
</script>
<form method="post" action="options-general.php?page=mmi">
<label for="upload_image2" class="uimm_label">Click upload to open the uploader. Upload the file. Find &amp; click <strong>insert into post</strong>. Then click Save.</label>
<br />
<input id="upload_image2" type="text" size="36" name="upload_image2" value="" />
<input id="upload_id2" type="hidden" name="upload_id2" value="" />
<input id="upload_image_button2" type="button" value="Upload Image" />
<input name="submit_sl" class="button-primary" type="submit" value="<?php _e('save');?>" />
<div id="box-images-load" style="width:100%;float:left; overflow:hidden; padding:50px 0;">
	<ul> 
	<?php
	foreach($sliders as $sl){
		echo '<li style="width:150px; float:left; padding:5px;"><a href="'.$sl->thumb.'" target="_blank" class="b_ver" title="'.$sl->thumb.'" style="display:block;float:left;"><img src="'.$sl->thumb.'" width="150" /></a> <a href="options-general.php?page=mmi&a=delbg&id='.$sl->id.'" class="b_quit" title="'.$sl->id.'" style="clear:both;">Remove</a></li>';	
	}?>
	</ul>
</div>

</form>
