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
		$instance = wp_parse_args( (array) $instance, array( 	'down' => array('id' => 1, 'img' => 'not-up.png'), 
																'unknown' => array('id' => 2, 'img' => 'disable.png'),
																'up' => array('id' => 3, 'img' => 'up.png'),
																'size' => 100, 
																'endpoint' => 'default'));
		extract($instance);
		?>
        <div class="ccc_si">
			
        <h4>Service end point</h4> 
				<label  for="<?php echo $this->get_field_name("endpoint"); ?>">Service end point monitored : </label>
				<input id="<?php echo $this->get_field_id('endpoint'); ?>_" name="<?php echo $this->get_field_name('endpoint'); ?>" type="text"  value="<?php if (isset($endpoint)) { echo $endpoint;} ?>" size="35" />


       
        <h4>Status images</h4>    
		<div>

			<p>Enter an image url or use the media uploader and click on 'Insert into post'</p>
			<div>
				<label  for="<?php echo $this->get_field_name("down"); ?>[img]">Not up : </label>
				<input id="<?php echo $this->get_field_id("down"); ?>[img]" type="text" name="<?php echo $this->get_field_name("down"); ?>[img]" value="<?php if (isset($down['img'])) { echo $down['img'];} ?>" size="35" />
				<input  class="cccsi-upload-button button" type="button" value="Upload Image" />    
			</div>

			<div style="margin-top:10px;">
				<label  for="<?php echo $this->get_field_name("unknown"); ?>[img]">Unknown : </label>
				<input id="<?php echo $this->get_field_id("unknown"); ?>[img]" type="text" name="<?php echo $this->get_field_name("unknown"); ?>[img]" value="<?php if (isset($unknown['img'])) { echo $unknown['img'];} ?>" size="35" />
				<input  class="cccsi-upload-button button" type="button" value="Upload Image" />    
			</div>

			<div style="margin-top:10px;">
				<label  for="<?php echo $this->get_field_name("up"); ?>[img]">Up : </label>
				<input id="<?php echo $this->get_field_id("up"); ?>[img]" type="text" name="<?php echo $this->get_field_name("up"); ?>[img]" value="<?php if (isset($up['img'])) { echo $up['img'];} ?>" size="35" />
				<input  class="cccsi-upload-button button" type="button" value="Upload Image" /> 
			</div>		  
		</div>
         <h4>Images size</h4> 
				<label  for="<?php echo $this->get_field_name("size"); ?>">Size in px : </label>
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
