<?php
/**
 * The template part for displaying the IGV.js Genome Browser.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#content-slug-php
 *
 * @package Primer
 * @since   1.0.0
 */
 
?>

<?php 

//$sample_meta = get_post_meta(get_the_ID());
//debug_array($sample_meta);

$data_url = get_post_meta(get_the_ID(), 'data_url', true);
$index_url = get_post_meta(get_the_ID(), 'index_url', true);

$wgsDetails = getWgsDetails(get_post_meta(get_the_ID(), 'cgc_number', true), $ref='cf4');
$data_url = 'https://ftp.sra.ebi.ac.uk/vol1/ERZ217/ERZ21782982/BaH_28502-cf4.bam';


?>

<div id="igvBrowser" style="padding-top: 10px;padding-bottom: 10px; border:1px solid lightgray"></div>


<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		const igvDiv = document.getElementById("igvBrowser");
		const options = {
			genome: "canFam4",
			//locus: "chr3:40613857-40939685",
/*{
    "id": "canFam4",
    "name": "Dog (UU_Cfam_GSD_1.0/canFam4)",
    "fastaURL": "https://s3.amazonaws.com/igv.org.genomes/canFam4/canFam4.fa",
    "indexURL": "https://s3.amazonaws.com/igv.org.genomes/canFam4/canFam4.fa.fai",
    "cytobandURL": "https://hgdownload.soe.ucsc.edu/goldenPath/canFam4/database/cytoBandIdeo.txt.gz",
    "aliasURL": "https://s3.amazonaws.com/igv.org.genomes/canFam5/chrAlias.tab.gz",
    "tracks": [
      {
        "name": "Genes",
        "format": "refgene",
        "url": "https://hgdownload.soe.ucsc.edu/goldenPath/canFam4/database/ncbiRefSeq.txt.gz",
        "indexed": false,
        "removable": false,
        "order": 1000000
      }
    ]
  }*/
			/*reference: {
				id: "canfam4",
				name: "CanFam4/UU_Cfam_GSD_1.0",
				fastaURL: "/data/Genomes/canfam4/canfam4.fasta",
				indexURL: "/data/Genomes/canfam4/canfam4.fasta.fai",
				//aliasURL: "/data/Genomes/canfam4/canfam4.alias",
				tracks: [
					{
						type: "annotation",
						format: "bed",
						name: "Ensembl Genes",
						url: "/data/Genomes/canfam4/Canis_familiaris.CanFam3.1.98.bed"
					}
				]
			},*/
			locus: "20:34288468-34288831",
			tracks: [
				/*{
					type: "variant",
					format: "vcf",
					url: "/data/Samples/varsity.vcf",
					name: "Variants",
					displayMode: "COLLAPSED",
					height: 50
				},*/
		<?php 
		if (isset($data_url) && $data_url != ''){ ?>
				{
					type: "alignment",
					format: "bam",
					name: "<?php echo the_title(); ?>",
					alignmentRowHeight: 5,
					height: 150,
					autoHeight: false,
					url: "<?php echo $data_url; ?>",
					indexURL: "<?php echo $index_url; ?>",
				}, 
			<?php } ?>
      ]
  	};
		
		igv.createBrowser(igvDiv, options).then(function (browser) {
			igv.browser = browser;
			console.log("Created IGV browser");
		})
	});
</script>
