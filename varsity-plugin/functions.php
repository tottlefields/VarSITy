<?php
/**
* Plugin Name: VarSITy Plugin
* Description: Variant Search and Interogation Tool 
* Version: 0.0.2
* Author: Ellen Schofield
*
* Text Domain: varsity
*
* @package varsity Plugin
* @category Core
* @author Ellen Schofield
*/

// Include widget/files...
require_once 'posttypes.php';
//require_once 'shortcodes.php';
//require_once 'custom-metaboxes.php';

add_action( 'wp_enqueue_scripts', 'varsity_enqueue_scripts' );
add_action( 'admin_init', 'fontawesome_dashboard' );


function varsity_enqueue_scripts() {
	
	//Bootstrap
	wp_register_script ( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', '', '4.3.1', true);

	// DataTables
	wp_register_script ( 'datatables', "https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js", array ('jquery'), '1.10.18', false);
	
	
	//jQuery Sortable
	wp_register_script ( 'jquery-sortable', "https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js", array ('jquery'), '0.9.13', false);
	
	//JS Tree
	wp_register_script ( 'jstee', 'https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/jstree.min.js', array ('jquery'), '3.3.8', false);
		
	//IGV JS
	wp_register_script ( 'igv', 'https://cdn.jsdelivr.net/npm/igv@2.15.5/dist/igv.min.js', '', '2.15.5', false);
	
	
	wp_enqueue_script ( 'bootstrap' );
	wp_enqueue_script ( 'datatables' );
	wp_enqueue_script ( 'jquery-sortable' );
	wp_enqueue_script ( 'jstree' );
	
	if ( is_singular('sample') ){ wp_enqueue_script ( 'igv-js' ); }
	//wp_enqueue_script ( 'js-plugin-functions' );
}

function fontawesome_dashboard() {
	wp_enqueue_style('fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', '', '4.7.0', 'all');
}





?>