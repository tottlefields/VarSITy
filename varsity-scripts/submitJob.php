<?php

define('INCLUDE_CHECK',true);
require_once ('varsity-db.php');

$sql = 'SELECT * FROM jobs WHERE JobStatus="created"';
$jobs = queryDatabase($sql);
//print_r($jobs);

if (count($jobs) == 0){ exit; }

foreach ($jobs as $job){
  $conn->query('UPDATE jobs SET JobStatus="submitted" WHERE JobID='.$job['JobID']);
  //print_r($job);

  mkdir($job['JobIdentifier'], 0700);
  $sample_list = fopen($job['JobIdentifier']."/".$job['Module']."-samples.list", "w") or die("Unable to open file!");

  $cases = queryDatabase('SELECT CONCAT_WS("_", BreedCode, KCGCNumber) AS SampleName 
  FROM '.$samples_db.'.sample INNER JOIN '.$samples_db.'.animal USING (AnimalID)
  LEFT OUTER JOIN '.$samples_db.'.breedLookup USING (BreedCode)
  WHERE SampleID IN ('.$job['Cases'].') ORDER BY 1');
  foreach ($cases as $s){ fwrite($sample_list, $s['SampleName']."\tCase\n"); }

  if (isset($job['noCarriers']) && $job['noCarriers'] > 0){
    $carriers = queryDatabase('SELECT CONCAT_WS("_", BreedCode, KCGCNumber) AS SampleName 
    FROM '.$samples_db.'.sample INNER JOIN '.$samples_db.'.animal USING (AnimalID)
    LEFT OUTER JOIN '.$samples_db.'.breedLookup USING (BreedCode)
    WHERE SampleID IN ('.$job['Carriers'].') ORDER BY 1');
    foreach ($carriers as $s){ fwrite($sample_list, $s['SampleName']."\tCarrier\n"); }
  }

  $controls = queryDatabase('SELECT CONCAT_WS("_", BreedCode, KCGCNumber) AS SampleName 
  FROM '.$samples_db.'.sample INNER JOIN '.$samples_db.'.animal USING (AnimalID)
  LEFT OUTER JOIN '.$samples_db.'.breedLookup USING (BreedCode)
  WHERE SampleID IN ('.$job['Controls'].') ORDER BY 1');
  foreach ($controls as $s){ fwrite($sample_list, $s['SampleName']."\tControl\n"); }
  fclose($sample_list);

  $params = fopen($job['JobIdentifier']."/params.conf", "w") or die("Unable to open file!");
  fwrite($params, "REF=".$job['Ref']."\n");
  fwrite($params, "MODULE=".$job['Module']."\n");
  fwrite($params, "GENOMICSDB=".$job['GenomicsDB']."\n");
  fclose($params);
}












?>