<?php

add_action( 'init', 'register_custom_posttypes' );
//add_action( 'admin_menu', 'set_admin_menu_separator' );
add_action( 'admin_head', 'fontawesome_icon_dashboard' );

// Our custom post type function
function register_custom_posttypes() {

	$sample_args = array(
			'labels' => array(
					'name' 				=> __( 'Samples', 'varsity' ),
					'singular_name' 	=> __( 'Sample', 'varsity' ),
					'add_new_item' 		=> __( 'Add New Sample', 'varsity' ),
					'edit_item' 		=> __( 'Edit Sample', 'varsity' ),
					'new_item' 			=> __( 'New', 'varsity' ),
					'view_item' 		=> __( 'View Sample', 'varsity' ),
					'search_items' 		=> __( 'Search', 'varsity' ),
					'not_found' 		=> __( 'No results found.', 'varsity' ),
					'not_found_in_trash' 	=> __( 'No results found.', 'varsity' ),
			),
			'public' 				=> true,
			'show_ui' 				=> true,
			'publicly_queryable' 	=> true,
			'exclude_from_search' 	=> false,
			'hierarchical'			=> false,
			'rewrite'				=> array( 'slug' => get_option('varsity_team_slug','sample') ),
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
				content: \"\\f0c3\";
			}
			</style>'";
}

?>