<?php
//Template Name: VarSITy Analysis

if(isset($_POST['runAnalysis'])){
	//debug_array($_POST);

	/*Array(
    [inputRef] => cf4
    [inputGenomicsDB] => cf4-pastoral
    [caseSamples] => 1403,1744
    [carrierSamples] => 2399
    [controlSamples] => 1488,1634,1375,1376,1338,1636,1637,1638,1471,1639,1640,1641,1642,1643,1644,1366,1472,1377,1645,1646,1647,1320,1648,1649,1473,1438,1439,1411,1412,1044,1053,1443,6032,1480,5104,5105,5106,1465,1483,1032,7987,8068,1397,1398,1429,1430,1635,1185,1475,1207,6034,1486,1679,6035,1043,1358,1504
    [excludeSamples] => 1671,1381,1745
    [runAnalysis] => 
	)*/

	$jobID = createVarsityJob($_POST);
	if($jobID > 0){
		$msg = '<div class="alert alert-success" role="alert"><strong>SUCCESS</strong> - Your VarSITy job number #'.$jobID.' has been created and will be submitted to the HPC shortly.</div>';
	} else {
		$msg = '<div class="alert alert-danger" role="alert"><strong>ERROR</strong> - There was an issue creating your VarSITy job. Please try again or contact Ellen for help.</div>';
	}
	//echo $jobID;
	//exit;
}

get_header();

$GENOMES = getGenomeData();

$samples = getSampleListByRef('cf4');
$samplesByGroup = array();
$dbOptions = array();
foreach($samples as $row){
	if(!isset($samplesByGroup[$row->genomicsDB])){ $samplesByGroup[$row->genomicsDB] = array(); }
	if(!isset($dbOptions[$row->genomicsDB]) && isset($row->genomicsDB) && isset($row->BreedGroup)) { $dbOptions[$row->genomicsDB] = $row->BreedGroup; }
	array_push($samplesByGroup[$row->genomicsDB], $row);
}
ksort($dbOptions);
//debug_array($GENOMES);exit;
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main container-fluid pt-3" role="main">
		<?php if(isset($msg)){ ?><div class="row"><div class="col-12"><?php echo $msg; ?></div></div><?php } ?>
		<form method="post">
			<div class="row">
				<div class="col-md-3">
					<div class="card">
						<div class="card-header" id="headingTwo" style="padding:0px;">
							<h5 class="mb-0 mt-0"><a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Parameters</a></h5>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="form-group col-12">
									<label for="inputRef">Reference Genome</label>
									<select id="inputRef" name="inputRef" class="form-control">
										<option>Choose...</option>
										<?php foreach ($GENOMES as $ref => $genome){ 
											if($ref == 'cf4'){
												echo '<option value="'.$ref.'" selected>'.$genome->Genome.'</option>';
											} else {
												echo '<option value="'.$ref.'">'.$genome->Genome.'</option>';
											}
										}?>
									</select>
									<label for="inputGenomicsDB" class="mt-3">KC Group Database</label>
									<select id="inputGenomicsDB" name="inputGenomicsDB" class="form-control">
										<option selected>Choose...</option>
										<?php foreach ($dbOptions as $value => $text){ 
											echo '<option value="'.$value.'">'.$text.'</option>';
										}?>
									</select>
									<p class="mt-3">
								Module to run<br >
								Inheritance modes
									</p>
									</div>
								</div>
						</div>
					</div>
				</div>
			
				<div class="col-md-9">
					<div class="card-deck">
						<div class="card border-dark mb-3">
							<h3 class="card-header mt-0 container">
								<div class="row align-items-center" style="min-height:40px">
									<div class="col-4">Cases</div>
									<div class="col-6"><!--<input class="form-control sampleFilter" id="filterCases" type="text" placeholder="Search.." data-list="caseList">--></div>
									<div class="col-2"><small class="float-right"><span class="badge badge-secondary" id="caseCount">0</span></small></div>
								</div>
							</h3>
							<ol id="caseList" class="analysisList ml-0 list-group list-group-flush"></ol>		
						</div>
						<div class="card border-dark mb-3">
							<h3 class="card-header mt-0 container">
								<div class="row align-items-center" style="min-height:40px">
									<div class="col-4">Carriers</div>
									<div class="col-6"><!--<input class="form-control sampleFilter" id="filterCases" type="text" placeholder="Search.." data-list="caseList">--></div>
									<div class="col-2"><small class="float-right"><span class="badge badge-secondary" id="carrierCount">0</span></small></div>
								</div>
							</h3>
							<ol id="carrierList" class="analysisList ml-0 list-group list-group-flush"></ol>		
						</div>
					</div>

					<div class="card-deck">
						<div class="card border-dark mb-3">
							<h3 class="card-header mt-0 container">
								<div class="row align-items-center" style="min-height:40px">
									<div class="col-4">Controls</div>
									<div class="col-6">
										<div class="input-group">
											<input class="form-control border rounded-pill sampleFilter py-0" id="filterControls" type="search" placeholder="Search.." data-list="controlList">
										</div>
									</div>
									<div class="col-2"><small class="float-right"><span class="badge badge-secondary" id="controlCount">0</span></small></div>
								</div>
							</h3>
							<ol id="controlList" class="analysisList ml-0 list-group list-group-flush">
								<?php /*foreach ($samplesByGroup['cf4-pastoral'] as $sample){
									echo '<li class="list-group-item" data-id="'.$sample->CGC.'" data-name="'.$sample->BreedCode.' '.$sample->CGCNumber.'" data-breed="'.$sample->BreedCode.'" data-kcgc="'.$sample->CGCNumber.'" data-genDB="'.$sample->genomicsDB.'">'.$sample->BreedCode.' '.$sample->CGCNumber.'</li>';
								}*/ ?>
							</ol>
						</div>
						<div class="card border-dark mb-3">
							<h3 class="card-header mt-0 container">
								<div class="row align-items-center" style="min-height:40px">
									<div class="col-4">Exclude</div>
									<div class="col-6"><!--<input class="form-control sampleFilter" id="filterOmits" type="text" placeholder="Search.." data-list="omitList">--></div>
									<div class="col-2"><small class="float-right"><span class="badge badge-secondary" id="excludeCount">0</span></small></div>
								</div>
							</h3>
							<ol id="excludeList" class="analysisList ml-0 list-group list-group-flush">
							</ol>
						</div>
					</div>
				</div>
			</div>
			
			<input type="hidden" name="caseSamples" id="caseSamples" value="" />
			<input type="hidden" name="carrierSamples" id="carrierSamples" value="" />
			<input type="hidden" name="controlSamples" id="controlSamples" value="" />
			<input type="hidden" name="excludeSamples" id="excludeSamples" value="" />
			<button class="float-right" id="btnRun" name="runAnalysis">Run Analysis!</button>
		</form>

	</main><!-- #main -->

