<?php

/* 
Plugin Name: Wp ccc status indicator
Plugin URI: https://github.com/duncanfwalker/status_indicator
Description: Result of a CCCoders hack
Version : 0.1.1

*/

//php storm
class ccc_si_widget extends WP_Widget {
	function __construct() {
        
      
        // css
        add_action('wp_enqueue_scripts', array(&$this, 'ccc_si_register_scripts'));
        add_action('admin_enqueue_scripts', array(&$this, 'ccc_si_admin_scripts'));
		
		$widget_ops = array('classname' => 'Wp_ccc_status_indicator', 'description' =>'Result of a CCCoders hack');
		$control_ops = array('width' => 300, 'height' => 350);
		$this->WP_Widget('Wp_ccc_status_indicator', 'Status indicator Widget', $widget_ops, $control_ops);
    }	
    
    function ccc_si_admin_scripts($hook) {
        if ($hook != 'widgets.php')
            return;
        wp_register_script('ccc_si_widget_admin', plugins_url('js/cccsi-admin.js', __FILE__), array('jquery'));  
        wp_enqueue_script('ccc_si_widget_admin');
    }
    function ccc_si_register_scripts() { 
		// JS    
		wp_register_script('ccc_si_widget', plugins_url('js/cccsi-widget.js', __FILE__), array('jquery'));     
		wp_localize_script( 'ccc_si_widget', 'oxford',         
			array( 'ajax_url' => admin_url( 'admin-ajax.php' )) 
		);        
		// CSS     
		wp_register_style('ccc_si', plugins_url('css/cccsi-widget.css', __FILE__), true);
    }  
    	
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 	'notrunning' => array('id' => 1, 'img' => 'not-running.png'), 
																'disable' => array('id' => 2, 'img' => 'disable.png'), 
																'running' => array('id' => 3, 'img' => 'running.png') ));
		extract($instance);
		?>
        <div class="ccc_si">
        
        <h4>Images</h4>
        
		<div>

			<div >
				<label  for="<?php echo $this->get_field_name("notrunning"); ?>[img]">Not running : </label>
				<input type="text" class="text" id="<?php echo $this->get_field_id("notrunning"); ?>[img]" name="<?php echo $this->get_field_name("notrunning"); ?>[img]" size="12" value="<?php if (isset($notrunning['img'])) { echo $notrunning['img'];} ?>" />				
			</div>

			<div >
				<label  for="<?php echo $this->get_field_name("disable"); ?>[img]">Disable : </label>
				<input type="text" class="text" id="<?php echo $this->get_field_id("disable"); ?>[img]" name="<?php echo $this->get_field_name("disable"); ?>[img]" size="12" value="<?php if (isset($disable['img'])) { echo $disable['img'];} ?>" />				
			</div>

			<div >
				<label  for="<?php echo $this->get_field_name("running"); ?>[img]">Running : </label>
				<input type="text" class="text" id="<?php echo $this->get_field_id("running"); ?>[img]" name="<?php echo $this->get_field_name("running"); ?>[img]" size="12" value="<?php if (isset($running['img'])) { echo $running['img'];} ?>" />				
			</div>			  
		</div>
        <div class="clear"></div>


		</div><!--end oxford thing  -->
		<?php 
	}		
	
	function update( $new_instance, $old_instance ) {	
		$instance = $old_instance;    
		$instance['notrunning'] = $new_instance['notrunning'];
		$instance['disable'] = $new_instance['disable'];
		$instance['running'] = $new_instance['running'];
		return $instance;	
	}	
	function widget( $args, $instance ) {	
		extract($args);     
		extract($instance);    
		wp_enqueue_script('ccc_si_widget'); 
		wp_enqueue_style('ccc_si_widget');  
        
		?>	
		<div class="ccc_si_content">		
				<!-- add front end content here -->
		</div>   
		<script type="text/javascript">  
			jQuery(function($) {    
				$('#<?php echo $widget_id; ?>_content').data('args', <?php echo json_encode($instance); ?>);  
			});  
		</script>  
<?php 	
	}  
	
	    

}
	
add_action( 'widgets_init', create_function( '', 'register_widget( "ccc_si_widget" );' ) );
//add_action( 'widgets_init', function(){ register_widget( 't2A_widget' );}); +++ PHP 5.3+ only


?>
