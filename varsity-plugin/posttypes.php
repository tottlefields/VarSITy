<?php

add_action( 'init', 'register_custom_posttypes' );
add_action( 'admin_menu', 'set_admin_menu_separator' );
add_action( 'admin_head', 'fontawesome_icon_dashboard' );

// Our custom post type function
function register_custom_posttypes() {

	$sample_args = array(
			'labels' => array(
					'name' 				=> __( 'Samples', 'varseeker' ),
					'singular_name' 	=> __( 'Sample', 'varseeker' ),
					'add_new_item' 		=> __( 'Add New Sample', 'varseeker' ),
					'edit_item' 		=> __( 'Edit Sample', 'varseeker' ),
					'new_item' 			=> __( 'New', 'varseeker' ),
					'view_item' 		=> __( 'View Sample', 'varseeker' ),
					'search_items' 		=> __( 'Search', 'varseeker' ),
					'not_found' 		=> __( 'No results found.', 'varseeker' ),
					'not_found_in_trash' 	=> __( 'No results found.', 'varseeker' ),
			),
			'public' 				=> true,
			'show_ui' 				=> true,
			'publicly_queryable' 	=> true,
			'exclude_from_search' 	=> false,
			'hierarchical'			=> false,
			'rewrite'				=> array( 'slug' => get_option('varseeker_team_slug','sample') ),
			'supports' 				=> array( 'title', 'author', 'custom-fields' ),
			'has_archive' 			=> false,
			'show_in_nav_menus' 	=> true,
			'menu_icon' 			=> 'dashicons-shield',
			'menu_position'			=> 30,
	);
	
	register_post_type('sample',  $sample_args);	
	
	register_taxonomy('dog-breeds', array('sample'),
			array(
					'hierarchical' => true,
					'label' => 'Dog Breeds',
					'singular_label' => 'Dog Breed',
					'rewrite' => true,
					'capabilities' => array(
							'assign_terms' => 'read'
					)
			)
	);

}


function set_admin_menu_separator() { do_action( 'admin_init', 29 ); }

function fontawesome_icon_dashboard() {
	echo "<style type='text/css' media='screen'>
			#adminmenu #menu-posts-sample div.wp-menu-image:before {
				font-family: Fontawesome !important;
				content: '\\f0c3';
			}";
}

?>