<?php

/* 
Plugin Name: Wp ccc status indicator
Plugin URI: https://github.com/duncanfwalker/status_indicator
Description: Result of a CCCoders hack
Version : 0.1.1

*/

class ccc_si_widget extends WP_Widget {
	function __construct() {
        
      
        // css and js
        add_action('wp_enqueue_scripts', array(&$this, 'ccc_si_register_scripts'));
        add_action('admin_enqueue_scripts', array(&$this, 'ccc_si_admin_scripts'));
		
		$widget_ops = array('classname' => 'Wp_ccc_status_indicator', 'description' =>'Result of a CCCoders hack');
		$control_ops = array('width' => 300, 'height' => 350);
		$this->WP_Widget('Wp_ccc_status_indicator', 'Status indicator Widget', $widget_ops, $control_ops);
    }	
    
    function ccc_si_admin_scripts($hook) {
        if ($hook != 'widgets.php')
            return;
	    wp_enqueue_style('thickbox');        
		wp_enqueue_script('jquery');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	    wp_register_script('cccsi_widget_admin', plugins_url('js/cccsi-admin.js', __FILE__), array('jquery', 'media-upload','thickbox'));  
		wp_enqueue_script('cccsi_widget_admin');
    }
    function ccc_si_register_scripts() { 
		// JS    
		wp_register_script('cccsi_widget', plugins_url('js/cccsi-widget.js', __FILE__), array('jquery'));     
		wp_localize_script( 'cccsi_widget', 'cccsi',         
			array( 'ajax_url' => admin_url( 'admin-ajax.php' )) 
		);        
		// CSS     
		wp_register_style('cccsi_widget', plugins_url('css/cccsi-widget.css', __FILE__), true);
    }  
    	
