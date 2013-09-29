<?php
/*
Plugin Name: Costing Resource Calculators
Plugin URI: http://www.coreymcmahon.com/
Description: An extensible framework for embedding dynamic calculators in Wordpress.
Version: 1.0
Author: Corey McMahon
Author URI: http://www.coreymcmahon.com/
*/

require_once(dirname(__FILE__) . '/bootstrap.php');

/* set up dependencies */
add_action( 'wp_enqueue_scripts', 'cm_costing_resource_enqueue_scripts' );
function cm_costing_resource_enqueue_scripts() {

    wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
    wp_enqueue_script('amcharts', plugins_url('assets/js/amcharts.js', __FILE__));
    wp_enqueue_script('jqueryui', plugins_url('assets/js/jquery-ui.js', __FILE__));
    wp_enqueue_script('jquery.loadmask', plugins_url('assets/js/jquery.loadmask.min.js', __FILE__));
    wp_enqueue_script('cm_costing_resource_js', plugins_url('assets/js/scripts.js', __FILE__));

    foreach (CostingResource\Settings::getNamespaces() as $namespace => $name) {
		wp_enqueue_script('cm_costing_resource_' . $namespace . 'js', plugins_url('assets/js/calculators/' . $namespace . '.js', __FILE__));    	
    }

    wp_enqueue_style('cm_costing_resource_style_css', plugins_url('assets/css/styles.css', __FILE__));
    wp_enqueue_style('cm_costing_resource_loadmask_css', plugins_url('assets/css/jquery.loadmask.css', __FILE__));

}

/* set up / configure shortcode */
add_shortcode('costing_resource_calculator', 'cm_costing_resource_shorttag' );
function cm_costing_resource_shorttag($atts) 
{
    // only display on single posts / pages
    if (is_singular()) {
        ob_start(); 
?>
        <div id="costing-resource-container"></div>
		<script>
		(function ($) {
			$(function () {
				$.get('front.php').success(function (data) {
					$('#costing-resource-container').html(data);
				});
			});
		} (jQuery));
		</script>
<?php 
        return ob_get_clean();
    }
}