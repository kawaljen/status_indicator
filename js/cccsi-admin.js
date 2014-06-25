/*
Plugin Name:  Wp ccc status indicator
Author: cccoders
Version : 0.1.1
*/
jQuery(document).ready(function() {
 
    var formfield, imgpreview, 
		host = 'http://localhost/serveur/wordpress/'; //'http://'+jQuery(location).attr('hostname'); 
    
    jQuery('body').on('click','.cccsi-upload-button',function(){
        formfield = jQuery(this).parent().find('input:text'); 
        imgpreview = jQuery(this).parent().find('img'); 

        tb_show('','media-upload.php?TB_iframe=true');
        return false;
    });

    window.old_tb_remove = window.tb_remove;
    window.tb_remove = function() {
        window.old_tb_remove(); 
        formfield=null;
    };
 
 
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor = function(html){
        if (formfield) {
            fileurl = jQuery('img',html).attr('src');
            jQuery(formfield).val(fileurl);
            jQuery(imgpreview).attr("src", fileurl);
            tb_remove();
        } else {
            window.original_send_to_editor(html);
        }
    };
    

	
	jQuery('.ccc_preview').on('error', function(){ 
				jQuery(this).attr('src', host+'/wp-content/plugins/wp-ccc-status-indicator/img/smallthumb.png');
				jQuery(this).next().append('<p class="cccsi_error">! An error occured, check this url.</p>');
		}).attr('src',  jQuery(this).attr('src'));

		
});
