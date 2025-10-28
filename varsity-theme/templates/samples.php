<?php
//Template Name: VarSITy Sample List


$GENOMES = getGenomeData();
$samples = getAllSamples();

/*$breedGroups = get_terms(array(
    'taxonomy'     => 'dog-breeds',
    'parent'        => 0,
    'number'        => 20,
    'hide_empty'    => false           
));*/

/*function get_samples_for_group($breed_group){
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
}*/

/*$all_samples = get_posts(array(
		'post_status'   => 'publish',
		'post_type'      => 'sample',
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'orderby'	=> 'post_title',
	));*/

$samples_by_group = array();

$tab_content = '<div class="tab-content" id="groupTabs">
  <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="home-tab">
  <table class="table table-sm mt-4 sampleListTable" id="allTable" style="width:100%">
  <thead><tr><th>Sample</th><th>Breed</th><th>BioSample</th><th>Group</th>';
	foreach ($GENOMES as $ref => $genome_details){
		$classes = 'text-center';
		if($genome_details->isPrimary == 0){ $classes .= ' hidden-xs hidden-sm'; }
		$tab_content .= '<th class="'.$classes.'" style="padding-right:0.3rem;">'.strtoupper($ref).'</th>';
	}
	$tab_content .= '</tr></thead><tbody>';

foreach ($samples as $s){
  $wgs = getWgsDetails($s->SampleID, $s->CGCNumber);
	$bam_links = array();
  foreach ($wgs['analysis'] as $analysis){
		if (isset($analysis->enaBam) || $analysis->rdsBam){ 
      //$bam_links[$analysis->refGenome]= (isset($analysis->enaBam)) ? '<a href="javascript:copyToClipboard(\'https://'.$analysis->enaBam.'\')">ENA <i class="fa-regular fa-copy"></i></a>' : '<i class="fa-solid fa-check text-greenLight">'; 
			$bam_links[$analysis->refGenome] = '<i class="fa-solid fa-check text-greenLight">';
		}
	}
	$s->bamLinks = $bam_links;
	$tab_content .= '
	<tr><td><a href="/sample/'.$s->CGC.'">'.str_replace("_", " ", $s->CGC).'</a></td>
	<td>'.$s->Breed.'</td><td><a href="https://www.ebi.ac.uk/ena/browser/view/'.$s->BioSample.'" target="_blank">'.$s->BioSample.'</a></td>
	<td>'.$s->BreedGroup.'</td>';
	foreach ($GENOMES as $ref => $genome_details){
		$classes = 'text-center';
		if($genome_details->isPrimary == 0){ $classes .= ' hidden-xs hidden-sm'; }
		if(isset($bam_links[$ref])){
			$tab_content .= '<td class="'.$classes.'" nowrap>'.$bam_links[$ref].'<span style="display:none">'.$ref.'</span></td>';
    } else {
			$tab_content .= '<td class="'.$classes.'" nowrap></td>';
		}
	} 
	$tab_content .= '</tr>';
	if(isset($s->BreedGroup)){
		if(!isset($samples_by_group[$s->BreedGroup])){ $samples_by_group[$s->BreedGroup] = array(); }
		array_push($samples_by_group[$s->BreedGroup], $s);
	}
	
}
ksort($samples_by_group);
  
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
		foreach ($samples_by_group as $group => $samples){
			//echo $group;
			//$samples = get_samples_for_group($group->slug); 
			echo ' <li class="nav-item"><a class="nav-link" href="#'.$group.'" data-toggle="tab" id="'.$group.'-tab">'.$group.'&nbsp;<span class="badge badge-secondary">'.count($samples).'</span></a></li>';
			$tab_content .= '<div class="tab-pane fade" id="'.$group.'" role="tabpanel" aria-labelledby="'.$group.'-tab">...</div>';
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