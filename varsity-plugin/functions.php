<?php
/**
* Plugin Name: VarSITy Plugin
* Description: Variant Search and Interogation Tool 
* Version: 0.0.2
* Author: Ellen Schofield
*
* Text Domain: varseeker
*
* @package VarSeeker Plugin
* @category Core
* @author Ellen Schofield
*/

// Include widget/files...
require_once 'posttypes.php';
//require_once 'shortcodes.php';
//require_once 'custom-metaboxes.php';

add_action( 'wp_enqueue_scripts', 'varseeker_enqueue_scripts' );
add_action( 'admin_init', 'fontawesome_dashboard' );


function varseeker_enqueue_scripts() {
	
	//Bootstrap
	wp_register_script ( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', '', '4.3.1', true);

	// DataTables
	//wp_register_script ( 'datatables-js', 'https://cdn.datatables.net/v/bs/dt-1.10.16/b-1.5.1/b-html5-1.5.1/b-print-1.5.1/r-2.2.1/sl-1.2.4/datatables.min.js', array ('jquery', 'pdfmake-js'), '1.10.16', false);
	wp_register_script ( 'datatables-js', "https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js", array ('jquery'), '1.10.18', false);
	
	
	//jQuery Sortable
	wp_register_script ( 'js-sortable', "https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js", array ('jquery'), '0.9.13', false);
	
	//JS Tree
	wp_register_script ( 'js-tree', 'https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/jstree.min.js', array ('jquery'), '3.3.8', false);
		
	//IGV JS
	wp_register_script ( 'igv-js', 'https://cdn.jsdelivr.net/npm/igv@2.3.0/dist/igv.min.js', '', '2.3.0', false);
	
	
	wp_enqueue_script ( 'bootstrap-js' );
	wp_enqueue_script ( 'datatables-js' );
	wp_enqueue_script ( 'js-sortable' );
	wp_enqueue_script ( 'js-tree' );
	
	if ( is_singular('sample') ){ wp_enqueue_script ( 'igv-js' ); }
		
	// Plugin functions js file
	//wp_register_script ( 'js-plugin-functions', plugin_dir_url(__FILE__).'/assets/js/functions.js', array ('jquery'), '0.0.1', false );
	//wp_enqueue_script ( 'js-plugin-functions' );
}

function fontawesome_dashboard() {
	wp_enqueue_style('fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', '', '4.7.0', 'all');
}





?>