</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_sidebar( 'tertiary' ); ?>

<?php get_footer(); ?>

<script type="text/javascript">
	var sampleList = <?php echo json_encode($samplesByGroup); ?>;
jQuery(function ($) {

	$("#inputGenomicsDB").on("change", function(){
		var value = $(this).val();
		$("ol.analysisList").empty();

		$.each(sampleList[value], function(i,item){
			$('#controlList').append('<li id="sample_'+item.SampleID+'" class="list-group-item" data-id="'+item.CGC+'" data-name="'+item.BreedCode+' '+item.CGCNumber+'" data-breed="'+item.BreedCode+'" data-cgc="'+item.CGC+'" data-sample="'+item.SampleID+'">'+item.BreedCode+' '+item.CGCNumber+'</li>');
    });


		$("#caseCount").text($("#caseList li").length);
		$("#carrierCount").text($("#carrierList li").length);
		$("#controlCount").text($("#controlList li").length);
		$("#excludeCount").text($("#excludeList li").length);
	});

	$("#btnRun").on("click", function(){
		
		var data = list.sortable("serialize").get();
		var cases = [];
		var carriers = [];
		var controls = [];
		var excludes = [];

		data[0].forEach(function (item) { cases.push(item.sample) });
		data[1].forEach(function (item) { carriers.push(item.sample) });
		data[2].forEach(function (item) { controls.push(item.sample) });
		data[3].forEach(function (item) { excludes.push(item.sample) });

		$("#caseSamples").val(cases.join(","));
		$("#carrierSamples").val(carriers.join(","));
		$("#controlSamples").val(controls.join(","));
		$("#excludeSamples").val(excludes.join(","));

		return true;
	})

  $(".sampleFilter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
		//console.log(value);
		var filterList = $(this).data('list');
    $("#"+filterList+" *").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

	$('input[type=search]').on('search', function () {
    // search logic here
    // this function will be executed on click of X (clear button)
		//console.log('X clicked');
		$(".list-group-item").show();
	});



	var list = $("ol.analysisList").sortable({
		group: 'analysisList',
		onDrop: function ($item, container, _super) {
				
			$(".analysisList").each(function(){
				var myList = $(this);
				var listItems = myList.children('li').get();
				listItems.sort(function(a, b) {
					return $(a).data('id').toUpperCase().localeCompare($(b).data('id').toUpperCase());
				});
				myList.empty().append(listItems);
			});
				
			$("#caseCount").text($("#caseList li").length);
			$("#carrierCount").text($("#carrierList li").length);
			$("#controlCount").text($("#controlList li").length);
			$("#excludeCount").text($("#excludeList li").length);
				
			var data = list.sortable("serialize").get();
			var jsonString = JSON.stringify(data, null, ' ');
			console.log(data);
				
			_super($item, container);
		}	
	});
});
</script>