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

$sample_meta = get_post_meta(get_the_ID());
//debug_array($sample_meta);

$data_url = get_post_meta(get_the_ID(), 'data_url', true);
$index_url = get_post_meta(get_the_ID(), 'index_url', true);



?>

<div id="igvBrowser" style="padding-top: 10px;padding-bottom: 10px; border:1px solid lightgray"></div>


<script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function () {

        const igvDiv = document.getElementById("igvBrowser");

        const options = {
        	//genome: "canFam3",
        	//locus: "chr3:40613857-40939685",
        	reference: {
        		id: "canfam3",
				name: "CanFam 3.1",
				fastaURL: "/data/Genomes/canfam3/canfam3.fasta",
				indexURL: "/data/Genomes/canfam3/canfam3.fasta.fai",
				aliasURL: "/data/Genomes/canfam3/canfam3.alias",
				tracks: [
					{
						type: "annotation",
						format: "bed",
						name: "Ensembl Genes",
						url: "/data/Genomes/canfam3/Canis_familiaris.CanFam3.1.98.bed"
					}
				]
			},
        	//locus: "3:40808144-40808455",
		locus: "20:34288468-34288831",
        	tracks: [
        		{
        			type: "variant",
        			format: "vcf",
        			url: "/data/Samples/varsity.vcf",
        			name: "Variants",
        			displayMode: "COLLAPSED",
        			height: 50
        		},
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
        		console.log("Created IGV browser");
        })
    });

</script>
