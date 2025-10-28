<?php

function debug_array($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function getGenomeData(){
	global $gandalf;

	$genomes = array();
	$results = $gandalf->get_results("SELECT * FROM genomeLookup ORDER BY refGenome", OBJECT );
	foreach ($results as $genome){
		$genomes[$genome->refGenome] = $genome;
	}
	return $genomes;
}

function createVarsityJob($data){
	global $varsity;

	$varsity->insert('jobs', array(
		'Username' => 'es904',
		'Cases' => $data['caseSamples'],
		'noCases' => count(explode(",", $data['caseSamples'])),
		'Carriers' => $data['carrierSamples'],
		'noCarriers' => count(explode(",", $data['carrierSamples'])),
		'Controls' => $data['controlSamples'],
		'noControls' => count(explode(",", $data['controlSamples'])),
		'Ref' => $data['inputRef'],
		'GenomicsDB' => $data['inputGenomicsDB']
	));
	$insert_id = $varsity->insert_id;
	//echo $varsity->last_error."\n";

	return $insert_id;
}

function getAllSamples(){
  global $gandalf;

	$samples = $gandalf->get_results('SELECT SampleID, BreedCode, KCGCNumber AS CGCNumber, CONCAT_WS("_", BreedCode, KCGCNumber) AS CGC, Breed, BreedGroup, BioSample
	FROM sample s INNER JOIN animal a USING (AnimalID) 
	INNER JOIN breedLookup USING (BreedCode)
	WHERE hasWGS=1 
  ORDER BY BreedCode, CGCNumber');

  return $samples;
}

function getSampleListByRef($ref='cf4'){
  global $gandalf;

  $samples = $gandalf->get_results('SELECT SampleID, BreedCode, KCGCNumber AS CGCNumber, CONCAT_WS("_", BreedCode, KCGCNumber) AS CGC, BreedGroup, genomicsDB 
  FROM sample s INNER JOIN animal a USING (AnimalID) 
	INNER JOIN breedLookup USING (BreedCode)
  INNER JOIN sample2wgs USING (SampleID) INNER JOIN wgs_analysis USING (wgsID) 
  WHERE refGenome="'.$ref.'" and genomicsDB IS NOT NULL
  ORDER BY BreedCode, CGCNumber');

  return $samples;
}

/*function getWgsDetails($kcgcNo, $ref='cf4'){
  global $gandalf;
  echo $kcgcNo; exit;

  $sample = array();

  return $sample;
}*/

function getWgsDetails($sampleID, $cgcNo){
	global $gandalf;

	//$sql = "SELECT e.*, '".$cgcNo."' as KCGC FROM sample2wgs INNER JOIN wgs_experiment e USING (wgsExptID) WHERE SampleID=".$sampleID;
	//$experiment = $gandalf->get_results($sql, OBJECT );

	//$sql = "SELECT f.*, '".$cgcNo."' as KCGC FROM sample2wgs INNER JOIN wgs_fastq f USING (wgsID) WHERE SampleID=".$sampleID;
	//$fastq = $gandalf->get_results($sql, OBJECT );

	$sql = "SELECT a.*, '".$cgcNo."' as CGC FROM sample2wgs INNER JOIN wgs_analysis a USING (wgsID) WHERE SampleID=".$sampleID." ORDER BY refGenome";
	$wgs = $gandalf->get_results($sql, OBJECT );

	$sql = "SELECT BioSample, e.*, f.*, '".$cgcNo."' as CGC FROM sample INNER JOIN sample2wgs USING(SampleID) 
	INNER JOIN wgs_experiment e USING (wgsExptID) INNER JOIN wgs_fastq f USING (wgsID) WHERE SampleID=".$sampleID;
	$experiment = $gandalf->get_results($sql, OBJECT );

	//return array('experiment' => $experiment, 'fastq' => $fastq, 'analysis' => $wgs);
	return array('experiment' => $experiment, 'analysis' => $wgs);
}
?>