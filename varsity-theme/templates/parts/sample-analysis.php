<?php
/**
 * The template part for displaying Sample analyses.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#content-slug-php
 *
 * @package Primer
 * @since   1.0.0
 */
 
?>

<div class="row">
	<div class="col"><h3>Sample Analyses</h3>
		<table id="analysisTable" class="table table-sm table-hover" style="font-size:0.8rem;">
		<thead><tr><th>Started</th><th>Researcher</th><th class="text-center">Cases</th><th class="text-center">Controls</th><th class="text-center">Status</th></tr></thead>
		<tbody>
			<tr id="10"><td>20/05/2019 17:10</td><td>eschofield</td><td class="text-center">2</td><td class="text-center">54</td><td class="text-center"><span class="badge badge-pill badge-success">Running</span></td></tr>
			<tr id="8"><td>12/05/2019 11:01</td><td>eschofield</td><td class="text-center">2</td><td class="text-center">50</td><td class="text-center"><span class="badge badge-pill badge-secondary">Completed</span></td></tr>
			<tr id="4"><td>28/04/2019 12:33</td><td>eschofield</td><td class="text-center">1</td><td class="text-center">50</td><td class="text-center"><span class="badge badge-pill badge-secondary">Completed</span></td></tr>
			<tr id="3"><td>28/04/2019 10:26</td><td>eschofield</td><td class="text-center">1</td><td class="text-center">50</td><td class="text-center"><span class="badge badge-pill badge-danger">Error</span></td></tr>
			<tr id="2"><td>28/04/2019 09:15</td><td>eschofield</td><td class="text-center">1</td><td class="text-center">50</td><td class="text-center"><span class="badge badge-pill badge-danger">Error</span></td></tr>
			<tr id="1"><td>20/04/2019 16:54</td><td>eschofield</td><td class="text-center">1</td><td class="text-center">40</td><td class="text-center"><span class="badge badge-pill badge-secondary">Completed</span></td></tr>	
		</tbody>
	</table>
	
	
	
	</div>
	
	<div class="col-8"><h3>Results<small><span id="analysisParams" class="float-right"></span></small></h3>
		<div id="analysisResults"></div>
	</div>
	
</div>

<script type="text/javascript">
jQuery(function ($) {
		$("#analysisTable tr").on('click', function(){
			$("#analysisTable tr").removeClass("selected");
			$(this).addClass("selected");
			$("#analysisParams").html('<p class="text-muted"><strong>Parameters:</strong> 2 cases/54 controls; Recessive Variant; Severity>3;</p>');
			$("#analysisResults").html('<div class="row"><div class="col"><button type="button" class="mt-0 btn btn-block btn-dark" disabled>Severity=5 <span style="top:3px;" class="badge badge-secondary float-right">31</span></button></div><div class="col"><button type="button" class="mt-0 btn btn-block btn-dark" disabled>Severity=4 <span style="top:3px;" class="badge badge-secondary float-right">110</span></button></button></div><div class="col"><button type="button" class="mt-0 btn btn-block btn-light" disabled>Severity=3</button></div><div class="col"><button type="button" class="mt-0 btn btn-block btn-light" disabled>Severity=2</button></div><div class="col"><button type="button" class="mt-0 btn btn-block btn-light" disabled>Severity=1</button></div>');
		});
});
</script>