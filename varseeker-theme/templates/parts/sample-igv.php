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
				fastaURL: "/data/canfam3.fasta",
				indexURL: "/data/canfam3.fasta.fai",
				aliasURL: "/data/canfam3.alias",
				tracks: [
					{
						type: "annotation",
						format: "bed",
						name: "Ensembl Genes",
						url: "/data/Canis_familiaris.CanFam3.1.96.bed"
					}
				]
			},
        	locus: "3:40808144-40808455",
        	tracks: [
        		{
        			type: "variant",
        			format: "vcf",
        			url: "/data/varsity.vcf",
        			name: "Variants",
        			displayMode: "COLLAPSED",
        			height: 50
        		},
        		{
        			type: "alignment",
        			format: "bam",
        			name: "<?php echo the_title(); ?>",
        			alignmentRowHeight: 5,
        			height: 150,
        			autoHeight: false,
        			//url: "ftp://ftp.sra.ebi.ac.uk/vol1/run/ERR190/ERR1904271/BU002.cleaned.dedup.bam",
        			//indexURL: "ftp://ftp.sra.ebi.ac.uk/vol1/run/ERR190/ERR1904271/BU002.cleaned.dedup.bam.bai",
        			url: "/data/BoT_33834/BoT_33834.bam",
        			indexURL: "/data/BoT_33834/BoT_33834.bai",
        		}, 
        	]
        };

        igv.createBrowser(igvDiv, options).then(function (browser) {
        		console.log("Created IGV browser");
        })
    });

</script>