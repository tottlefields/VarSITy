<?php
//Template Name: VarSITy Sample List

$breedGroups = get_terms(array(
    'taxonomy'     => 'dog-breeds',
    'parent'        => 0,
    'number'        => 20,
    'hide_empty'    => false           
));

function get_samples_for_group($breed_group){
	$samples = get_posts(array(
		'post_status'   => 'publish',
		'post_type'      => 'sample',
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'orderby'	=> 'post_title',
		'tax_query' => array(
			array('taxonomy' => 'dog-breeds', 'field' => 'slug', 'terms' => $breed_group )
		)
	));
	return $samples;
}

$all_samples = get_posts(array(
		'post_status'   => 'publish',
		'post_type'      => 'sample',
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'orderby'	=> 'post_title',
	));

$tab_content = '<div class="tab-content" id="groupTabs">
  <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
  <table class="table table-sm mt-4 sampleListTable" id="allTable" style="width:100%">
  <thead><tr><th>Sample</th><th>Breed</th><th>Phenotype</th><th>SNP Count</th><th>Indel Count</th></tr></thead><tbody>';

foreach ($all_samples as $s){
	$term_list = wp_get_post_terms($s->ID, 'dog-breeds', array("fields" => "names"));
	$breed = $term_list[0];
	//print_r($s);
	$phenotype = get_post_meta($s->ID, 'phenotype', true);
	$snp_count = (get_post_meta($s->ID, 'snp_count', true)) ? get_post_meta($s->ID, 'snp_count', true) : 0;
	$indel_count = (get_post_meta($s->ID, 'indel_count', true)) ? get_post_meta($s->ID, 'indel_count', true) : 0;
	$total_vars = $snp_count + $indel_count;
	$snp_count = ($snp_count > 0) ? number_format($snp_count) : '&nbsp';
	$indel_count = ($indel_count > 0) ? number_format($indel_count) : '&nbsp';
	$tab_content .= '
	<tr><td><a href="'.get_permalink($s->ID).'">'.$s->post_title.'</a></td><td>'.$breed.'</td><td>'.$phenotype.'</td><td>'.$snp_count.'</td><td>'.$indel_count.'</td></tr>';
}
  
$tab_content .= '
  </tbody></table>
  </div>';

get_header();
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main container-fluid" role="main">
	
	<ul class="nav nav-tabs mt-3 mb-4">
		<li class="nav-item"><a class="nav-link active" href="#all" data-toggle="tab" id="all-tab">All</a></li>	
		<?php 
		foreach ($breedGroups as $group){
			//echo $group->name;
			$samples = get_samples_for_group($group->slug); 
			echo ' <li class="nav-item"><a class="nav-link" href="#'.$group->slug.'" data-toggle="tab" id="'.$group->slug.'-tab">'.$group->name.'&nbsp;<span class="badge badge-secondary">'.count($samples).'</span></a></li>';
			$tab_content .= '<div class="tab-pane fade" id="'.$group->slug.'" role="tabpanel" aria-labelledby="'.$group->slug.'-tab">...</div>';
		}
		$tab_content .= '</div>';
		?>
	</ul>
	
	<?php echo $tab_content; ?>
	
	<?php //echo '<pre>'; print_r($breedGroups); echo '</pre>'; ?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_sidebar( 'tertiary' ); ?>

<?php get_footer(); ?>

<script type="text/javascript">
jQuery(function ($) {
        $('.sampleListTable').DataTable({
                "ordering": false,
                "pageLength": 50,
                lengthChange: false,
                 dom: "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-10'trip>>"
        });
});
</script>