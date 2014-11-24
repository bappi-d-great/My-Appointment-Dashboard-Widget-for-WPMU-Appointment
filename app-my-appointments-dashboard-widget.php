<?php
/*
Plugin Name: My appointments dashboard widget
Description: Shows my appointmetns in the dashboard widget
Plugin URI: http://premium.wpmudev.org/project/appointments-plus/
Version: 1.0
AddonType: Dashboard Widget
Author: WPMU DEV (Ash)
*/

class App_my_appointments_dashboard_widget {
	private $_data;
	private $_core;

	private function __construct () {
		
	}

	public static function serve () {
		$me = new App_my_appointments_dashboard_widget;
		$me->_add_hooks();
	}

	private function _add_hooks () {
		add_action('plugins_loaded', array($this, 'initialize'));
		add_action( 'wp_dashboard_setup', array( $this, 'my_app_dashboard_widgets' ) );
	}

	public function initialize () {
		global $appointments;
		$this->_core = $appointments;
		$this->_data = $appointments->options;
	}
	
	public function my_app_dashboard_widgets() {
		wp_add_dashboard_widget(
			'my_app_widget',         // Widget slug.
			'My Appointments',         // Title.
			array( $this, 'my_app_widget_cb' ) // Display function.
	       );
		
	}
	
	public function my_app_widget_cb() {
		global $current_user;
		?>
		<?php echo do_shortcode("[app_my_appointments allow_cancel=0 client_id=".$current_user->ID."]") ?>
		<script type="text/javascript">
		jQuery(function($){
			$('#my_app_widget').prependTo($('#dashboard-widgets'));
		});
		</script>
		<style>
		#my_app_widget table.my-appointments{width: 100%;}
		#my_app_widget table.my-appointments th{text-align: left !important;}
		</style>
		<?php
	}
	
}
App_my_appointments_dashboard_widget::serve();