	function form( $instance ) {
		$defaultimg= plugins_url('img/smallthumb.png', __FILE__);
		$instance = wp_parse_args( (array) $instance, array( 	'down' => array('message' => ' ' , 'img' => ''), 
																'unknown' => array('message' => ' ', 'img' => ''),
																'up' => array('message' => ' ', 'img' => ''),
																'size' => 100, 
																'endpoint' => 'default'));
		extract($instance);
		?>
        <div class="ccc_si">
			
        <h4>Service end point.</h4> 
				<label  for="<?php echo $this->get_field_name("endpoint"); ?>">Service end point monitored : </label>
				<input id="<?php echo $this->get_field_id('endpoint'); ?>_" name="<?php echo $this->get_field_name('endpoint'); ?>" type="text"  value="<?php if (isset($endpoint)) { echo $endpoint;} ?>" size="35" />


       
        <h4>Status</h4>    
		<div class="ccc_si_upload">

			<p>Enter an image url or use the media and click on 'Insert into post'</p>
			
			<div>
				<h5>Running : </h5>
				<p>Image</p>
				<img src="<?php if(!empty($up['img'])){echo $up['img'];}else{ echo $defaultimg;}?>" alt="preview" class="ccc_preview" width=75 style="border:1px solid #eee; padding:3px; margin:0 auto;"/>
				<div class="clear"></div>			
				<input  class="cccsi-upload-button button" type="button" value="Media/upload" />
				<label  for="<?php echo $this->get_field_name("up"); ?>[img]" style="line-height:26px;">Or enter an url : </label>
				<input id="<?php echo $this->get_field_id("up"); ?>[img]" type="text" name="<?php echo $this->get_field_name("up"); ?>[img]" value="<?php if (isset($up['img'])) { echo $up['img'];} ?>" size="35" style="margin-top:5px;"/> 
				
				<p>Front en message :</p>
				<textarea id="<?php echo $this->get_field_id("up"); ?>[message]"  name="<?php echo $this->get_field_name("up"); ?>[message]"><?php if (isset($up['message'])) { echo $up['message'];} ?></textarea>
			</div>	

			<div style="margin-top:10px;">
				<h5>Disable : </h5>
				<p>Image</p>
				<img src="<?php if (!empty($unknown['img'])) { echo $unknown['img'];}else{ echo $defaultimg;}?>" alt="preview" class="ccc_preview" width=75 style="border:1px solid #eee; padding:3px; margin:0 auto;"/>
				<div class="clear"></div>
				<input  class="cccsi-upload-button button" type="button" value="Media/upload" />    
				<label  for="<?php echo $this->get_field_name("unknown"); ?>[img]" style="line-height:26px;">Or enter an url : </label>
				<input id="<?php echo $this->get_field_id("unknown"); ?>[img]" type="text" name="<?php echo $this->get_field_name("unknown"); ?>[img]" value="<?php if (isset($unknown['img'])) { echo $unknown['img'];} ?>" size="35" style="margin-top:5px;"/>
				<p>Front en message :</p>				
				<textarea id="<?php echo $this->get_field_id("unkown"); ?>[message]"  name="<?php echo $this->get_field_name("unkown"); ?>[message]"><?php if (isset($unknown['message'])) { echo $unknown['message'];} ?></textarea>
			</div>
			
			<div style="margin-top:10px;">
				<h5>Not running : </h5>
				<p>Image</p>
				<img src="<?php if(!empty($down['img'])){echo $down['img'];}else{ echo $defaultimg;}?>" alt="preview" width=75 class="ccc_preview" style="border:1px solid #eee; padding:3px;"/>
				<div class="clear"></div>
				<input  class="cccsi-upload-button button" type="button" value="Media/upload" />  
				<label  for="<?php echo $this->get_field_name("down"); ?>[img]" style="line-height:26px;">Or enter absolute path url : </label>
				<input id="<?php echo $this->get_field_id("down"); ?>[img]" type="text" name="<?php echo $this->get_field_name("down"); ?>[img]" value="<?php if (isset($down['img'])) { echo $down['img'];} ?>" size="35" style="margin-top:5px;"/>    
				<p>Front en message :</p>				
				<textarea id="<?php echo $this->get_field_id("down"); ?>[message]"  name="<?php echo $this->get_field_name("down"); ?>[message]"><?php if (isset($down['message'])) { echo $down['message'];} ?></textarea>			
			</div>
	  
		</div>
         <h4>Options</h4> 
				<label  for="<?php echo $this->get_field_name("size"); ?>">Image size in px : </label>
				<input id="<?php echo $this->get_field_id('size'); ?>_" name="<?php echo $this->get_field_name('size'); ?>" type="number" min="10" step="10" value="<?php echo $size; ?>" />	

		</div><!--end cccsi -->
		<?php 
	}		
	
	function update( $new_instance, $old_instance ) {	
		$instance = $old_instance;    
		$instance['down'] = $new_instance['down'];
		$instance['unknown'] = $new_instance['unknown'];
		$instance['up'] = $new_instance['up'];
		$instance['size'] = $new_instance['size'];
		$instance['endpoint'] = $new_instance['endpoint'];
		$instance['message'] = $new_instance['message'];
		return $instance;	
	}	
	function widget( $args, $instance ) {	
		extract($args);       
		extract($instance);    
		wp_enqueue_script('cccsi_widget'); 
		wp_enqueue_style('cccsi_widget');  
        
		?>	

		<?php echo $before_widget; ?>
	
		<div class="ccc_si_content" id="<?php echo $widget_id;?>">
		<script type="text/javascript">
			jQuery(function($) {
                widget_config = {
                     'image_id':'status_indicator',
                     'states':  <?php echo json_encode($instance); ?>  ,
                     'status_endpoint':'http://understanding-geek.com/status_indicator/status.php'
                }
				$('#<?php echo $widget_id; ?>').data('args', widget_config);

			});
		</script>
		</div>
		
		<?php echo $after_widget; 
	
	}  
	
	    

}
	
add_action( 'widgets_init', create_function( '', 'register_widget( "ccc_si_widget" );' ) );
?>
